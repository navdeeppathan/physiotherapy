<?php

namespace App\Auth;

use Illuminate\Auth\GuardHelpers;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Contracts\Auth\UserProvider;
use Illuminate\Http\Request;

class RobustTokenGuard implements Guard
{
    use GuardHelpers;

    /**
     * The request instance.
     *
     * @var \Illuminate\Http\Request
     */
    protected $request;

    /**
     * The name of the query/input parameter containing the API token.
     *
     * @var string
     */
    protected $inputKey;

    /**
     * The name of the token column in persistent storage.
     *
     * @var string
     */
    protected $storageKey;

    /**
     * Indicates if the token is typically hashed in storage.
     *
     * @var bool
     */
    protected $hash = true;

    public function __construct(
        UserProvider $provider,
        Request $request,
        $inputKey = 'api_token',
        $storageKey = 'api_token',
        $hash = true
    ) {
        $this->provider = $provider;
        $this->request = $request;
        $this->inputKey = $inputKey;
        $this->storageKey = $storageKey;
        $this->hash = $hash;
    }

    /**
     * Get the currently authenticated user.
     *
     * @return \Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function user()
    {
        if (!is_null($this->user)) {
            return $this->user;
        }

        $token = $this->getTokenForRequest();

        if (empty($token)) {
            return null;
        }

        $token = trim((string) $token);

        // 1. First, check with SHA-256 hash (standard plain token from login)
        $hashedToken = hash('sha256', $token);
        $user = $this->provider->retrieveByCredentials([
            $this->storageKey => $hashedToken,
        ]);

        // 2. If not found, check with raw token (in case the mobile client saved or forwarded the DB hash directly)
        if (!$user) {
            $user = $this->provider->retrieveByCredentials([
                $this->storageKey => $token,
            ]);
        }

        // 3. User account status check: ensure inactive or blocked users cannot authenticate
        if ($user) {
            if (isset($user->status) && strtolower($user->status) === 'inactive') {
                return null;
            }
            if (isset($user->is_blocked) && (int) $user->is_blocked === 1) {
                return null;
            }
        }

        return $this->user = $user;
    }

    /**
     * Get the token for the current request across various header and parameter formats.
     *
     * @return string|null
     */
    public function getTokenForRequest()
    {
        // 1. Authorization Header: "Bearer <token>" or "Token <token>" or raw "<token>"
        $authHeader = $this->request->header('Authorization', '');
        if (!empty($authHeader)) {
            if (preg_match('/Bearer\s+(\S+)/i', $authHeader, $matches)) {
                return $matches[1];
            }
            if (preg_match('/Token\s+(\S+)/i', $authHeader, $matches)) {
                return $matches[1];
            }
            $trimmed = trim($authHeader);
            if (!empty($trimmed) && !str_contains($trimmed, ' ')) {
                return $trimmed;
            }
        }

        // 2. Custom headers commonly used in mobile / API requests
        $customHeader = $this->request->header('x-api-token')
            ?: $this->request->header('x-token')
            ?: $this->request->header('api-token')
            ?: $this->request->header('auth-token');

        if (!empty($customHeader)) {
            return trim($customHeader);
        }

        // 3. Query string parameters
        $token = $this->request->query($this->inputKey)
            ?: $this->request->query('token')
            ?: $this->request->query('bearer_token');

        if (!empty($token)) {
            return trim($token);
        }

        // 4. Request input body
        $token = $this->request->input($this->inputKey)
            ?: $this->request->input('token');

        if (!empty($token)) {
            return trim($token);
        }

        // 5. Fallback: getPassword (for basic auth header)
        $password = $this->request->getPassword();
        if (!empty($password)) {
            return trim($password);
        }

        return null;
    }

    /**
     * Validate a user's credentials.
     *
     * @param  array  $credentials
     * @return bool
     */
    public function validate(array $credentials = [])
    {
        $token = $credentials[$this->inputKey] ?? ($credentials['token'] ?? null);

        if (empty($token)) {
            return false;
        }

        $token = trim((string) $token);
        $hashedToken = hash('sha256', $token);

        $user = $this->provider->retrieveByCredentials([$this->storageKey => $hashedToken])
            ?: $this->provider->retrieveByCredentials([$this->storageKey => $token]);

        return !is_null($user);
    }
}
