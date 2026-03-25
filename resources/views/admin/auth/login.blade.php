
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Login</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body{
        background:transparent;
        min-height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        font-family:'Poppins', sans-serif;
        padding:15px;
    }

    .login-wrapper{
        max-width:900px;
        width:100%;
        background:#fff;
        border-radius:15px;
        overflow:hidden;
        box-shadow:0 15px 40px rgba(0,0,0,.1);
    }

    /* LEFT PANEL */
    .login-left{
        background:linear-gradient(135deg,rgb(36, 104, 207),#2260FF);
        color:#fff;
        padding:50px;
        position:relative;
        min-height:520px;
    }

    .login-left::after{
        content:'';
        position:absolute;
        inset:0;
        background-image:
        radial-gradient(circle at 20% 30%,rgba(255,255,255,.2) 2px,transparent 3px),
        radial-gradient(circle at 70% 60%,rgba(255,255,255,.2) 2px,transparent 3px),
        radial-gradient(circle at 40% 80%,rgba(255,255,255,.2) 2px,transparent 3px);
        background-size:150px 150px;
    }

    .login-left h1{
        font-size:34px;
        font-weight:700;
    }

    .login-left p{
        opacity:.9;
        margin-top:20px;
        line-height:1.7;
    }

    /* RIGHT PANEL */
    .login-right{
        padding:60px 50px;
    }

    .login-right h4{
        font-weight:700;
        color:#2260FF;
    }

    .form-control{
        height:48px;
        border-radius:10px;
        background:#f4f7fb;
        border:none;
    }

    .form-control:focus{
        box-shadow:none;
        border:2px solid #2260FF;
        background:#fff;
    }

    .login-btn{
        background:#2260FF;
        border:none;
        padding:14px;
        width:100%;
        color:#fff;
        border-radius:30px;
        font-weight:600;
        margin-top:10px;
    }

    .login-btn:hover{
        background:#1c6ed5;
    }

    /* MOBILE FIXES */
    @media(max-width:768px){
        .login-left{
            min-height:auto;
            padding:40px 25px;
            text-align:center;
        }

        .login-right{
            padding:40px 25px;
        }

        .login-left h1{
            font-size:26px;
        }
    }
</style>
</head>

<body>

<div class="login-wrapper container-fluid">
    <div class="row g-0">

        <!-- LEFT -->
        <div class="col-lg-6 col-md-6 col-12 login-left d-flex flex-column justify-content-center text-center">
            {{-- <small class="fw-bold">Medical Prayojnam</small> --}}
            <h1 class="mt-4">WELCOME BACK</h1>
            <p>Nice to see you again!  
            Enter your credentials to access your account and continue your journey with us.</p>
        </div>

        <!-- RIGHT -->
        <div class="col-lg-6 col-md-6 col-12 login-right d-flex flex-column justify-content-center">
            <h4>Login Account</h4>
            <p class="text-muted mb-4">Enter your email and password to login</p>

            <form method="POST" action="{{ route('admin.login.check') }}">
                @csrf
                <input type="email" name="email" class="form-control mb-3" placeholder="Email ID" required>
                <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>
                <button class="login-btn">Login</button>
            </form>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if(session('success'))
  <script>
    Swal.fire({
        title: 'Login Successful!',
        text: 'You have successfully logged in.',
        icon: 'success',
    });
  </script>
  
@endif

@if (session('error'))
  <script>
    Swal.fire({
        icon: 'error',
        title: 'Login Failed',
        text: 'Invalid email or password',
    });
  </script>
@endif

</body>
</html>

</body>
</html>
