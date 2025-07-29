<!-- Main navbar -->
<div class="navbar navbar-expand-lg navbar-light">
    <div class="container-fluid">

        <div class="navbar-brand flex-1 flex-lg-0">
            <button class="navbar-toggler sidebar-mobile-main-toggle" type="button">
                <i class="icon-paragraph-justify3"></i>
            </button>
        </div>


        <ul class="nav flex-row justify-content-end order-1 order-lg-2">

            <li class="nav-item nav-item-dropdown-lg dropdown ms-lg-2">
                <a href="#" class="dropdown-toggle navbar-nav-link align-items-center rounded-pill px-3 py-1" data-bs-toggle="dropdown">
                    @if (Auth::check())
                    <div class="{{-- status-indicator-container --}} mr-3 profile-img">
                        <img src="{{ asset(authUser()->profile_pic_path) }}" class="w-32px h-32px rounded-pill" alt="">
                        {{-- <span class="status-indicator bg-success"></span> --}}
                    </div>
                    @endif
                    <span class="mx-lg-2">{{ Auth::check() ? authUser()->first_name : '' }} {{ Auth::check() ? authUser()->last_name : '' }}</span>
                </a>

                <div class="dropdown-menu dropdown-menu-end">
                    {{-- <a href="{{ route('admin.users.edit', authUser()->id) }}" class="dropdown-item"> --}}
                    <a href="{{ route('admin.profile.index') }}" class="dropdown-item">
                        <i class="ph-user-circle me-2"></i>
                        Profile
                    </a>
                    <a href="javascript:void" class="dropdown-item" data-bs-target="#logoutConfirm" data-bs-toggle="modal">
                        <i class="ph-sign-out me-2"></i>
                        Logout
                    </a>
                </div>
            </li>
        </ul>
    </div>
</div>
<!-- /main navbar -->

<x-logout-confirm-modal>
    <div class="mt-2">
        <p class="text-sm text-gray-500">
            Are you sure you want to logout ?
        </p>
    </div>
</x-logout-confirm-modal>

<style>
    .navbar-brand img {
        height: auto;
    }
</style>