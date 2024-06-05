
<div class="app-menu navbar-menu">
    @php
    $pob = App\Models\Box::where('customer_id', auth()->guard('customer')->user()->id)->first();
    @endphp
    <!-- LOGO -->
    <div class="navbar-brand-box">
        <!-- Dark Logo-->
        <a href="index.html" class="logo logo-dark">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-dark.png') }}') }}" alt="" height="17">
            </span>
        </a>
        <!-- Light Logo-->
        <a href="index.html" class="logo logo-light">
            <span class="logo-sm">
                <img src="{{ asset('assets/images/logo-sm.png') }}') }}" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="{{ asset('assets/images/logo-light.png') }}') }}" alt="" height="17">
            </span>
        </a>
        <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover"
            id="vertical-hover">
            <i class="ri-record-circle-line"></i>
        </button>
    </div>

    <div id="scrollbar">
        <div class="container-fluid">

            <div id="two-column-menu">
            </div>
            <ul class="navbar-nav" id="navbar-nav">
                <li class="menu-title"><i class="ri-more-fill"></i> <span
                    data-key="t-components">App Menu </span></li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ in_array(Route::currentRouteName(), ['customer.dashboard']) ? 'active' : '' }}" href="{{ route('customer.dashboard') }}">
                        <i class="ri-dashboard-2-line"></i> <span data-key="t-dashboards">Dashboard</span>
                    </a>
                </li> <!-- end Dashboard Menu -->

                <li class="nav-item">
                    <a class="nav-link menu-link {{ in_array(Route::currentRouteName(), ['customer.application.index', 'customer.physicalPob', 'customer.virtualPob','customer.physicalPob.details','customer.virtualPob.details']) ? 'active' : '' }}" href="#sidebarIcons" data-bs-toggle="collapse" role="button"
                        aria-expanded="false" aria-controls="sidebarIcons">
                        <i class="ri-database-line"></i> <span data-key="t-icons">MY P.O BOX</span>
                    </a>
                    <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), ['customer.application.index', 'customer.physicalPob', 'customer.virtualPob','customer.physicalPob.details','customer.virtualPob.details']) ? 'show' : '' }}" id="sidebarIcons">
                        <ul class="nav nav-sm flex-column">
                            {{-- application --}}
                            <li class="nav-item">
                                <a href="{{ route('customer.application.index') }}" class="nav-link {{ Request::routeIs('customer.application.index') ? 'active' : '' }}" data-key="t-remix">Application</a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('customer.physicalPob') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['customer.physicalPob','customer.physicalPob.details']) ? 'active' : '' }}" data-key="t-remix">Physical Box</a>
                            </li>
                            <li class="nav-">
                                <a href="{{ route('customer.virtualPob') }}" class="nav-link {{ in_array(Route::currentRouteName(), ['customer.virtualPob','customer.virtualPob.details']) ? 'active' : '' }}"
                                    data-key="t-boxicons">Virtual Box</a>
                            </li>

                        </ul>
                    </div>
                </li>

                <li class="nav-item">
                    <a class="nav-link menu-link {{ in_array(Route::currentRouteName(), ['customer.mails.index', 'customer.my-contacts.index','customer.mails.details']) ? 'active' : '' }}" href="#sidebarAuth" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="sidebarAuth">
                        <i class="bx bx-cart fs-22"></i> <span data-key="t-authentication">EMS National</span>
                    </a>
                    <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), ['customer.mails.index', 'customer.my-contacts.index','customer.mails.invoice','customer.mails.details']) ? 'show' : '' }}" id="sidebarAuth">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('customer.mails.index') }}" class="nav-link {{ Request::routeIs('customer.mails.index') ? 'active' : ''}}"  role="button" aria-expanded="false" aria-controls="sidebarSignIn" data-key="t-signin"> Dispatch
                                </a>

                            </li>
                            @php
                            $pobox = \App\Models\Box::where('customer_id',auth()->guard('customer')->user()->id)->where('EMSNationalContract','yes')->first();
                            @endphp
                            @if ($pobox)
                            <li class="nav-item">
                                <a href="{{ route('customer.my-contacts.index') }}" class="nav-link {{ Request::routeIs('customer.my-contacts.index') ? 'active' : '' }}"  role="button" aria-expanded="false" aria-controls="sidebarSignUp" data-key="t-signup"> My Contacts
                                </a>
                            </li>
                            {{-- invoice --}}
                            <li class="nav-item">
                                <a href="{{ route('customer.mails.invoice') }}" class="nav-link {{ Request::routeIs('customer.mails.invoice') ? 'active' : '' }}"  role="button" aria-expanded="false" aria-controls="sidebarSignUp" data-key="t-signup"> Invoice
                                </a>
                            </li>
                            @endif




                        </ul>
                    </div>
                </li>

                @if($pob)
                <li class="nav-item">
                    <a class="nav-link menu-link {{ in_array(Route::currentRouteName(), ['customer.mail.index','customer.mail.show','customer.mail.national','customer.mail.nationalShow','customer.mail.homeDelivery']) ? 'active' : '' }}" href="#mails" data-bs-toggle="collapse" role="button" aria-expanded="false" aria-controls="mails">
                        <i class="bx bx-mail-send fs-22"></i> <span data-key="t-authentication">Mails</span>
                    </a>
                    <div class="collapse menu-dropdown {{ in_array(Route::currentRouteName(), ['customer.mail.index','customer.mail.show','customer.mail.national','customer.mail.nationalShow','customer.mail.homeDelivery']) ? 'show' : '' }}" id="mails">
                        <ul class="nav nav-sm flex-column">
                            <li class="nav-item">
                                <a href="{{ route('customer.mail.index') }}" class="nav-link {{ in_array(Route::currentRouteName(),['customer.mail.index','customer.mail.show']) ? 'active' : ''}}"  role="button" aria-expanded="false" aria-controls="sidebarSignIn" data-key="t-signin"> Internation Mails
                                </a>

                            </li>
                            <li class="nav-item">
                                <a href="{{ route('customer.mail.national') }}" class="nav-link {{ in_array(Route::currentRouteName(),['customer.mail.national','customer.mail.nationalShow']) ? 'active' : '' }}"  role="button" aria-expanded="false" aria-controls="sidebarSignUp" data-key="t-signup"> National Mails
                                </a>
                            </li>
                            {{--  home delivery --}}
                            <li class="nav-item">
                                <a href="{{ route('customer.mail.homeDelivery') }}" class="nav-link {{ Request::routeIs('customer.mail.homeDelivery') ? 'active' : '' }}"  role="button" aria-expanded="false" aria-controls="sidebarSignUp" data-key="t-home"> Home Delivery
                                </a>
                            </li>

                        </ul>
                    </div>
                </li>
                @endif


            </ul>
        </div>
        <!-- Sidebar -->
    </div>

    <div class="sidebar-background"></div>
</div>
