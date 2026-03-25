<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Medical Prayojnam Register</title>
<meta name="viewport" content="width=device-width, initial-scale=1">

<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
    body{
        background:#2260FF;
        min-height:100vh;
        display:flex;
        align-items:center;
        justify-content:center;
        font-family:'Poppins', sans-serif;
        padding:15px;
    }

    .auth-wrapper{
        max-width:900px;
        width:100%;
        background:#fff;
        border-radius:15px;
        overflow:hidden;
        box-shadow:0 15px 40px rgba(0,0,0,.1);
    }

    /* LEFT PANEL */
    .auth-left{
        background:linear-gradient(135deg,#ef6603,#fc8733);
        color:#fff;
        padding:50px;
        position:relative;
        min-height:520px;
    }

    .auth-left::after{
        content:'';
        position:absolute;
        inset:0;
        background-image:
        radial-gradient(circle at 20% 30%,rgba(255,255,255,.2) 2px,transparent 3px),
        radial-gradient(circle at 70% 60%,rgba(255,255,255,.2) 2px,transparent 3px),
        radial-gradient(circle at 40% 80%,rgba(255,255,255,.2) 2px,transparent 3px);
        background-size:150px 150px;
    }

    .auth-left h1{
        font-size:34px;
        font-weight:700;
    }

    .auth-left p{
        opacity:.9;
        margin-top:20px;
        line-height:1.7;
    }

    /* RIGHT PANEL */
    .auth-right{
        padding:60px 50px;
    }

    .auth-right h4{
        font-weight:700;
        color:#ef6603;
    }

    .form-control{
        height:48px;
        border-radius:10px;
        background:#f4f7fb;
        border:none;
    }

    .form-control:focus{
        box-shadow:none;
        border:2px solid #ef6603;
        background:#fff;
    }

    .auth-btn{
        background:#ef6603;
        border:none;
        padding:14px;
        width:100%;
        color:#fff;
        border-radius:30px;
        font-weight:600;
        margin-top:10px;
    }

    .auth-btn:hover{
        background:#1c6ed5;
    }

    /* MOBILE FIXES */
    @media(max-width:768px){
        .auth-left{
            min-height:auto;
            padding:40px 25px;
            text-align:center;
        }

        .auth-right{
            padding:40px 25px;
        }

        .auth-left h1{
            font-size:26px;
        }
    }
</style>
</head>

<body>

<div class="auth-wrapper container-fluid">
    <div class="row g-0">

        <!-- LEFT -->
        <div class="col-lg-6 col-md-6 col-12 auth-left d-flex flex-column justify-content-center text-center">
            <small class="fw-bold">Medical Prayojnam</small>
            <h1 class="mt-4">CREATE ACCOUNT</h1>
            <p>
                Join Medical Prayojnam today.  
                Create your account and start managing your experience with us.
            </p>
        </div>

        <!-- RIGHT -->
        <div class="col-lg-6 col-md-6 col-12 auth-right d-flex flex-column justify-content-center">
            <h4>Register Account</h4>
            <p class="text-muted mb-4">Fill the details below to create your account</p>

            <form method="POST" action="{{ route('admin.register.store') }}">
                @csrf

                <input type="text"
                       name="name"
                       class="form-control mb-3"
                       placeholder="Full Name"
                       value="{{ old('name') }}"
                       required>

                <input type="email"
                       name="email"
                       class="form-control mb-3"
                       placeholder="Email Address"
                       value="{{ old('email') }}"
                       required>

                <input type="password"
                       name="password"
                       class="form-control mb-3"
                       placeholder="Password"
                       required>

                <input type="password"
                       name="password_confirmation"
                       class="form-control mb-3"
                       placeholder="Confirm Password"
                       required>

                <button class="auth-btn">Register</button>
            </form>

            <p class="text-center mt-4 mb-0">
                Already have an account?
                <a href="{{ route('admin.login') }}" class="text-decoration-none fw-semibold " style="color: #ef6603;">
                    Login
                </a>
            </p>
        </div>

    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

{{-- Validation Errors --}}
@if ($errors->any())
<script>
Swal.fire({
    icon: 'error',
    title: 'Registration Failed',
    html: `{!! implode('<br>', $errors->all()) !!}`,
});
</script>
@endif

@if(session('success'))
<script>
Swal.fire({
    icon: 'success',
    title: 'Account Created',
    text: 'Your account has been created successfully!',
});
</script>
@endif

</body>
</html>
