@extends('layouts.admin.app')
@section('page-name') Addressing @endsection
@section('body')
<div class="card">
    <div class="card-body">
        <div class="row g-3">
            <div class="col-md-3">
                <div class="search-box">
                    <input type="text" class="form-control search" placeholder="Search for Address...">
                    <i class="ri-search-line search-icon"></i>
                </div>
            </div>

        </div>
        <!--end row-->
    </div>
</div>

<!--end card-->
<div class="collapse show" id="id">
    <div class="row">
        @foreach ($addressings as $item)
        <div class="col-md-6 mb-3">
            <div class="card mb-1">
                <div class="card-body">
                    <a class="d-flex align-items-center" data-bs-toggle="collapse"
                        href="#id{{ $item->id }}" role="button" aria-expanded="false"
                        aria-controls="id{{ $item->id }}">
                        <div class="flex-shrink-0">
                            @php
                            if ($item->photo == null) {
                            $photo = 'assets/images/users/user-dummy-img.jpg';
                            } else {
                            $photo = 'images/addressing/'.$item->photo;
                            }
                            @endphp
                            <img src="{{ asset($photo) }}" alt="" class="avatar-xs rounded-circle">
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="fs-14 mb-1">{{ $item->name }}</h6>
                            <p class="text-muted mb-0">{{ $item->index }} - {{ date('d M, Y', strtotime($item->created_at)) }}
                            </p>
                        </div>
                    </a>
                </div>
                <div class="collapse border-top border-top-dashed" id="id{{ $item->id }}">
                    <div class="card-body">
                        <h6 class="fs-14 mb-1">{{ $item->post }}
                         @if ($item->visible == 'public')<small class="badge badge-soft-success">Public</small>@else <small class="badge badge-soft-danger">Private</small>@endif
                        </h6>
                        <p class="text-muted">
                        {{-- print description but only 100 words --}}
                        @php
                        $description = $item->description;
                        $description = Str::words($description, 17, ' ...');
                        @endphp
                        {{ $description }}

                        </p>
                        <ul class="list-unstyled vstack gap-2 mb-0">
                            <li>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 avatar-xxs text-muted">
                                        <i class="ri-mail-line"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">Member Email Address</h6>
                                        <small class="text-muted">{{ $item->email }}</small>
                                    </div>
                                </div>
                            </li>

                            <li>
                                <div class="d-flex">
                                    <div class="flex-shrink-0 avatar-xxs text-muted">
                                        {{-- <i class="ri-earth-line"></i> --}}
                                        {{-- phone number --}}
                                        <i class="ri-phone-line"></i>
                                    </div>
                                    <div class="flex-grow-1">
                                        <h6 class="mb-0">Working Mobile Numberg</h6>
                                        <small class="text-muted">+25{{ $item->phone }}</small>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer hstack gap-2">
                        {{-- edit --}}
                        <button data-bs-toggle="modal" data-bs-target="#editModel{{ $item->id }}" class="btn btn-primary btn-sm w-100"><i class="ri-pencil-line align-bottom me-1"></i>
                            Edit</button>
                            <div class="modal fade" id="editModel{{ $item->id }}" tabindex="-1" aria-labelledby="exampleModalLabel"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md">
                                <div class="modal-content border-0">
                                    <div class="modal-header bg-soft-info p-3">
                                        <h5 class="modal-title" id="exampleModalLabel">Edit Address</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                            id="close-modal"></button>
                                    </div>
                                    <form class="tablelist-form" action="{{ route('customer.addressing.membersUpdate',$item->id) }}"
                                        method="post" enctype="multipart/form-data">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-body">
                                            <div class="row g-3">
                                                <div class="col-lg-4">
                                                    <label for="" class="form-label">(Public / Private)</label>
                                                    <div class="form-check form-switch form-switch-md mb-3" dir="ltr">
                                                        <input type="checkbox" {{ ($item->visible == 'public') ? 'checked' : '' }}  name="visible" class="form-check-input"
                                                            id="visible{{ $item->id }}">
                                                        <label class="form-check-label" for="visible{{ $item->id }}">Public</label>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">

                                                    <label for="owner-field" class="form-label">Name</label>
                                                    <input type="text" name="name" id="owner-field" class="form-control"
                                                        placeholder="Enter owner name" value="{{ $item->name }}" required />
                                                    {{-- show validation error --}}
                                                    @error('name')
                                                    <span class="text-danger">{{ $message }}</span>
                                                    @enderror
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="email" class="form-label">Email
                                                        Address</label>
                                                    <input type="email" name="email" id="email" value="{{ $item->email }}"
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
                                                            value="{{ $item->phone }}" class="form-control phone" minlength="10"
                                                            maxlength="10" placeholder="Enter phone number" required />
                                                        {{-- show validation error --}}
                                                        @error('phone')
                                                        <span class="text-danger">{{ $message }}</span>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <div>
                                                        <label for="post" class="form-label">Post</label>
                                                        <input type="text" id="post" name="post" value="{{ $item->post }}"
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
                                                        id="contactDescription" rows="3" placeholder="Enter description"
                                                    >{{ $item->description }}</textarea>

                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <div class="hstack gap-2 justify-content-end">
                                                <button type="button" class="btn btn-light"
                                                    data-bs-dismiss="modal">Close</button>
                                                <button type="submit" class="btn btn-success" id="add-btn">Update
                                                    Address</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!--end add modal-->
                               {{-- delete --}}
                               <button  data-bs-toggle="modal" data-bs-target="#deleteRecordModal{{ $item->id }}" class="btn btn-danger btn-sm w-100"><i class="ri-delete-bin-line align-bottom me-1"></i>
                                Delete</button>
                                <div class="modal fade zoomIn" id="deleteRecordModal{{ $item->id }}" tabindex="-1" aria-labelledby="deleteRecordLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                            </div>
                                            <form action="{{ route('customer.addressing.membersDestroy', $item->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                            <div class="modal-body p-5 text-center">
                                                <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop" colors="primary:#405189,secondary:#f06548" style="width:90px;height:90px"></lord-icon>
                                                <div class="mt-4 text-center">
                                                    <h4 class="fs-semibold">You are about to delete an address?</h4>
                                                    <p class="text-muted fs-14 mb-4 pt-1">Deleting your address will remove all of your information from our database.</p>
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
                                <!--end delete modal -->
                    </div>
                </div>
            </div>
        </div>
        @endforeach

    </div>
</div>

@endsection

@section('script')

@endsection
