<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="robots" content="noindex">
        <title>{{ isset($pageTitle) ? $pageTitle : 'Laravel' }}</title>

        <!-- Limitless Fonts -->
        <link rel="stylesheet" type="text/css" href="{{ asset('limitless/fonts/inter/inter.css') }}">

        <!-- Limitless CSS -->
        <link rel="stylesheet" type="text/css" href="{{ asset('limitless/css/all.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('limitless/css/animate.min.css') }}">

        <!-- Limitless Icons -->
        <link rel="stylesheet" type="text/css" href="{{ asset('limitless/icons/phosphor/styles.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('limitless/icons/material/styles.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('limitless/icons/icomoon/styles.min.css') }}">
        <link rel="stylesheet" type="text/css" href="{{ asset('limitless/icons/fontawesome/styles.min.css') }}">

        <link rel="stylesheet" type="text/css" href="{{ asset('custom.css') }}">

        <!-- Limitless JS Files -->
        <script src="{{ asset('limitless/js/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('limitless/demo/demo_configurator.js') }}"></script>
        <script src="{{ asset('limitless/js/vendor/tables/datatables/datatables.min.js') }}"></script>
        {{-- <script src="{{ asset('limitless/js/vendor/notifications/noty.min.js') }}"></script> --}}
        {{-- <script src="{{ asset('limitless/demo/pages/extra_noty.js') }}"></script> --}}
        <script src="{{ asset('limitless/js/bootstrap/bootstrap.bundle.min.js') }}"></script>
        <script src="{{ asset('limitless/js/app.js') }}"></script>
        <script src="{{ asset('limitless/js/animations_css3.js') }}"></script>
        {{-- <script src="{{ asset('limitless/demo/pages/datatables_basic.js') }}"></script> --}}
        <script src="{{ asset('limitless/demo/pages/datatables_advanced.js') }}"></script>

        <script src="{{ asset('limitless/js/vendor/ui/moment/moment.min.js') }}"></script>
        <script src="{{ asset('limitless/js/vendor/pickers/daterangepicker.js') }}"></script>
        <script src="{{ asset('limitless/js/vendor/pickers/datepicker.min.js') }}"></script>

        <script src="{{ asset('limitless/js/vendor/editors/ckeditor/ckeditor_classic.js') }}"></script>

        <script src="{{ asset('limitless/js/vendor/forms/inputs/passy.js') }}"></script>
        <script src="{{ asset('limitless/js/vendor/forms/inputs/imask.min.js') }}"></script>
        <script src="{{ asset('limitless/js/vendor/forms/inputs/autosize.min.js') }}"></script>

        <script>
            $(document).ready(function() {
                // Input badges
                const $inputText = $('.text-indicator');
                const $inputLabel = $('.badge-indicator');
                const $inputLabelAbsolute = $('.badge-indicator-absolute');
                const $inputGroup = $('.group-indicator');

                // Output badges
                const $outputText = $('.password-indicator-text');
                const $outputLabel = $('.password-indicator-badge');
                const $outputLabelAbsolute = $('.password-indicator-badge-absolute');
                const $outputGroup = $('.password-indicator-group');

                // Strength meter
                const feedbackText = [
                    {text: '<i class="ph-check me-1"></i> Your password is weak', color: 'text-danger'},
                    {text: '<i class="ph-check me-1"></i> Your password is normal', color: 'text-secondary'},
                    {text: '<i class="ph-shield-check me-1"></i> Your password is good', color: 'text-primary'},
                    {text: '<i class="ph-shield-check me-1"></i> Your password is strong', color: 'text-success'}
                ];
                const feedbackLabel = [
                    {color: 'bg-danger', text: 'Weak'},
                    {color: 'bg-secondary', text: 'Normal'},
                    {color: 'bg-primary', text: 'Good'},
                    {color: 'bg-success', text: 'Strong'}
                ];
                const feedbackGroup = [
                    {color: 'bg-danger border-danger text-white', text: 'Weak'},
                    {color: 'bg-secondary border-secondary text-white', text: 'Normal'},
                    {color: 'bg-primary border-primary text-white', text: 'Good'},
                    {color: 'bg-success border-success text-white', text: 'Strong'}
                ];

                $inputText.passy(function(strength) {
                    $outputText.html(feedbackText[strength].text);
                    $outputText.addClass(feedbackText[strength].color);
                });

                $('.generate-text').on('click', function() {
                    $inputText.passy('generate', 8);

                    setTimeout(() => {
                        let passVal = $inputText.val();
                        $('#password_confirmation').val(passVal);
                    }, 200);
                });
            })
        </script>

        <!-- Scripts -->
        @vite([/* 'resources/css/app.css',  */'resources/js/app.js'])

        @yield('styles')
        <style>
            :root {
                --primary: #252b36;
                --secondary: #333333;
                --tertiary: #9dca01;
                --hovered: #9dca01;
            }

            .primary-color {
                color: var(--primary);
            }

            .secondary-color {
                color: var(--secondary);
            }

            .tertiary-color {
                color: var(--tertiary);
            }

            .primary-background {
                background-color: var(--primary);
            }

            .secondary-background {
                background-color: var(--secondary);
            }

            .tertiary-background {
                background-color: var(--tertiary);
            }

            .guest {
                background-color: #f2f2f2;
            }

            .password-div {
                position: relative;
            }

            /* .password-div .toggle-password {
                position: absolute;
                z-index: 10;
                right: 25px;
                margin-top: -29px;
                padding: 0;
                border: 0;
                background: none;
            } */

            .label-required::after {
                content: ' *';
                color: red;
            }

            .guest-content {
                background-color: white;
                padding: 25px;
                margin-top: 25px;
                border-radius: 20px;
                box-shadow: -1px 5px 5px 0px rgba(0,0,0,0.07);
            }

        </style>
    </head>
    <body class="primary-color">
        <div class="guest d-flex flex-column justify-content-center align-items-center h-100">
            <div>
                <img src="{{ asset('images/site-icon.png') }}" width="80px" alt="logo-img">
            </div>

            <div class="guest-content col-10 col-md-3">
                {{ $slot }}
            </div>
        </div>

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
        @yield('scripts')
    </body>
</html>
