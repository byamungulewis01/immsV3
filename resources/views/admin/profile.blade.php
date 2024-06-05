@extends('layouts.admin.app')
@section('page-name')Profile @endsection
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
                <img src="{{ asset('assets/images/users/avatar-1.jpg') }}" alt="user-img" class="img-thumbnail rounded-circle">
            </div>
        </div>
        <!--end col-->
        <div class="col">
            <div class="p-2">
                <h3 class="text-white mb-1">{{ $user->name }}</h3>
                <p class="text-white-75">Branch &amp; Manager</p>
                <div class="hstack text-white-50 gap-1">
                    <div class="me-2"><i class="ri-map-pin-user-line me-1 text-white-75 fs-16 align-middle"></i>Rwanda, {{ $user->branchname->name }}</div>
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
                                <tr>
                                    <th class="ps-0" scope="row">Role :</th>
                                    <td class="text-muted">
                                        <span @if(!$user->getRoleNames()->count()) class="fst-italic" @endif>
                                            {{ $user->getRoleNames()->count() == 0 ? 'No Role Assigned' : $user->getRoleNames() }}
                                        </span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="#openModal" data-bs-toggle="modal" class="btn btn-sm btn-primary"><i class="ri-edit-box-line align-bottom"></i> Assign Role</a>
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
                                                        action="{{ route('admin.roles.assignRole',$user->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="mt-2 text-center">

                                                            <div class="pt-2 fs-15 mx-4 mx-sm-5">
                                                                <h4>Assign Role to {{ $user->name }}</h4>
                                                                <p class="text-muted">
                                                                   {{ $user->name }} will have permissions according to role assigned to
                                                                </p>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col mb-3">
                                                              <label for="roles" class="form-label">Select Roles to assign</label>
                                                              <input id="roles" name="roles" class="form-control roles" placeholder=" - Select Roles -" value="@foreach($user->getRoleNames() as $role){{$role}},@endforeach" required>
                                                            </div>
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
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->

            {{-- <div class="row text text-white-50 text-center">
                <div class="col-lg-6 col-4">
                    <div class="p-2">
                        <h4 class="text-white mb-1">24.3K</h4>
                        <p class="fs-14 mb-0">Followers</p>
                    </div>
                </div>
                <div class="col-lg-6 col-4">
                    <div class="p-2">
                        <h4 class="text-white mb-1">1.3K</h4>
                        <p class="fs-14 mb-0">Following</p>
                    </div>
                </div>
            </div> --}}
        </div>
        <!--end col-->

    </div>
    <!--end row-->
</div>


@endsection

@section('css')
<link rel="stylesheet" href="{{ asset('assets/tagify/tagify.css') }}">
@endsection

@section('script')
<script src="{{ asset('assets/tagify/tagify.js') }}"></script>
<script>
    "use strict";
  !function(){
      var a=(new Tagify(a),document.querySelector("#roles")),
    //   select roles

      t=[@foreach($roles as $role)"{{ $role }}",@endforeach],
      a=(new Tagify(a,{
          whitelist:t,
          maxTags:10,
          dropdown:{
              maxItems:20,
              classname:"tags-inline",
              enabled:0,
              closeOnSelect:!1
          }
      }));

    }();
  </script>

@endsection
