<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/iposta/logo.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/iposta/logo.png') }}" alt="" height="22">
                        </span>
                    </a>

                    <a href="index.html" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="{{ asset('assets/images/iposta/logo.png') }}" alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="{{ asset('assets/images/iposta/logo.png') }}" alt="" height="22">
                        </span>
                    </a>
                </div>

                <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>



                <!-- App Search-->

            </div>

            <!--<span class="badge badge-outline-danger fs-22">IPOSITA MAIL MANAGEMENT SYSTEM </span>-->

            <div class="d-flex align-items-center">
                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user"
                                src="{{ asset('assets/images/iposta/logo.png') }}" alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ auth()->user()->name }}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">
                                    @if (auth()->user()->level == 'register')
                                        Register
                                    @elseif(auth()->user()->level == 'administrative')
                                        Administrative
                                    @elseif(auth()->user()->level == 'driver')
                                        Driver
                                    @elseif(auth()->user()->level == 'cntp')
                                        @if (auth()->user()->cntpoffice == 'perceloffice')
                                            CNTP - PERCEL Office
                                        @elseif(auth()->user()->cntpoffice == 'emscntp')
                                            CNTP - EMS Office
                                        @elseif(auth()->user()->cntpoffice == 'boxoffice')
                                            CNTP - BOX Office
                                        @else
                                            CNTP Office
                                        @endif
                                    @elseif(auth()->user()->level == 'airport')
                                        Airport
                                    @elseif(auth()->user()->level == 'pob')
                                        POB
                                    @elseif(auth()->user()->level == 'branchManager')
                                        Branch Manager
                                    @elseif(auth()->user()->level == 'backOffice')
                                        Back Office
                                    @else
                                        Super Admin
                                    @endif
                                </span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header">Welcome {{ auth()->user()->name }}!</h6>
                        <a class="dropdown-item" href="{{ route('admin.employee.profileEdit') }}"><i
                                class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle">Profile</span></a>

                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item" href="{{ route('admin.logout') }}"><i
                                class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                class="align-middle" data-key="t-logout">Logout</span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
