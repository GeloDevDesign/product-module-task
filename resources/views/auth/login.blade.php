<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="robots" content="noindex">

	<title>{{ isset($pageTitle) ? $pageTitle : env('APP_NAME') }}</title>

	<!-- Global stylesheets -->
	<link rel="stylesheet" type="text/css" href="{{ asset('limitless/fonts/inter/inter.css') }}">

	<link rel="stylesheet" type="text/css" href="{{ asset('limitless/icons/phosphor/styles.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('limitless/icons/fontawesome/styles.min.css') }}">
	<link rel="stylesheet" type="text/css" href="{{ asset('limitless/css/all.min.css') }}">
	<!-- /global stylesheets -->

	<!-- Core JS files -->
    <script src="{{ asset('limitless/js/jquery/jquery.min.js') }}"></script>
	<script src="{{ asset('limitless/demo/demo_configurator.js') }}"></script>
	<script src="{{ asset('limitless/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
	<!-- /core JS files -->

	<!-- Theme JS files -->
	<script src="{{ asset('limitless/js/app.js') }}"></script>
	<!-- /theme JS files -->

</head>

<body class="bg-dark">

	<!-- Page content -->
	<div class="page-content">

		<!-- Main content -->
		<div class="content-wrapper">

			<!-- Inner content -->
			<div class="content-inner">

				<!-- Content area -->
				<div class="content d-flex justify-content-center align-items-center">

					<!-- Login card -->
					<form class="login-form" method="POST" action="{{ route('login') }}">
                        @csrf

						<div class="card mb-0">
							<div class="card-body">
								<div class="text-center mb-3">
									<div class="d-inline-flex align-items-center justify-content-center mb-4 mt-2">
										<img src="{{ asset('images/site-icon.png') }}" class="h-48px" alt="">
									</div>
									<h5 class="mb-0">Login to your account</h5>
									<span class="d-block text-muted">Enter your credentials below</span>
								</div>

								<div class="mb-3">
									<x-input-label for="email" :value="__('Username')" />
                                    <x-text-input id="email" :icon="'ph-user-circle'"
                                            class="block mt-1 w-full"
                                            type="email" name="email"
                                            placeholder="johndoe@gmail.com"
                                            :value="old('email')" required autofocus autocomplete="username" />

                                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
								</div>

								<div class="mb-3">
									<x-input-label for="password" :value="__('Password')" />

                                    <x-text-input id="password" class="block mt-1 w-full"
                                            type="password"
                                            name="password"
                                            :icon="'ph-lock'"
                                            placeholder="•••••••••••"
                                            required autocomplete="current-password" />

                                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
								</div>

								<div class="d-flex align-items-center mb-3">
									<label class="form-check">
										<input type="checkbox" name="remember" class="form-check-input">
										<span class="form-check-label">Remember</span>
									</label>

                                    @if (Route::has('password.request'))
									<a href="{{ route('password.request') }}" class="ms-auto">Forgot password?</a>
                                    @endif
								</div>

								<div class="mb-3">
									<button type="submit" class="btn btn-primary w-100">Sign in</button>
								</div>

								<div class="text-center text-muted content-divider mb-3">
									<span class="px-2">or sign in with</span>
								</div>

								<div class="text-center mb-3">
									<button type="button" class="btn btn-outline-primary btn-icon rounded-pill border-width-2"><i class="ph-facebook-logo"></i></button>
									<button type="button" class="btn btn-outline-pink btn-icon rounded-pill border-width-2 ms-2"><i class="ph-dribbble-logo"></i></button>
									<button type="button" class="btn btn-outline-secondary btn-icon rounded-pill border-width-2 ms-2"><i class="ph-github-logo"></i></button>
									<button type="button" class="btn btn-outline-info btn-icon rounded-pill border-width-2 ms-2"><i class="ph-twitter-logo"></i></button>
								</div>

								<div class="text-center text-muted content-divider mb-3">
									<span class="px-2">Don't have an account?</span>
								</div>

								<div class="mb-3">
									<a href="#" class="btn btn-light w-100">Sign up</a>
								</div>

								{{-- <span class="form-text text-center text-muted">By continuing, you're confirming that you've read our <a href="#">Terms &amp; Conditions</a> and <a href="#">Cookie Policy</a></span> --}}
							</div>
						</div>
					</form>
					<!-- /login card -->

				</div>
				<!-- /content area -->

			</div>
			<!-- /inner content -->

		</div>
		<!-- /main content -->

	</div>
	<!-- /page content -->


	<!-- Demo config -->
	{{-- <div class="offcanvas offcanvas-end" tabindex="-1" id="demo_config">
		<div class="position-absolute top-50 end-100 visible">
			<button type="button" class="btn btn-primary btn-icon translate-middle-y rounded-end-0" data-bs-toggle="offcanvas" data-bs-target="#demo_config">
				<i class="ph-gear"></i>
			</button>
		</div>

		<div class="offcanvas-header border-bottom py-0">
			<h5 class="offcanvas-title py-3">Demo configuration</h5>
			<button type="button" class="btn btn-light btn-sm btn-icon border-transparent rounded-pill" data-bs-dismiss="offcanvas">
				<i class="ph-x"></i>
			</button>
		</div>

		<div class="offcanvas-body">
			<div class="fw-semibold mb-2">Color mode</div>
			<div class="list-group mb-3">
				<label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-2">
					<div class="d-flex flex-fill my-1">
						<div class="form-check-label d-flex me-2">
							<i class="ph-sun ph-lg me-3"></i>
							<div>
								<span class="fw-bold">Light theme</span>
								<div class="fs-sm text-muted">Set light theme or reset to default</div>
							</div>
						</div>
						<input type="radio" class="form-check-input cursor-pointer ms-auto" name="main-theme" value="light" checked>
					</div>
				</label>

				<label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-2">
					<div class="d-flex flex-fill my-1">
						<div class="form-check-label d-flex me-2">
							<i class="ph-moon ph-lg me-3"></i>
							<div>
								<span class="fw-bold">Dark theme</span>
								<div class="fs-sm text-muted">Switch to dark theme</div>
							</div>
						</div>
						<input type="radio" class="form-check-input cursor-pointer ms-auto" name="main-theme" value="dark">
					</div>
				</label>

				<label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-0">
					<div class="d-flex flex-fill my-1">
						<div class="form-check-label d-flex me-2">
							<i class="ph-translate ph-lg me-3"></i>
							<div>
								<span class="fw-bold">Auto theme</span>
								<div class="fs-sm text-muted">Set theme based on system mode</div>
							</div>
						</div>
						<input type="radio" class="form-check-input cursor-pointer ms-auto" name="main-theme" value="auto">
					</div>
				</label>
			</div>

			<div class="fw-semibold mb-2">Direction</div>
			<div class="list-group mb-3">
				<label class="list-group-item list-group-item-action form-check border-width-1 rounded mb-0">
					<div class="d-flex flex-fill my-1">
						<div class="form-check-label d-flex me-2">
							<i class="ph-translate ph-lg me-3"></i>
							<div>
								<span class="fw-bold">RTL direction</span>
								<div class="text-muted">Toggle between LTR and RTL</div>
							</div>
						</div>
						<input type="checkbox" name="layout-direction" value="rtl" class="form-check-input cursor-pointer m-0 ms-auto">
					</div>
				</label>
			</div>

			<div class="fw-semibold mb-2">Layouts</div>
			<div class="row">
				<div class="col-12">
					<a href="index.html" class="d-block mb-3">
						<img src="https://demo.interface.club/limitless/assets/images/layouts/layout_1.png" class="img-fluid img-thumbnail bg-primary bg-opacity-20 border-primary" alt="">
					</a>
				</div>
				<div class="col-12">
					<a href="../../layout_2/full/index.html" class="d-block mb-3">
						<img src="https://demo.interface.club/limitless/assets/images/layouts/layout_2.png" class="img-fluid img-thumbnail" alt="">
					</a>
				</div>
				<div class="col-12">
					<a href="../../layout_3/full/index.html" class="d-block mb-3">
						<img src="https://demo.interface.club/limitless/assets/images/layouts/layout_3.png" class="img-fluid img-thumbnail" alt="">
					</a>
				</div>
				<div class="col-12">
					<a href="../../layout_4/full/index.html" class="d-block mb-3">
						<img src="https://demo.interface.club/limitless/assets/images/layouts/layout_4.png" class="img-fluid img-thumbnail" alt="">
					</a>
				</div>
				<div class="col-12">
					<a href="../../layout_5/full/index.html" class="d-block mb-3">
						<img src="https://demo.interface.club/limitless/assets/images/layouts/layout_5.png" class="img-fluid img-thumbnail" alt="">
					</a>
				</div>
				<div class="col-12">
					<a href="../../layout_6/full/index.html" class="d-block">
						<img src="https://demo.interface.club/limitless/assets/images/layouts/layout_6.png" class="img-fluid img-thumbnail" alt="">
					</a>
				</div>
			</div>
		</div>

		<div class="border-top text-center py-2 px-3">
			<a href="https://themeforest.net/item/limitless-responsive-web-application-kit/13080328?ref=kopyov" class="btn btn-yellow fw-semibold w-100 my-1" target="_blank">
				<i class="ph-shopping-cart me-2"></i>
				Purchase Limitless
			</a>
		</div>
	</div> --}}
	<!-- /demo config -->

    <script>
        $(document).ready(function() {
            // add eye icon that can be click and will hide/show nearest password input
            // $('input[type="password"]').after('<button type="button" class="toggle-password"><i class="fas fa-eye-slash"></i></button>');
            $('input[type="password"]').after('<button class="btn btn-light mt-1 toggle-password" type="button"><i class="fas fa-eye-slash"></i></button>');
            function hideShowPassword() {
                $('.toggle-password').click(function() {
                    $("input[type='password']").addClass('password-input');
                    var passwordInput = $(this).siblings('input.password-input');
                    var passwordFieldType = passwordInput.attr('type');

                    // Toggle password visibility
                    if (passwordFieldType === 'password') {
                        passwordInput.attr('type', 'text');
                        $(this).find('i').removeClass('fa-eye-slash').addClass('fa-eye');
                    } else {
                        passwordInput.attr('type', 'password');
                        $(this).find('i').removeClass('fa-eye').addClass('fa-eye-slash');
                    }
                });
            }
            hideShowPassword();
        });
    </script>

</body>
</html>
