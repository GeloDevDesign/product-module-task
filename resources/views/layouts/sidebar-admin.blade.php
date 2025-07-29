<!-- Main sidebar -->
<div class="sidebar sidebar-dark primary-background sidebar-main sidebar-expand-lg">
    <div class="navbar navbar-dark secondary-background bg-dark-100 navbar-static border-0">
        <div class="navbar-brand flex-fill wmin-0">
            <a href="{{ route('admin.index') }}" class="d-inline-block">
                <img src="{{ asset('images/site-icon.png') }}" width="40px" class="sidebar-resize-hide" alt="logo-img">
                <img src="{{ asset('images/site-icon.png') }}" width="40px" class="sidebar-resize-show" alt="logo-img">
            </a>
        </div>

        <ul class="navbar-nav align-self-center ml-auto sidebar-resize-hide">
            <li class="nav-item dropdown">
                <button type="button"
                    class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-control sidebar-main-resize d-none d-lg-inline-flex">
                    <i class="icon-transmission"></i>
                </button>

                <button type="button"
                    class="btn btn-outline-light-100 text-white border-transparent btn-icon rounded-pill btn-sm sidebar-mobile-main-toggle d-lg-none">
                    <i class="icon-cross2"></i>
                </button>
            </li>
        </ul>
    </div>
    <!-- Sidebar content -->
    <div class="sidebar-content">


        <!-- Main navigation -->
        <div class="sidebar-section">
            <ul class="nav nav-sidebar" data-nav-type="accordion">

                @if (authUser()->isRegularAdmin())
                    <li class="nav-item">
                        <a href="{{ route('admin.products.index') }}"
                            class="nav-link {{ isActiveMenu(['admin.products.index']) }}">
                            <i class="ph-package"></i>
                            <span>
                                Products
                            </span>
                        </a>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="{{ route('admin.index') }}" class="nav-link {{ isActiveMenu(['admin.index']) }}">
                        <i class="ph-house"></i>
                        <span>
                            Dashboard
                        </span>
                    </a>
                </li>

                @if (authUser()->isAdmin())
                    <li class="nav-item nav-item-submenu">
                        <a class="nav-link">
                            <i class="ph-gear"></i>
                            <span>Settings</span>
                        </a>
                        <ul class="nav-group-sub collapse">
                            <li class="nav-item"><a href="{{ route('admin.general-settings.index') }}"
                                    class="nav-link">General</a></li>
                            <li
                                class="nav-item nav-item-submenu {{ isOpenMenu(['admin.users.index', 'admin.users.create']) }}">
                                <a href="#" class="nav-link">
                                    <span>Admin Users</span>
                                </a>
                                <ul
                                    class="nav-group-sub collapse {{ isShowMenu(['admin.users.index', 'admin.users.create']) }}">
                                    <li class="nav-item"><a href="{{ route('admin.users.index') }}"
                                            class="nav-link {{ isActiveMenu(['admin.users.index']) }}">View Users</a>
                                    </li>
                                    <li class="nav-item"><a href="{{ route('admin.users.create') }}"
                                            class="nav-link {{ isActiveMenu(['admin.users.create']) }}">Add User</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="nav-item"><a href="{{ route('admin.backups.index') }}" class="nav-link">Back
                                    Ups</a></li>
                            <li class="nav-item"><a href="{{ route('admin.audit-logs.index') }}"
                                    class="nav-link">Activity Logs</a></li>
                        </ul>
                    </li>
                @endif

                <li class="nav-item">
                    <a href="javascript:void" class="nav-link" data-bs-target="#logoutConfirm" data-bs-toggle="modal">
                        <i class="ph-sign-out"></i>
                        <span>Log Out</span>
                    </a>
                </li>

                <!-- /page kits -->

            </ul>
        </div>
        <!-- /main navigation -->

    </div>
    <!-- /sidebar content -->

</div>
<!-- /main sidebar -->
