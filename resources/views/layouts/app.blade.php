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
        <link rel="stylesheet" type="text/css" href="{{ asset('override.css') }}">

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

        <!-- Scripts -->
        {{-- @vite([/* 'resources/css/app.css',  */'resources/js/app.js']) --}}

        {{-- <style>
            :root {
                --primary: #252b36;
                --secondary: #212730;
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

            .card>.card-header, .card>.card-header i {
                background-color: var(--primary);
                color: #fff;
            }

            table>thead {
                background-color: var(--primary);
            }

            table>thead th {
                color: #ffffff;
            }

            table>tbody tr {
                transition: all .3s ease;
            }

            .table>tbody tr:hover {
                background-color: #ddd;
            }

            table>thead th, table>tbody td {
                padding: 15px !important;
            }

            td.actions .btn i {
                font-size: 12px;
            }

            .modal-header, .modal-header button  {
                color: #fff;
                background-color: var(--secondary);
            }

            .content {
                padding: 40px 20px;
            }

            .btn i{
                font-size: 14px;
            }

            form .btn {
                /* min-width: 140px; */
            }

            .dataTable thead td, .dataTable thead th {
                position: relative;
            }

            /* .dataTable thead .sorting:not(.sorting_desc)::before, .dataTable thead .sorting_asc_disabled::before {
                content: "\f0d7";
                font-family: 'Font Awesome 5 Free';
                font-weight: 900;
                color: #fff;
                position: absolute;
                right: 2%;
            }

            .dataTable thead .sorting:not(.sorting_asc)::before, .dataTable thead .sorting_desc_disabled::after {
                content: "\f0d8";
                font-family: 'Font Awesome 5 Free';
                font-weight: 900;
                color: #fff;
                position: absolute;
                right: 2%;
            } */



            table tr, table td {
                border: 1px solid #d2d2d2;
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

        </style> --}}

        @yield('styles')
    </head>
    <body>
        <!-- Page content -->
        <div class="page-content">
            @include('layouts.sidebar-admin')

            <!-- Main content -->
            <div class="content-wrapper">
                <!-- Page Heading -->
                @if( Auth::check() )
                    @include('layouts.header')
                @endif
                <div class="content-inner">
                     @yield('banner')
                     <div class="content">
                        @php
                            $message = session('status') ?? session('success');
                            $isError = false;

                            if (session('errors')) {
                                $isError = true;
                                $errs = [];
                                $errors = session('errors')->getMessages();

                                if ($errors && count($errors) > 0) {
                                    foreach ($errors as $key => $errList) {
                                        $errs[] = implode(', ', $errList);
                                    }
                                    $message = implode(', ', $errs);
                                } else {
                                    $message = 'Something went wrong, please check and try again.';
                                }
                            }
                        @endphp

                        <x-notification :message="$message" :is-error="$isError"></x-notification>

                        @yield('content')

                     </div>
                </div>
            </div>
            <!-- /main content -->
        </div>
        <!-- /page content -->
        <x-logout-confirm-modal>
            <div class="mt-2">
                <p class="text-sm text-gray-500">
                    Are you sure you want to logout ?
                </p>
            </div>
        </x-logout-confirm-modal>
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
        @yield('componentScripts')
        @yield('adminPanelScripts')
        @yield('scripts')
    </body>
</html>
