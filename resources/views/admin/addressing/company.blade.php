@extends('layouts.admin.app')
@section('page-name') Addressing @endsection
@section('body')

        <div class="row">
            <div class="col-12">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Addressing</h4>

                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="javascript: void(0);">IMMS P.O B</a></li>
                            <li class="breadcrumb-item active">Addressing</li>
                        </ol>
                    </div>

                </div>
            </div>
        </div>

        <div class="row">
            <!--end col-->
            <div class="col-xxl-9">
                <div class="card" id="companyList">
                    <div class="card-header">
                        <div class="row g-2">
                            <div class="col-md-3">
                                <div class="search-box">
                                    <input type="text" class="form-control search" placeholder="Search for company...">
                                    <i class="ri-search-line search-icon"></i>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="card-body">
                        <div>
                            <div class="table-responsive table-card mb-3">
                                <table class="table align-middle table-nowrap mb-0" id="customerTable">
                                    <thead class="table-light">
                                        <tr>
                                            <th class="sort" data-sort="name" scope="col">Company Name</th>
                                            <th class="sort" data-sort="index" scope="col">Index Code</th>
                                            <th class="sort" data-sort="owner" scope="col">Email</th>
                                            <th class="sort" data-sort="industry_type" scope="col">Phone</th>
                                            <th class="sort" data-sort="visible" scope="col">Visibility</th>
                                            <th class="sort" data-sort="location" scope="col">Location</th>
                                            <th class="sort" data-sort="join_date" scope="col">Joining Date</th>
                                            <th scope="col">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($addresses as $item)
                                        <tr>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="flex-shrink-0">
                                                        @php
                                                        if ($item->photo == null) {
                                                           if ($item->customer_type == 'Individual') {
                                                            $photo = 'assets/images/users/user-dummy-img.jpg';
                                                           } else {
                                                            $photo = 'assets/images/users/multi-user.jpg';
                                                           }

                                                        } else {
                                                            $photo = 'images/addressing/'.$item->photo;
                                                        }
                                                    @endphp
                                                        <img src="{{ asset($photo) }}" alt="" class="avatar-xxs rounded-circle image_src object-cover">
                                                    </div>
                                                    <div class="flex-grow-1 ms-2 name">{{ $item->name }}
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="index">{{ $item->index }}</td>
                                            <td class="email">{{ $item->email }}</td>
                                            <td class="phone">+25{{ $item->phone }}</td>
                                            <td class="visible">
                                                @if ($item->visible == 'public')
                                                <span class="badge bg-soft-success text-success">Public</span>
                                                @else
                                                <span class="badge bg-soft-danger text-danger">Private</span>
                                                @endif
                                            <td class="location">{{ $item->address }}</td>
                                            <td class="join_date">{{ $item->created_at->format('d M Y') }}</td>
                                            <td>
                                             {{-- view more button --}}
                                             <a href="{{ route('admin.addressing.members',$item->id) }}" class="btn btn-primary btn-sm">members</a>
                                             {{-- <button type="button" class="btn btn-sm btn-primary">
                                                Members <span class="badge bg-success ms-1">4</span>
                                            </button> --}}
                                            </td>
                                        </tr>

                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="noresult" style="display: none">
                                    <div class="text-center">
                                        <lord-icon src="https://cdn.lordicon.com/msoeawqm.json" trigger="loop" colors="primary:#121331,secondary:#08a88a" style="width:75px;height:75px"></lord-icon>
                                        <h5 class="mt-2">Sorry! No Result Found</h5>
                                        <p class="text-muted mb-0">We've searched more than 150+ companies We did not find any companies for you search.</p>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mt-3">
                                <div class="pagination-wrap hstack gap-2">
                                    <a class="page-item pagination-prev disabled" href="#">
                                        Previous
                                    </a>
                                    <ul class="pagination listjs-pagination mb-0"></ul>
                                    <a class="page-item pagination-next" href="#">
                                        Next
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--end card-->
            </div>
            <!--end col-->

        </div>
        <!--end row-->


@endsection

@section('script')

@endsection
