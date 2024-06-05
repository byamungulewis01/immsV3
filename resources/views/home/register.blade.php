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
                            <div class="card-body p-4">
                                <div class="text-center mt-2">
                                    <h5 class="text-primary">Create New Account</h5>
                                    <p class="text-muted">Get your free Post Office account now</p>
                                </div>
                                @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
                                    <i class="ri-error-warning-line label-icon"></i><strong>Danger</strong>
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                </div>
                                 @endif
                                <div class="p-2 mt-4">
                                    <form class="needs-validation" method="post" action="{{ route('customer.registerAuth') }}">
                                        @csrf
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                            <input type="text" name="name" class="form-control" id="name" placeholder="Enter your name" required="">
                                            <div class="invalid-feedback">
                                                Please enter name
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="useremail" class="form-label">Email <span class="text-danger">*</span></label>
                                            <input type="email" name="email" class="form-control" id="useremail" placeholder="Enter email address" required="">
                                            <div class="invalid-feedback">
                                                Please enter email
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label" for="password-input">Password</label>
                                            <div class="position-relative auth-pass-inputgroup">
                                                <input type="password" name="password" class="form-control pe-5 password-input" onpaste="return false" placeholder="Enter password" id="password-input" aria-describedby="passwordInput" required="">
                                                <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                                <div class="invalid-feedback">
                                                    Please enter password
                                                </div>
                                            </div>
                                        </div>
                                        <div class="mt-4 mb-3">
                                            <button class="btn btn-success w-100" type="submit">Sign up</button>
                                        </div>

                                        <div class="mb-4">
                                            <p class="mb-0 fs-12 text-muted fst-italic">By registering you agree to the iposita <a href="#" class="text-primary text-decoration-underline fst-normal fw-medium">Terms of Use</a></p>
                                        </div>

                                        <div id="password-contain" class="p-3 bg-light mb-2 rounded">
                                            <h5 class="fs-13">Password must contain:</h5>
                                            <p id="pass-length" class="invalid fs-12 mb-2">Minimum <b>8 characters</b></p>
                                            <p id="pass-lower" class="invalid fs-12 mb-2">At <b>lowercase</b> letter (a-z)</p>
                                            <p id="pass-upper" class="invalid fs-12 mb-2">At least <b>uppercase</b> letter (A-Z)</p>
                                            <p id="pass-number" class="invalid fs-12 mb-0">A least <b>number</b> (0-9)</p>
                                        </div>

                                        <div class="mt-4 text-center">
                                            <p class="mb-0">Already have an account ? <a href="{{ route('home') }}" class="fw-semibold text-primary text-decoration-underline"> Signin </a> </p>
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
