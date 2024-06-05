@extends('layouts.customer.app')
@section('page') Addressing @endsection
@section('content')

<div class="row">


    <div class="col-xl-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden ms-0">
                        <a class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                @php
                                if ($box->profile == null) {
                                if ($box->pob_type == 'Individual') {
                                $photo = 'assets/images/users/user-dummy-img.jpg';
                                } else {
                                $photo = 'assets/images/users/multi-user.jpg';
                                }
                                } else {
                                $photo = 'images/addressing/'.$box->profile;
                                }
                                @endphp
                                <img src="{{ asset($photo) }}" alt="profile" class="avatar-xs rounded-circle">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-14 mb-1">{{ $box->name }}

                                    <span class="badge badge-label bg-success float-end"><i
                                            class="mdi mdi-circle-medium"></i> Office Address</span>

                                </h6>
                                <p class="text-muted mb-0">{{ strtoupper( $box->pob_category) }} -
                                    <small
                                        class="badge badge-soft-success">{{ Str::ucfirst($box->officeVisible) }}</small>
                                </p>
                            </div>
                        </a>

                        <div class="d-flex align-items-center mt-3">
                            <ul class="list-unstyled vstack gap-2 mb-0">
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                            <i class="ri-mail-line"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Email Address</h6>
                                            <small
                                                class="text-muted">{{ $box->officeEmail == null ?  'Not Available' : $box->officeEmail }}</small>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-xxs text-muted">

                                            <i class="ri-phone-line"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Mobile Number</h6>
                                            <small
                                                class="text-muted">{{ $box->officePhone == null ?  'Not Available' : $box->officePhone }}</small>
                                        </div>

                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                            {{-- <i class="ri-earth-line"></i> --}}
                                            {{-- home address --}}
                                            <i class="ri-home-4-line"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Physical Address</h6>
                                            <small
                                                class="text-muted">{{ $box->officeAddress == null ?  'Not Available' : $box->officeAddress }}</small>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>
                        {{-- <div class="d-flex justify-content-center align-items-center mt-3">
                            <a href="javasccript:void(0;)" data-bs-toggle="modal" data-bs-target="#officeAddress"
                                class="btn btn-soft-info btn-sm mt-2 mt-sm-0"><i
                                    class="ri-map-pin-line align-middle me-1"></i> Change Address</a>
                        </div> --}}
                    </div>
                </div>
            </div><!-- end card body -->
        </div>
        <div class="modal fade" id="officeAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content border-0">
                    <div class="modal-header p-3">
                        <h5 class="modal-title" id="exampleModalLabel">Office Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                    </div>
                    <form class="tablelist-form"
                        action="{{ route('customer.addressing.changeOfficeAddress',$box->id) }}" method="post"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="row mb-2">
                                    <div class="col-lg-7">

                                        <label for="profile" class="form-label">Profile Image</label>
                                        <input type="file" name="profile" id="profile" class="form-control"
                                            accept="image/*" />
                                        {{-- show validation error --}}
                                        @error('profile')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-lg-5">

                                        <label for="photo" class="form-label">Private / Public</label>
                                        <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                            <input type="checkbox" {{ (old('officeVisible') == 'on') ? 'checked' : '' }}
                                                name="officeVisible" class="form-check-input" id="visible">
                                            <label class="form-check-label" for="visible">Visible to
                                                public</label>
                                        </div>

                                    </div>
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="officePhone" value="{{ old('officePhone') }}"
                                        class="form-control phone" minlength="10" maxlength="10"
                                        placeholder="Enter phone number" required />
                                    {{-- show validation error --}}
                                    @error('officePhone')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <label for="phone" class="form-label">Email</label>
                                    <input type="email" name="officeEmail" value="{{ old('officeEmail') }}"
                                        class="form-control" placeholder="Enter Email Address" required />
                                    {{-- show validation error --}}
                                    @error('officeEmail')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <div>
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" id="address" name="officeAddress"
                                            value="{{ old('officeAddress') }}" class="form-control"
                                            placeholder="Enter Address" required />
                                        {{-- show validation error --}}
                                        @error('officeAddress')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="alert alert-warning alert-borderless" role="alert">
                                        <strong> Warning !!!</strong> Our system will automatically save the current
                                        location ,
                                        so make sure you are in the right place before you click <b>Agree to terms</b>.
                                        or continue without Agreeing to terms and conditions untill you are in the right
                                        place.
                                        <div class="form-check text-dark mt-2">
                                            <input class="form-check-input getLocation" type="checkbox" value="on"
                                                id="invalidCheck">
                                            <label class="form-check-label" for="invalidCheck">
                                                Agree to terms and conditions
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    {{-- longitude --}}
                                    <input type="hidden" name="longitude" class="longitude"
                                        value="{{ old('longitude') }}">
                                    {{-- latitude --}}
                                    <input type="hidden" name="latitude" class="latitude" value="{{ old('latitude') }}">
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" id="add-btn">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end add modal-->

    </div><!-- end col -->

    @if ($box->pob_type == 'Individual')
    <div class="col-xl-6">
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden ms-0">
                        <a class="d-flex align-items-center">
                            <div class="flex-shrink-0">
                                @php
                                if ($box->profile == null) {
                                if ($box->pob_type == 'Individual') {
                                $photo = 'assets/images/users/user-dummy-img.jpg';
                                } else {
                                $photo = 'assets/images/users/multi-user.jpg';
                                }
                                } else {
                                $photo = 'images/addressing/'.$box->profile;
                                }
                                @endphp
                                <img src="{{ asset($photo) }}" alt="profile" class="avatar-xs rounded-circle">
                            </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-14 mb-1">{{ $box->name }}

                                    <span class="badge badge-label bg-primary float-end"><i
                                            class="mdi mdi-circle-medium"></i> Home Address</span>

                                </h6>
                                <p class="text-muted mb-0">{{ strtoupper( $box->pob_category) }} -
                                    @if ($box->homeVisible == 'public')
                                    <small class="badge badge-success-dark">{{ ucfirst($box->homeVisible) }}</small>
                                    @else
                                    <small class="badge badge-soft-dark">{{ ucfirst($box->homeVisible) }}</small>
                                    @endif
                                </p>
                            </div>
                        </a>
                        <div class="d-flex align-items-center mt-3">
                            <ul class="list-unstyled vstack gap-2 mb-0">
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                            <i class="ri-mail-line"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Email Address</h6>
                                            <small
                                                class="text-muted">{{ $box->homeEmail == null ?  'Not Available' : $box->homeEmail }}</small>
                                        </div>
                                    </div>
                                </li>

                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-xxs text-muted">

                                            <i class="ri-phone-line"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Mobile Number</h6>
                                            <small
                                                class="text-muted">{{ $box->homePhone == null ?  'Not Available' : $box->homePhone }}</small>
                                        </div>

                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                            {{-- <i class="ri-earth-line"></i> --}}
                                            {{-- home address --}}
                                            <i class="ri-home-4-line"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Physical Address</h6>
                                            <small
                                                class="text-muted">{{ $box->homeAddress == null ?  'Not Available' : $box->homeAddress }}</small>
                                        </div>
                                    </div>
                                </li>

                            </ul>
                        </div>

                        {{-- <div class="d-flex justify-content-center align-items-center mt-3">
                            <a href="javasccript:void(0;)" class="btn btn-soft-info btn-sm mt-2 mt-sm-0"
                                data-bs-toggle="modal" data-bs-target="#homeAddress"><i
                                    class="ri-map-pin-line align-middle me-1"></i>Change Address</a>
                        </div> --}}

                    </div>
                </div>
            </div><!-- end card body -->

        </div>
        <div class="modal fade" id="homeAddress" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-md">
                <div class="modal-content border-0">
                    <div class="modal-header p-3">
                        <h5 class="modal-title" id="exampleModalLabel">Home Address</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                    </div>
                    <form class="tablelist-form" action="{{ route('customer.addressing.changeHomeAddress',$box->id) }}"
                        method="post" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="row">
                                <div class="row mb-2">
                                    <div class="col-lg-7">

                                        <label for="profile" class="form-label">Profile Image</label>
                                        <input type="file" name="profile" id="profile" class="form-control"
                                            accept="image/*" />
                                        {{-- show validation error --}}
                                        @error('profile')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror

                                    </div>
                                    <div class="col-lg-5">

                                        <label for="photo" class="form-label">Private / Public</label>
                                        <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                            <input type="checkbox" {{ (old('homeVisible') == 'on') ? 'checked' : '' }}
                                                name="homeVisible" class="form-check-input" id="visible1">
                                            <label class="form-check-label" for="visible1">Visible to
                                                public</label>
                                        </div>

                                    </div>
                                </div>


                                <div class="col-lg-12 mb-2">
                                    <label for="phone" class="form-label">Phone</label>
                                    <input type="text" name="homePhone" value="{{ old('homePhone') }}"
                                        class="form-control phone" minlength="10" maxlength="10"
                                        placeholder="Enter phone number" required />
                                    {{-- show validation error --}}
                                    @error('homePhone')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <label for="phone" class="form-label">Email</label>
                                    <input type="email" name="homeEmail" value="{{ old('homeEmail') }}"
                                        class="form-control" placeholder="Enter Email Address" required />
                                    {{-- show validation error --}}
                                    @error('homeEmail')
                                    <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-lg-12 mb-2">
                                    <div>
                                        <label for="address" class="form-label">Address</label>
                                        <input type="text" id="address" name="homeAddress"
                                            value="{{ old('homeAddress') }}" class="form-control"
                                            placeholder="Enter Address" required />
                                        {{-- show validation error --}}
                                        @error('homeAddress')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <div class="alert alert-warning alert-borderless" role="alert">
                                        <strong> Warning !!!</strong> Our system will automatically save the current
                                        location ,
                                        so make sure you are in the right place before you click <b>Agree to terms</b>.
                                        or continue without Agreeing to terms and conditions untill you are in the right
                                        place.
                                        <div class="form-check text-dark mt-2">
                                            <input class="form-check-input getLocation" type="checkbox" value="on"
                                                id="invalidCheck1">
                                            <label class="form-check-label" for="invalidCheck1">
                                                Agree to terms and conditions
                                            </label>

                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    {{-- longitude --}}
                                    <input type="hidden" name="longitude" class="longitude"
                                        value="{{ old('longitude') }}">
                                    {{-- latitude --}}
                                    <input type="hidden" name="latitude" class="latitude" value="{{ old('latitude') }}">
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-success" id="add-btn">Submit</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--end add modal-->

    </div><!-- end col -->
    @else
    <div class="col-xl-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Members list</h4>
                <div class="flex-shrink-0">
                    <button type="button" class="btn btn-soft-info btn-sm" data-bs-toggle="modal"
                        data-bs-target="#showModal">
                        <i class="ri-add-line align-middle"></i> Add Member
                    </button>
                    <div class="modal fade" id="showModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-md">
                            <div class="modal-content border-0">
                                <div class="modal-header bg-soft-info p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">Add Address</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                <form class="tablelist-form"
                                    action="{{ route('customer.addressing.membersStore',$box->id) }}" method="post"
                                    enctype="multipart/form-data">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="row g-3">
                                            <div class="col-lg-4">
                                                <label for="" class="form-label">(Public / Private)</label>
                                                <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                    <input type="checkbox"
                                                        {{ (old('visible') == 'on') ? 'checked' : '' }} name="visible"
                                                        class="form-check-input" id="visible2">
                                                    <label class="form-check-label" for="visible2">Public</label>
                                                </div>
                                            </div>
                                            <div class="col-lg-8">

                                                <label for="owner-field" class="form-label">Name</label>
                                                <input type="text" name="name" id="owner-field" class="form-control"
                                                    placeholder="Enter owner name" value="{{ old('name') }}" required />
                                                {{-- show validation error --}}
                                                @error('name')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="email" class="form-label">Email
                                                    Address</label>
                                                <input type="email" name="email" id="email" value="{{ old('email') }}"
                                                    class="form-control" placeholder="Enter Email Address" required />
                                                {{-- show validation error --}}
                                                @error('email')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror

                                            </div>

                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="phone" class="form-label">Phone</label>
                                                    <input type="text" name="phone" id="phone"
                                                        value="{{ old('phone') }}" class="form-control phone"
                                                        minlength="10" maxlength="10" placeholder="Enter phone number"
                                                        required />
                                                    {{-- show validation error --}}
                                                    @error('phone')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <div>
                                                    <label for="post" class="form-label">Post</label>
                                                    <input type="text" id="post" name="post" value="{{ old('post') }}"
                                                        class="form-control" placeholder="Enter Post" required />
                                                    {{-- show validation error --}}
                                                    @error('post')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-lg-6">

                                                <label for="photo" class="form-label">Profile Image</label>
                                                <input type="file" name="photo" id="photo" class="form-control"
                                                    accept="image/*" />
                                                {{-- show validation error --}}
                                                @error('photo')
                                                <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                            <div class="col-lg-12">

                                                <label for="contactDescription" class="form-label">Description</label>
                                                <textarea class="form-control" name="description"
                                                    id="contactDescription" rows="3"
                                                    placeholder="Enter description">{{ old('description') }}</textarea>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-success" id="add-btn">Add
                                                Address</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <!--end add modal-->
                </div>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                        <thead class="text-muted table-light">

                        </thead>
                        <tbody>
                            @foreach ($members as $member)
                            <tr>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-2">
                                            <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt=""
                                                class="avatar-xs rounded-circle">
                                        </div>
                                        <div class="flex-grow-1">
                                            {{-- names and email --}}
                                            <div class="fw-bold">{{ $member->name }}</div>
                                            <div class="text-muted">{{ $member->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div>{{ $member->phone }}</div>
                                            <div class="text-muted">({{ $member->post }})</div>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <ul class="list-inline hstack gap-2 mb-0">
                                        <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                            <a href="" data-bs-toggle="modal"
                                                data-bs-target="#editModel{{ $member->id }}"
                                                class="text-primary d-inline-block edit-item-btn">
                                                <i class="ri-pencil-fill fs-16"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                            data-bs-placement="top" title="Remove">
                                            <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal"
                                            data-bs-target="#deleteRecordModal{{ $member->id }}">
                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                            </a>
                                        </li>
                                    </ul>
                                    <div class="modal fade" id="editModel{{ $member->id }}" tabindex="-1"
                                        aria-labelledby="exampleModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered modal-md">
                                            <div class="modal-content border-0">
                                                <div class="modal-header bg-soft-info p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Edit Address</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form"
                                                    action="{{ route('customer.addressing.membersUpdate',$member->id) }}"
                                                    method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="row g-3">
                                                            <div class="col-lg-4">
                                                                <label for="" class="form-label">(Public /
                                                                    Private)</label>
                                                                <div class="form-check form-switch form-switch-md mb-3"
                                                                    dir="ltr">
                                                                    <input type="checkbox"
                                                                        {{ ($member->visible == 'public') ? 'checked' : '' }}
                                                                        name="visible" class="form-check-input"
                                                                        id="visible{{ $member->id }}">
                                                                    <label class="form-check-label"
                                                                        for="visible{{ $member->id }}">Public</label>
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-8">

                                                                <label for="owner-field" class="form-label">Name</label>
                                                                <input type="text" name="name" id="owner-field"
                                                                    class="form-control" placeholder="Enter owner name"
                                                                    value="{{ $member->name }}" required />
                                                                {{-- show validation error --}}
                                                                @error('name')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="email" class="form-label">Email
                                                                    Address</label>
                                                                <input type="email" name="email" id="email"
                                                                    value="{{ $member->email }}" class="form-control"
                                                                    placeholder="Enter Email Address" required />
                                                                {{-- show validation error --}}
                                                                @error('email')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror

                                                            </div>

                                                            <div class="col-lg-6">
                                                                <div>
                                                                    <label for="phone" class="form-label">Phone</label>
                                                                    <input type="text" name="phone" id="phone"
                                                                        value="{{ $member->phone }}"
                                                                        class="form-control phone" minlength="10"
                                                                        maxlength="10" placeholder="Enter phone number"
                                                                        required />
                                                                    {{-- show validation error --}}
                                                                    @error('phone')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <div>
                                                                    <label for="post" class="form-label">Post</label>
                                                                    <input type="text" id="post" name="post"
                                                                        value="{{ $member->post }}" class="form-control"
                                                                        placeholder="Enter Post" required />
                                                                    {{-- show validation error --}}
                                                                    @error('post')
                                                                    <span class="text-danger">{{ $message }}</span>
                                                                    @enderror
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">

                                                                <label for="photo" class="form-label">Profile
                                                                    Image</label>
                                                                <input type="file" name="photo" id="photo"
                                                                    class="form-control" accept="image/*" />
                                                                {{-- show validation error --}}
                                                                @error('photo')
                                                                <span class="text-danger">{{ $message }}</span>
                                                                @enderror
                                                            </div>
                                                            <div class="col-lg-12">

                                                                <label for="contactDescription"
                                                                    class="form-label">Description</label>
                                                                <textarea class="form-control" name="description"
                                                                    id="contactDescription" rows="3"
                                                                    placeholder="Enter description">{{ $member->description }}</textarea>

                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">Close</button>
                                                            <button type="submit" class="btn btn-success"
                                                                id="add-btn">Update
                                                                Address</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade zoomIn" id="deleteRecordModal{{ $member->id }}" tabindex="-1" aria-labelledby="deleteRecordLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                                </div>
                                                <form action="{{ route('customer.addressing.membersDestroy', $member->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                <div class="modal-body p-5 text-center">
                                                    <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                                    <div class="mt-4 text-center">
                                                        <h4 class="fs-semibold">You are about to delete an address?</h4>
                                                        <p class="text-muted fs-14 mb-4 pt-1">Deleting your address is permanent and cannot be undone .</p>
                                                        <div class="hstack gap-2 justify-content-center remove">
                                                            <button class="btn btn-link link-success fw-medium text-decoration-none" data-bs-dismiss="modal">
                                                                <i class="ri-close-line me-1 align-middle"></i> Close
                                                            </button>
                                                            <button class="btn btn-danger" id="delete-record">Yes, Delete It!!</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </td>


                            </tr><!-- end tr -->
                            @endforeach


                        </tbody><!-- end tbody -->
                    </table><!-- end table -->
                </div>
            </div>
        </div>
    </div>
    @endif




</div>

@endsection
@section('script')
<script>
    $(document).ready(function () {
        $('.phone').keypress(function (e) {
            var a = [];
            var k = e.which;

            for (i = 48; i < 58; i++)
                a.push(i);

            if (!(a.indexOf(k) >= 0))
                e.preventDefault();
        });
    });

    // .getLocation checked and is 'on' then .longutude and .latitude get current location else alert some worning
    $(document).ready(function () {
        $('.getLocation').click(function () {
            if ($(this).is(':checked')) {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition(showPosition, showError);
                } else {
                    alert("Geolocation is not supported by this browser.");
                }

                function showPosition(position) {
                    $('.longitude').val(position.coords.longitude);
                    $('.latitude').val(position.coords.latitude);
                }

                function showError(error) {
                    $('.getLocation').prop('checked', false);
                    if (error.code === error.PERMISSION_DENIED) {
                        alert(
                            "Unable to retrieve your location. Please enable geolocation or allow access.");
                    } else {
                        alert("An error occurred while retrieving your location.");
                    }
                }
            } else {
                $('.longitude').val('');
                $('.latitude').val('');
            }
        });
    });

</script>
@endsection
