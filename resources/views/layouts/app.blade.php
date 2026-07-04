<!DOCTYPE html> 
<html lang="en">
	
<!-- doccure/  30 Nov 2019 04:11:34 GMT -->
<head>

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
		<title>Physiopii</title>
		
		<!-- Favicons -->
		<link type="image/x-icon" href="assets/img/favicon.png" rel="icon">
		
		<!-- Bootstrap CSS -->
		{{-- <link rel="stylesheet" href="assets/css/bootstrap.min.css">
		
		<!-- Fontawesome CSS -->
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
		<link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
		
		<!-- Main CSS -->
		<link rel="stylesheet" href="assets/css/style.css"> --}}
		
		<link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/fontawesome.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/plugins/fontawesome/css/all.min.css') }}">
		<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
	
	</head>
	<body>


    	@yield('content')
    
		{{-- <script src="assets/js/jquery.min.js"></script>
		
		<!-- Bootstrap Core JS -->
		<script src="assets/js/popper.min.js"></script>
		<script src="assets/js/bootstrap.min.js"></script>
		
		<!-- Slick JS -->
		<script src="assets/js/slick.js"></script>

		<!-- SweetAlert2 -->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<!-- Custom JS -->
		<script src="assets/js/script.js"></script> --}}

		<script src="{{ asset('assets/js/jquery.min.js') }}"></script>

		<!-- Bootstrap Core JS -->
		<script src="{{ asset('assets/js/popper.min.js') }}"></script>
		<script src="{{ asset('assets/js/bootstrap.min.js') }}"></script>

		<!-- Slick JS -->
		<script src="{{ asset('assets/js/slick.js') }}"></script>

		<!-- SweetAlert2 -->
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

		<!-- Custom JS -->
		<script src="{{ asset('assets/js/script.js') }}"></script>

		@if(session('success'))
		<script>
		Swal.fire({
			icon: 'success',
			title: 'Success',
			text: @json(session('success')),
			confirmButtonColor: '#09dca4'
		});
		</script>
		@endif

		@if(session('error'))
		<script>
		Swal.fire({
			icon: 'error',
			title: 'Oops...',
			text: @json(session('error')),
			confirmButtonColor: '#e74c3c'
		});
		</script>
		@endif

		@if(session('warning'))
		<script>
		Swal.fire({
			icon: 'warning',
			title: 'Warning',
			text: @json(session('warning')),
			confirmButtonColor: '#f39c12'
		});
		</script>
		@endif

		@if(session('info'))
		<script>
		Swal.fire({
			icon: 'info',
			title: 'Information',
			text: @json(session('info')),
			confirmButtonColor: '#3498db'
		});
		</script>
		@endif

		@if ($errors->any())
		<script>
		Swal.fire({
			icon: 'error',
			title: 'Validation Error',
			html: `{!! implode('<br>', $errors->all()) !!}`
		});
		</script>
		@endif
	</body>

<!-- doccure/  30 Nov 2019 04:11:53 GMT -->
</html>