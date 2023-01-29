<header id="topnav">
    <div class="topbar-main">
        <div class="container-fluid">
            <!-- Logo container-->
            <div class="logo">
                <a href="{{ route('home_admin/index') }}" class="logo">
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
                            <img src="{{UserHelper::getUserInfo('','thumbnail')}}"
                                alt="user" class="rounded-circle">
                            <span class="nav-user-title">{{ UserHelper::getUserInfo('', 'fullname') }} </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown  border-0">
                            <!-- item-->
                            <a class="dropdown-item" href="{{route('user_admin/profile')}}"><i
                                    class="mdi mdi-account-circle m-r-5 text-muted"></i> Profile</a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item" href="{{ route('auth_admin/logout') }}"><i
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
                    <li class="has-submenu">
                        <a href="{{ get_admin_url() }}"><i class="dripicons-device-desktop"></i>Dashboard</a>
                    </li>
                    <li class="has-submenu">
                        <a href="{{route('user_admin/index')}}"><i class="dripicons-blog"></i>Manage Users</a>
                        <ul class="submenu">
                            <li>
                                <a href="{{route('user_admin/form')}}">Add new</a>
                            </li>
                            <li>
                                <a href="{{route('user_admin/index')}}">List of User</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><i class="dripicons-blog"></i>Manage Loans</a>
                        <ul class="submenu">
                            <li>
                                <a href="#">Add new</a>
                            </li>
                            <li>
                                <a href="#">List of Loan</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><i class="dripicons-blog"></i>Manage Order</a>
                        <ul class="submenu">
                            <li>
                                <a href="#">Add new</a>
                            </li>
                            <li>
                                <a href="#">List of Order</a>
                            </li>
                        </ul>
                    </li>
                    <li class="has-submenu">
                        <a href="#"><i class="dripicons-blog"></i>MLM System</a>
                        <ul class="submenu">
                            <li class="has-submenu">
                                <a href="#">Levels</a>
                                <ul class="submenu">
                                    <li><a href="{{route('mlm_admin_level/index',['slug' => 'licensed'])}}">License</a></li>
                                    <li><a href="{{route('mlm_admin_level/index',['slug' => 'non-licensed'])}}">Non-License </a></li>
                                </ul>
                            </li>
                          
                        </ul>
                    </li>
                </ul>
                <!-- End navigation menu -->
            </div> <!-- end #navigation -->
        </div> <!-- end container -->
    </div> <!-- end navbar-custom -->
</header>
