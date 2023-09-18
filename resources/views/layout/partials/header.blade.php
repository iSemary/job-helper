<header class="topbar" data-navbarbg="skin6">
    <nav class="navbar top-navbar navbar-expand-lg navbar-light">
        <div class="navbar-header" data-logobg="skin6">
            <a class="nav-toggler waves-effect waves-light d-block d-lg-none" href="javascript:void(0)"><i
                    class="ti-menu ti-close"></i></a>
            <div class="navbar-brand">
                <a href="index.html">
                    JOB HELPER
                </a>
            </div>
        </div>
        <div class="navbar-collapse collapse" id="navbarSupportedContent">
            <ul class="navbar-nav float-left me-auto ms-3 ps-1">
                <li class="nav-item d-none d-md-block">
                    <a class="nav-link" href="javascript:void(0)">
                        <div class="customize-input">
                            <select class="custom-select form-control bg-white custom-radius custom-shadow border-0">
                                <option selected="">EN</option>
                                <option value="1">AB</option>
                                <option value="2">AK</option>
                                <option value="3">BE</option>
                            </select>
                        </div>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav float-end">
                <li class="nav-item">
                    <a href="#" class="toggle-sidebar">
                        <i class="fas fa-bars text-primary"></i>
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav float-end">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle"  href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="ms-2 d-none d-lg-inline-block"><span><i class="fas fa-user-circle"></i> Hello,</span> <span class="text-dark">
                                {{ auth()->user()->name }}
                            </span>
                        </span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-end dropdown-menu-right user-dd animated flipInY">
                        <a class="dropdown-item page-switcher" href="#" data-switch-target="{{ route("panel.user.profile.edit") }}">
                            <i class="fas fa-user-cog"></i> My Profile
                        </a>
                        <a class="dropdown-item page-switcher" href="#" data-switch-target="{{ route("panel.user.email-credentials.edit") }}">
                            <i class="fas fa-fingerprint"></i> Email Credentials
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ route('auth.logout') }}">
                            <i class="fas fa-sign-out-alt"></i> Logout
                        </a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>
