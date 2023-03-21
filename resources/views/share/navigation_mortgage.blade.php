@php
    use App\Helpers\License;
    $prefix = get_area();
@endphp
<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">
            <!-- Logo container-->
            <div class="logo">
                <a href="{{ route("{$prefix}/index") }}" class="logo">
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
                            <img src="{{ License::getInfo('', 'thumbnail') }}" alt="user" class="rounded-circle">
                            <span class="nav-user-title">{{ License::getInfo('', 'fullname') }} </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown  border-0">
                            <!-- item-->
                            {{-- <a class="dropdown-item" href="{{route('dashboard_agent/profile')}}"><i
                                    class="mdi mdi-account-circle m-r-5 text-muted"></i> Profile</a>
                            <div class="dropdown-divider"></div> --}}
                            <a class="dropdown-item" href="{{ route("{$prefix}/logout") }}"><i
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
                    <li class="has-submenu"><a href="{{ route("{$prefix}/index") }}"><i
                                class="dripicons-device-desktop"></i>Dashboard</a>
                    </li>
                    {{-- <li class="has-submenu"><a href="{{ route("{$prefix}/loans") }}"><i
                                class="dripicons-device-desktop"></i>My Loans</a>
                    </li> --}}
                    <li class="has-submenu"><a
                            href="{{ route("{$prefix}/downlineAmbassadors", ['slug' => 'mortgage']) }}"><i
                                class="fas fa-user"></i>Downline Ambassadors</a>
                    <li class="has-submenu"><a href="{{ route("{$prefix}/downlineLoans", ['slug' => 'mortgage']) }}"><i
                                class="far fa-folder"></i>Downline Loans</a>
                    </li>




                </ul>
                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>
