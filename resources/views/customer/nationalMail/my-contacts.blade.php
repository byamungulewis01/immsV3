@extends('layouts.customer.app')
@section('page') My Contacts @endsection
@section('content')
<div class="row">
    <div class="col-lg-6">
        <div class="card" id="customerList">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">My Contacts</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <form class="app-search d-none d-md-block">
                    <div class="position-relative">
                        <input type="text" class="form-control" placeholder="Search..." autocomplete="off"
                            id="search-options" value="">
                        <span class="mdi mdi-magnify search-widget-icon"></span>
                        <span class="mdi mdi-close-circle search-widget-icon search-widget-icon-close d-none"
                            id="search-close-options"></span>
                    </div>
                    <div class="dropdown-menu dropdown-menu-lg" id="search-dropdown">
                        <div data-simplebar style="max-height: 320px;">

                            <!-- item-->
                            <div class="dropdown-header mt-2">
                                <h6 class="text-overflow text-muted mb-2 text-uppercase">List</h6>
                            </div>

                            <div class="notification-list">
                                <!-- item -->
                                @foreach ($addresses as $address)
                                <a href="{{ route('customer.my-contacts.show',encrypt($address->id)) }}" class="dropdown-item notify-item py-2">
                                    <div class="d-flex">
                                        @php
                                        if ($address->profile == null) {
                                        if ($address->pob_type == 'Individual') {
                                        $photo = 'assets/images/users/user-dummy-img.jpg';
                                        } else {
                                        $photo = 'assets/images/users/multi-user.jpg';
                                        }
                                        } else {
                                        $photo = 'images/addressing/'.$address->profile;
                                        }
                                        @endphp
                                        <img src="{{ asset($photo) }}"
                                            class="me-3 rounded-circle avatar-xs" alt="user-pic">
                                        <div class="flex-1">
                                            <h6 class="m-0">{{ $address->name }}</h6>
                                            <span class="fs-11 mb-0 text-muted">{{ $address->email }}</span>
                                        </div>
                                    </div>
                                </a>
                                @endforeach
                            </div>
                        </div>

                        {{-- <div class="text-center pt-3 pb-1">
                            <a href="pages-search-results.html" class="btn btn-primary btn-sm">View All Results
                                <i class="ri-arrow-right-line ms-1"></i></a>
                        </div> --}}
                    </div>
                </form>
                @if (Request::routeIs('customer.my-contacts.show'))
                @if ($customer->homePhone == NULL)
                <div class="d-flex align-items-center mt-3">
                    <div class="flex-grow-1 overflow-hidden ms-0">
                        <a class="d-flex align-items-center">
                        <div class="flex-shrink-0">

                                @php
                                if ($customer->profile == null) {
                                if ($customer->pob_type == 'Individual') {
                                $photo = 'assets/images/users/user-dummy-img.jpg';
                                } else {
                                $photo = 'assets/images/users/multi-user.jpg';
                                }
                                } else {
                                $photo = 'images/addressing/'.$customer->profile;
                                }
                                @endphp
                                <img src="{{ asset($photo) }}" alt="profile" class="avatar-xs rounded-circle">

                         </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-14 mb-1"> {{ $customer->name }}
                                    <span class="badge badge-label bg-primary float-end"><i
                                            class="mdi mdi-circle-medium"></i>Office Address</span>

                                </h6>
                                <p class="text-muted mb-0">{{ strtoupper( $customer->pob_category) }} </p>
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
                                            <small class="text-muted">{{ $customer->officeEmail }}</small>
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
                                            <small class="text-muted">{{ $customer->officePhone }}</small>
                                        </div>

                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                            <i class="ri-home-4-line"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Physical Address</h6>
                                            <small class="text-muted">{{ $customer->officeAddress }}</small>
                                        </div>
                                    </div>
                                </li>

                            </ul>

                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <ul class="list-unstyled mb-0 vstack">
                                <li>
                                    <form action="{{ route('customer.my-contacts.addOffice',$customer->id) }}" method="post">
                                        @csrf
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-sm btn-primary">Add to My Contacts</button>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                @elseif ($customer->officePhone == NULL)
                <div class="d-flex align-items-center mt-3">
                    <div class="flex-grow-1 overflow-hidden ms-0">
                        <a class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                                @php
                                if ($customer->profile == null) {
                                if ($customer->pob_type == 'Individual') {
                                $photo = 'assets/images/users/user-dummy-img.jpg';
                                } else {
                                $photo = 'assets/images/users/multi-user.jpg';
                                }
                                } else {
                                $photo = 'images/addressing/'.$customer->profile;
                                }
                                @endphp
                                <img src="{{ asset($photo) }}" alt="profile" class="avatar-xs rounded-circle">

                        </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-14 mb-1"> {{ $customer->name }}

                                    <span class="badge badge-label bg-success float-end"><i
                                            class="mdi mdi-circle-medium"></i> Home Address</span>

                                </h6>
                                <p class="text-muted mb-0">{{ strtoupper( $customer->pob_category) }}
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
                                            <small class="text-muted">{{ $customer->homeEmail }}</small>
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
                                            <small class="text-muted">{{ $customer->homePhone }}</small>
                                        </div>

                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                            <i class="ri-home-4-line"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Physical Address</h6>
                                            <small class="text-muted">{{ $customer->homeAddress }}</small>
                                        </div>
                                    </div>
                                </li>

                            </ul>

                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <ul class="list-unstyled mb-0 vstack">
                                <li>
                                    <form action="{{ route('customer.my-contacts.addHome',$customer->id) }}" method="post">
                                        @csrf
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-sm btn-primary">Add to My Contacts</button>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>

                    </div>
                </div>
                @else
                <div class="d-flex align-items-center mt-3">
                    <div class="flex-grow-1 overflow-hidden ms-0">
                        <a class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                        @php
                        if ($customer->profile == null) {
                        if ($customer->pob_type == 'Individual') {
                        $photo = 'assets/images/users/user-dummy-img.jpg';
                        } else {
                        $photo = 'assets/images/users/multi-user.jpg';
                        }
                        } else {
                        $photo = 'images/addressing/'.$customer->profile;
                        }
                        @endphp
                        <img src="{{ asset($photo) }}" alt="profile" class="avatar-xs rounded-circle">

                        </div>
                            <div class="flex-grow-1 ms-3">
                                <h6 class="fs-14 mb-1"> {{ $customer->name }}

                                    <span class="badge badge-label bg-success float-end"><i
                                            class="mdi mdi-circle-medium"></i> Office Address</span>

                                </h6>
                                <p class="text-muted mb-0">{{ strtoupper( $customer->pob_category) }}
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
                                            <small class="text-muted">{{ $customer->officeEmail }}</small>
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
                                            <small class="text-muted">{{ $customer->officePhone }}</small>
                                        </div>

                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                            <i class="ri-home-4-line"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Physical Address</h6>
                                            <small class="text-muted">{{ $customer->officeAddress }}</small>
                                        </div>
                                    </div>
                                </li>

                            </ul>

                        </div>
                        <div class="d-flex align-items-center mt-3">
                            <ul class="list-unstyled mb-0 vstack">
                                <li>
                                    <form action="{{ route('customer.my-contacts.addOffice',$customer->id) }}" method="post">
                                        @csrf
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-sm btn-primary">Add to My Contacts</button>
                                        </div>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center mt-3">
                    <div class="flex-grow-1 overflow-hidden ms-0">
                        <a class="d-flex align-items-center">

                                <div class="flex-grow-1 ms-3">
                                    <h6 class="fs-14 mb-1">

                                        <span class="badge badge-label bg-primary float-end"><i
                                                class="mdi mdi-circle-medium"></i> Home Address</span>

                                    </h6>

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
                                            <small class="text-muted">{{ $customer->officeEmail }}</small>
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
                                            <small class="text-muted">{{ $customer->officePhone }}</small>
                                        </div>

                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0 avatar-xxs text-muted">
                                            <i class="ri-home-4-line"></i>
                                        </div>
                                        <div class="flex-grow-1">
                                            <h6 class="mb-0">Physical Address</h6>
                                            <small class="text-muted">{{ $customer->officeAddress }}</small>
                                        </div>
                                    </div>
                                </li>

                            </ul>

                        </div>
                            <div class="d-flex align-items-center mt-3">
                                <ul class="list-unstyled mb-0 vstack">
                                    <li>
                                        <form action="{{ route('customer.my-contacts.addHome',$customer->id) }}" method="post">
                                            @csrf
                                            <div class="text-center">
                                                <button type="submit" class="btn btn-sm btn-primary">Add to My Contacts</button>
                                            </div>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                    </div>
                </div>
                @endif

                @endif


            </div>
        </div>
    </div>
    <!--end col-->
    <div class="col-lg-6">
        <div class="card">
            <div class="card-header align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Contact list</h4>
                <div class="flex-shrink-0">
                    <button type="button" class="btn btn-soft-info btn-sm" data-bs-toggle="modal"
                        data-bs-target="#showModal">
                        <i class="ri-add-line align-middle"></i> Add Contact
                    </button>
                    <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">Registration</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                <form class="tablelist-form" method="post"
                                    action="{{ route('customer.my-contacts.store') }}">
                                    @csrf
                                    <div class="modal-body">

                                        @if($errors->any())
                                        <div class="mb-3">
                                            <div class="alert alert-danger">
                                                <p><strong>Opps Something went wrong</strong></p>
                                                <ul>
                                                    @foreach ($errors->all() as $error)
                                                    <li>* {{ $error }}</li>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                        @endif

                                        <div class="mb-3">
                                            <label for="customername-field" class="form-label">
                                                Name</label>
                                            <input type="text" id="customername-field" name="name" class="form-control"
                                                placeholder="Enter name" value="{{ old('name') }}" required />
                                            <div class="invalid-feedback">
                                                Please enter a employee name.
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="email-field" class="form-label">Email</label>
                                            <input type="email" id="email-field" class="form-control" name="email"
                                                placeholder="Enter email" required value="{{ old('email') }}" />
                                            <div class="invalid-feedback">
                                                Please enter an email.
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="phone-field" class="form-label">Phone</label>
                                            <input type="text" id="phone-field" name="phone"
                                                class="form-control phoneNumber" minlength="10" maxlength="10"
                                                placeholder="Enter phone no." required value="{{ old('phone') }}" />
                                            <div class="invalid-feedback">
                                                Please enter a phone.
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="address-field" class="form-label">Address</label>
                                            <input type="text" id="address-field" name="address" class="form-control"
                                                placeholder="Enter address" value="{{ old('address') }}" required />
                                            <div class="invalid-feedback">
                                                Please enter a address.
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <div class="hstack gap-2 justify-content-end">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                Close
                                            </button>
                                            <button type="submit" class="btn btn-success" id="add-btn">
                                                Add contact
                                            </button>
                                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>


                </div>
            </div><!-- end card header -->

            <div class="card-body">
                <div class="table-responsive table-card">
                    <table class="table table-borderless table-centered align-middle table-nowrap mb-0">
                        <thead class="text-muted table-light">

                        </thead>
                        <tbody>
                            @foreach ($contacts as $contact)
                            <tr>

                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0 me-2">
                                            <img src="{{ asset('assets/images/users/user-dummy-img.jpg') }}" alt=""
                                                class="avatar-xs rounded-circle">
                                        </div>
                                        <div class="flex-grow-1">
                                            {{-- names and email --}}
                                            <div class="fw-bold">{{ $contact->name }}</div>
                                            <div class="text-muted">{{ $contact->email }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="flex-grow-1">
                                            <div>{{ $contact->phone }}</div>
                                            <div class="text-muted">({{ $contact->address }})</div>
                                        </div>
                                    </div>

                                </td>
                                <td>
                                    <ul class="list-inline hstack gap-2 mb-0">
                                        <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                            data-bs-trigger="hover" data-bs-placement="top" title="Edit">
                                            <a href="" data-bs-toggle="modal"
                                                data-bs-target="#editModel{{ $contact->id }}"
                                                class="text-primary d-inline-block edit-item-btn">
                                                <i class="ri-pencil-fill fs-16"></i>
                                            </a>
                                        </li>
                                        <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                            data-bs-placement="top" title="Remove">
                                            <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal"
                                            data-bs-target="#deleteRecordModal{{ $contact->id }}">
                                                <i class="ri-delete-bin-5-fill fs-16"></i>
                                            </a>
                                        </li>
                                    </ul>

                                    <div class="modal fade zoomIn" id="deleteRecordModal{{ $contact->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" id="deleteRecord-close"
                                                        data-bs-dismiss="modal" aria-label="Close"
                                                        id="btn-close"></button>
                                                </div>
                                                <div class="modal-body">
                                                    <form method="post"
                                                        action="{{ route('customer.my-contacts.destroy',$contact->id) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <div class="mt-2 text-center">
                                                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json"
                                                                trigger="loop"
                                                                colors="primary:#f7b84b,secondary:#f06548"
                                                                style="width: 100px; height: 100px"></lord-icon>
                                                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                                <h4>Are you sure ?</h4>
                                                                <p class="text-muted mx-4 mb-0">
                                                                    Are you sure you want to remove this record ?
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                            <button type="button" class="btn w-sm btn-light"
                                                                data-bs-dismiss="modal">
                                                                Close
                                                            </button>
                                                            <button type="submit" class="btn w-sm btn-danger"
                                                                id="delete-record">
                                                                Yes, Delete It!
                                                            </button>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal fade" id="editModel{{ $contact->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-light p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Registration</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" method="post"
                                                    action="{{ route('customer.my-contacts.update',$contact->id) }}">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">

                                                        @if($errors->any())
                                                        <div class="mb-3">
                                                            <div class="alert alert-danger">
                                                                <p><strong>Opps Something went wrong</strong></p>
                                                                <ul>
                                                                    @foreach ($errors->all() as $error)
                                                                    <li>* {{ $error }}</li>
                                                                    @endforeach
                                                                </ul>
                                                            </div>
                                                        </div>
                                                        @endif

                                                        <div class="mb-3">
                                                            <label for="customername-field" class="form-label">
                                                                Name</label>
                                                            <input type="text" id="customername-field" name="name"
                                                                class="form-control" placeholder="Enter name"
                                                                value="{{ $contact->name }}" required />
                                                            <div class="invalid-feedback">
                                                                Please enter a employee name.
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="email-field" class="form-label">Email</label>
                                                            <input type="email" id="email-field" class="form-control"
                                                                name="email" placeholder="Enter email" required
                                                                value="{{ $contact->email }}" />
                                                            <div class="invalid-feedback">
                                                                Please enter an email.
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="phone-field" class="form-label">Phone</label>
                                                            <input type="text" id="phone-field" name="phone"
                                                                class="form-control phoneNumber" minlength="10"
                                                                maxlength="10" placeholder="Enter phone no." required
                                                                value="{{ $contact->phone }}" />
                                                            <div class="invalid-feedback">
                                                                Please enter a phone.
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="address-field"
                                                                class="form-label">Address</label>
                                                            <input type="text" id="address-field" name="address"
                                                                class="form-control" placeholder="Enter address"
                                                                value="{{ $contact->address }}" required />
                                                            <div class="invalid-feedback">
                                                                Please enter a address.
                                                            </div>
                                                        </div>

                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">
                                                                Close
                                                            </button>
                                                            <button type="submit" class="btn btn-success" id="add-btn">
                                                                Edit contact
                                                            </button>
                                                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
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
</div>

@endsection

@section('script')
<script>
    $(document).ready(function () {
        $(".phoneNumber").on("input", function () {
            var value = $(this).val();
            var decimalRegex = /^[0-9]+(\.[0-9]{1,2})?$/;
            if (!decimalRegex.test(value)) {
                $(this).val(value.substring(0, value.length - 1));
            }
        });

    });

</script>
@endsection
