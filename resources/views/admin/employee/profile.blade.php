@extends('layouts.admin.app')
@section('page-name')
    Profile
@endsection
@section('body')
    <div class="profile-foreground position-relative mx-n4 mt-n4">
        <div class="profile-wid-bg">
            <img src="{{ asset('assets/images/profile-bg.jpg') }}" alt="" class="profile-wid-img">
        </div>
    </div>
    <div class="pt-4 mb-4 mb-lg-3 pb-lg-4 profile-wrapper">
        <div class="row g-4">
            <div class="col-auto">
                <div class="avatar-lg">
                    <img src="{{ asset('assets/images/iposta/logo.png') }}" alt="user-img"
                        class="img-thumbnail rounded-circle">
                </div>
            </div>
            <!--end col-->
            <div class="col">
                <div class="p-2">
                    <h3 class="text-white mb-1">{{ $user->name }}</h3>
                    <p class="text-white-75">
                        @if (auth()->user()->level == 'register')
                            Register
                        @elseif(auth()->user()->level == 'administrative')
                            Administrative
                        @elseif(auth()->user()->level == 'driver')
                            Driver
                        @elseif(auth()->user()->level == 'cntp')
                            CNTP
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
                    </p>
                    <div class="hstack text-white-50 gap-1">
                        <div class="me-2"><i
                                class="ri-map-pin-user-line me-1 text-white-75 fs-16 align-middle"></i>Rwanda,
                            {{ $user->branchname->name }}</div>
                        {{-- <div>
                        <i class="ri-building-line me-1 text-white-75 fs-16 align-middle"></i>Themesbrand
                    </div> --}}
                    </div>
                </div>
            </div>
            <!--end col-->
            <div class="col-12 col-lg-auto order-last order-lg-0">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-3">Info</h5>
                        <div class="table-responsive">
                            <table class="table table-borderless mb-0">
                                <tbody>
                                    <tr>
                                        <th class="ps-0" scope="row">Full Name :</th>
                                        <td class="text-muted">{{ $user->name }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Mobile :</th>
                                        <td class="text-muted">{{ $user->phone }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">E-mail :</th>
                                        <td class="text-muted">{{ $user->email }}</td>
                                    </tr>
                                    <tr>
                                        <th class="ps-0" scope="row">Joining Date</th>
                                        <td class="text-muted">{{ $user->created_at->format('d M, Y') }}</td>
                                    </tr>
                                    @if (Route::currentRouteName() == 'admin.employee.profile')
                                        <tr>
                                            <th class="ps-0" scope="row">Role :</th>
                                            <td class="text-muted">
                                                <span @if (!$user->getRoleNames()->count()) class="fst-italic" @endif>
                                                    {{ $user->getRoleNames()->count() == 0 ? 'No Role Assigned' : $user->getRoleNames() }}
                                                </span>
                                            </td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>

                                            {{-- if route is --}}
                                            @if (Route::currentRouteName() == 'admin.employee.profile')
                                                <a href="#openModal" data-bs-toggle="modal"
                                                    class="btn btn-sm btn-primary"><i
                                                        class="ri-edit-box-line align-bottom"></i> Assign Role</a>
                                                <a href="#openPassword" data-bs-toggle="modal"
                                                    class="btn btn-sm btn-warning"><i
                                                        class="ri-lock-line align-bottom"></i> Change Password</a>
                                            @endif
                                            <!-- Modal -->
                                            <div class="modal fade zoomIn" id="openModal" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close" id="deleteRecord-close"
                                                                data-bs-dismiss="modal" aria-label="Close"
                                                                id="btn-close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post"
                                                                action="{{ route('admin.roles.assignRole', $user->id) }}">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="mt-2 text-center">

                                                                    <div class="pt-2 fs-15 mx-4 mx-sm-5">
                                                                        <h4>Assign Role to {{ $user->name }}</h4>
                                                                        <p class="text-muted">
                                                                            {{ $user->name }} will have permissions
                                                                            according to role assigned to
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="col mb-3">
                                                                    {{-- <div class="col mb-3">
                                                              <label for="roles" class="form-label">Select Roles to assign
                                                                <span class="text-danger">@foreach ($user->getRoleNames() as $role){{$role}},@endforeach</span>
                                                              </label>
                                                              <input id="roles" name="roles" class="form-control roles" placeholder=" - Select Roles -" value="@foreach ($user->getRoleNames() as $role){{$role}},@endforeach" required>
                                                            </div> --}}

                                                                    <label for="taginput-choices"
                                                                        class="form-label font-size-13 text-muted">Select
                                                                        Roles to assign</label>
                                                                    <select class="form-control" name="roles[]"
                                                                        id="taginput-choices" multiple>
                                                                        @foreach ($roles as $role)
                                                                            <option value="{{ $role }}"
                                                                                {{ $user->getRoleNames()->contains($role) ? 'selected' : '' }}>
                                                                                {{ $role }}
                                                                            </option>
                                                                        @endforeach
                                                                    </select>


                                                                </div>

                                                                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                                    <button type="button" class="btn w-sm btn-light"
                                                                        data-bs-dismiss="modal">
                                                                        Close
                                                                    </button>
                                                                    <button type="submit" class="btn w-sm btn-primary"
                                                                        id="delete-record">
                                                                        save changes
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end modal -->
                                            <!-- Modal -->
                                            <div class="modal fade zoomIn" id="openPassword" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h4>Change {{ $user->name }}'s Password</h4>

                                                            <button type="button" class="btn-close" id="deleteRecord-close"
                                                                data-bs-dismiss="modal" aria-label="Close"
                                                                id="btn-close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post"
                                                                action="{{ route('admin.employee.changePassword2', $user->id) }}">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="col-lg-12 mb-3">
                                                                    <div>
                                                                        <label for="newpasswordInput" class="form-label">New Password*</label>
                                                                        <input type="password" class="form-control" id="newpasswordInput"
                                                                            placeholder="Enter new password" name="password">
                                                                        {{-- error --}}
                                                                        @error('password')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <!--end col-->
                                                                <div class="col-lg-12">
                                                                    <div>
                                                                        <label for="confirmpasswordInput" class="form-label">Confirm
                                                                            Password*</label>
                                                                        <input type="password" class="form-control" id="confirmpasswordInput"
                                                                            placeholder="Confirm password" name="password_confirmation">
                                                                        {{-- error --}}
                                                                        @error('password_confirmation')
                                                                            <span class="text-danger">{{ $message }}</span>
                                                                        @enderror
                                                                    </div>
                                                                </div>
                                                                <!--end col-->


                                                                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                                    <button type="button" class="btn w-sm btn-light"
                                                                        data-bs-dismiss="modal">
                                                                        Close
                                                                    </button>
                                                                    <button type="submit" class="btn w-sm btn-primary"
                                                                        id="delete-record">
                                                                        save changes
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end modal -->
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div><!-- end card body -->
                </div><!-- end card -->
            </div>
            <!--end col-->
            @if (Route::currentRouteName() == 'admin.employee.profileEdit')
                <div class="col-12 ">
                    <div class="card mt-xxl-n5">
                        <div class="card-header">
                            <ul class="nav nav-tabs-custom rounded card-header-tabs border-bottom-0" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link active" data-bs-toggle="tab" href="#personalDetails" role="tab"
                                        aria-selected="true">
                                        <i class="fas fa-home"></i> Personal Details
                                    </a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link" data-bs-toggle="tab" href="#changePassword" role="tab"
                                        aria-selected="false" tabindex="-1">
                                        <i class="far fa-user"></i> Change Password
                                    </a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body p-4">
                            <div class="tab-content">
                                <div class="tab-pane active" id="personalDetails" role="tabpanel">
                                    <form action="{{ route('admin.employee.profileUpdate') }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="row">
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="phonenumberInput" class="form-label">Phone Number</label>
                                                    <input type="text" class="form-control" id="phonenumberInput"
                                                        name="phone" placeholder="Enter your phone number"
                                                        value="{{ auth()->user()->phone }}">
                                                    {{-- error --}}
                                                    @error('phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-6">
                                                <div class="mb-3">
                                                    <label for="emailInput" class="form-label">Email Address</label>
                                                    <input type="email" class="form-control" id="emailInput"
                                                        name="email" placeholder="Enter your email"
                                                        value="{{ auth()->user()->email }}">
                                                    {{-- error --}}
                                                    @error('email')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-success">Update Info</button>
                                                </div>
                                            </div>


                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>
                                <!--end tab-pane-->
                                <div class="tab-pane" id="changePassword" role="tabpanel">
                                    <form action="{{ route('admin.employee.changePassword') }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <div class="row g-2">
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="oldpasswordInput" class="form-label">Old Password*</label>
                                                    <input type="password" class="form-control" id="oldpasswordInput"
                                                        placeholder="Enter current password" name="old_password">
                                                    {{-- error --}}
                                                    @error('old_password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="newpasswordInput" class="form-label">New Password*</label>
                                                    <input type="password" class="form-control" id="newpasswordInput"
                                                        placeholder="Enter new password" name="password">
                                                    {{-- error --}}
                                                    @error('password')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--end col-->
                                            <div class="col-lg-4">
                                                <div>
                                                    <label for="confirmpasswordInput" class="form-label">Confirm
                                                        Password*</label>
                                                    <input type="password" class="form-control" id="confirmpasswordInput"
                                                        placeholder="Confirm password" name="password_confirmation">
                                                    {{-- error --}}
                                                    @error('password_confirmation')
                                                        <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <!--end col-->

                                            <!--end col-->
                                            <div class="col-lg-12">
                                                <div class="text-end">
                                                    <button type="submit" class="btn btn-success">Change
                                                        Password</button>
                                                </div>
                                            </div>
                                            <!--end col-->
                                        </div>
                                        <!--end row-->
                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>
        <!--end row-->
    </div>
@endsection

@section('css')
    <link rel="stylesheet" href="{{ asset('assets/tagify/tagify.css') }}">
@endsection

@section('script')
    <script src="{{ asset('assets/tagify/tagify.js') }}"></script> <!-- Tagify -->
    <script>
        "use strict";
        ! function() {
            var a = (new Tagify(a), document.querySelector("#roles")),
                //   select roles

                t = [
                    @foreach ($roles as $role)
                        "{{ $role }}",
                    @endforeach
                ],
                a = (new Tagify(a, {
                    whitelist: t,
                    maxTags: 10,
                    dropdown: {
                        maxItems: 20,
                        classname: "tags-inline",
                        enabled: 0,
                        closeOnSelect: !1
                    }
                }));

        }();
    </script>
@endsection
