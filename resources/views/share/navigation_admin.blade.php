@php
    use App\Helpers\Staff;
@endphp
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">
            <!-- Logo container-->
            <div class="logo">
                <a href="{{route('admin/dashboard/index')}}" class="logo">
                    <img src="{{ get_logo() }}" alt="" height="50">
                </a>
            </div>
            <!-- End Logo container-->
            <div class="menu-extras topbar-custom">
                <ul class="list-unstyled float-right mb-0">
                    <!-- User-->
                    <li class="dropdown notification-list">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect nav-user" data-toggle="dropdown"
                            href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <img src="{{ Staff::getStaffInfo('', 'thumbnail') }}" alt="user" class="rounded-circle">
                            <span class="nav-user-title">{{ Staff::getStaffInfo('', 'fullname') }} </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown  border-0">
                            <!-- item-->
                            {{-- <a class="dropdown-item" href="{{route('dashboard_agent/profile')}}"><i
                                    class="mdi mdi-account-circle m-r-5 text-muted"></i> Profile</a>
                            <div class="dropdown-divider"></div> --}}
                            <a class="dropdown-item" href="{{ get_url('logout') }}"><i
                                    class="mdi mdi-logout m-r-5 text-muted"></i> Logout</a>
                        </div>
                    </li>
                    <li class="menu-item">
                        <!-- Mobile menu toggle-->
                        <a class="navbar-toggle nav-link">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>
                </ul>
            </div>
            <!-- end menu-extras -->
            <div class="clearfix"></div>
        </div> <!-- end container -->
    </div>
    <!-- end topbar-main -->
    <!-- MENU Start -->
    <div class="navbar-custom">
        <div class="container-fluid">
            <div id="navigation">
                <!-- Navigation Menu-->
                <ul class="navigation-menu">
                    <li class="has-submenu"><a href="{{route('admin/dashboard/index')}}"><i
                                class="dripicons-device-desktop"></i>Dashboard</a>
                    </li>
                    <li class="has-submenu"><a href="{{route('admin/ambassadors/index')}}"><i class="fas fa-user"></i>Manage Ambassadors</a>
                        
                    </li>
                    <li>
                        <a href="{{ route('admin/lead/index') }}"><i class="ti-view-grid"></i>Manage
                            Leads</a>
                    </li>
                    <li>
                        <a href="{{ route('admin/application/index') }}"><i class="fab fa-wpforms"></i>Manage
                            Applications</a>
                    </li>
                    <li>
                        <a href="{{ route('admin/product/index') }}"><i class="far fa-folder"></i>Manage Loans</a>
                    </li>
                    <li>
                        <a href="{{ route('admin/ranking/index') }}"><i class="ti-stats-up"></i>Manage Model</a>
                    </li>
                </ul>
                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>
