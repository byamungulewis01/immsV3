@extends('layouts.customer.auth')
@section('page')
Home
@endsection
@section('contents')

<!-- start hero section -->
<section class="section pb-0 mb-5" id="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="card overflow-hidden">
                    <div class="row g-0">
                        @include('home.hero')
                        <!-- end col -->

                        <div class="col-lg-6">
                            <div class="p-lg-5 p-4">
                                <div class="text-center">
                                    <h5 class="text-primary">Welcome Back !</h5>
                                    <p class="text-muted">Sign in to continue Iposita Customer Online Services.</p>
                                </div>

                                @if (session('success'))
                                <div class="alert alert-success alert-dismissible alert-label-icon label-arrow fade show mb-xl-0"
                                    role="alert">
                                    <i class="ri-check-line label-icon"></i><strong>Success</strong>
                                    {{ session('success') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                @endif
                                {{-- session successfull --}}

                                {{-- session error --}}
                                @if (session('error'))
                                <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0"
                                    role="alert">
                                    <i class="ri-close-line label-icon"></i><strong>Error</strong>
                                    {{ session('error') }}
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                                @endif
                                {{-- session error --}}

                                <div class="p-2 mt-4">
                                    <form action="{{ route('customer.loginAuth') }}" method="post">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="username" class="form-label">Email Addrss</label>
                                            <input type="text" name="email" class="form-control" id="username"
                                                placeholder="Enter Email Address">
                                        </div>

                                        <div class="mb-3">
                                            <div class="float-end">
                                                <a href="#" class="text-muted">Forgot
                                                    password?</a>
                                            </div>
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup mb-3">
                                                <input name="password" type="password"
                                                    class="form-control pe-5 password-input"
                                                    placeholder="Enter password" id="password-input">
                                                <button
                                                    class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon"
                                                    type="button" id="password-addon"><i
                                                        class="ri-eye-fill align-middle"></i></button>
                                            </div>
                                        </div>

                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value=""
                                                id="auth-remember-check">
                                            <label class="form-check-label" for="auth-remember-check">Remember
                                                me</label>
                                        </div>

                                        <div class="mt-4">
                                            <button class="btn btn-success w-100" type="submit">Sign In</button>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <p class="mb-0">Don't have an account ? <a
                                                    href="{{ route('register') }}"
                                                    class="fw-semibold text-primary text-decoration-underline"> Signup
                                                 </a> </p>
                                        </div>

                                    </form>
                                </div>

                            </div>
                        </div>
                        <!-- end col -->
                    </div>
                    <!-- end row -->
                </div>
                <!-- end card -->
            </div>
            <!-- end col -->

        </div>
        {{-- <div class="row">
            <div class="col-lg-4">
                <div class="card shadow-none text-center py-3">
                    <div class="card-body py-4">
                        <div class="text-muted">
                            <h1 class="mb-3 lh-base">Online Services</h1>
                            <p class="ff-secondary fs-16 mb-2">The first step in finding your <b>dream job </b> is
                                deciding where to look for first-hand insight. Contact professionals who are already.
                            </p>

                            <div class="vstack gap-2 mb-4 pb-1">
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="avatar-xs icon-effect">
                                            <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                <i class="ri-check-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-0">Dynamic Conetnt</p>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <div class="flex-shrink-0 me-2">
                                        <div class="avatar-xs icon-effect">
                                            <div class="avatar-title bg-transparent text-success rounded-circle h2">
                                                <i class="ri-check-fill"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <p class="mb-0">Setup plugin's information.</p>
                                    </div>
                                </div>

                            </div>

                            <div>
                                <a href="{{ route('customer.login') }}" class="btn btn-primary">Login & Register<i
            class="ri-arrow-right-line align-bottom ms-1"></i></a>
    </div>
    </div>
    </div>
    </div>
    </div>
    @include('home.services')
    </div> --}}
    <!-- end row -->
    </div>
    <!-- end container -->
</section>
<!-- end hero section -->

@endsection
