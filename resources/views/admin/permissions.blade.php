@extends('layouts.admin.app')
@section('page-name') Permission @endsection
@section('css')
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Permission</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS P.O B</a>
                    </li>
                    <li class="breadcrumb-item active">Permission</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="customerList">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">Permission List</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">

                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                                data-bs-target="#showModal">
                                <i class="ri-add-line align-bottom me-1"></i> Add
                                Permission
                            </button>
                            <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title">Permission Registration</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" id="close-modal"></button>
                                        </div>

                                        <form class="tablelist-form" method="post" action="{{ route('admin.permissions.store') }}">
                                            @csrf
                                            <div class="modal-body">
                                                <div class="mb-3">
                                                    @if($errors->any())
                                                    <div class="alert alert-danger">
                                                      <p><strong>Opps Something went wrong</strong></p>
                                                      <ul>
                                                      @foreach ($errors->all() as $error)
                                                        <li>* {{ $error }}</li>
                                                      @endforeach
                                                      </ul>
                                                    </div>
                                                      @endif
                                                </div>
                                                <div class="mb-3">
                                                    <label for="customername-field"
                                                        class="form-label">Permission
                                                        Name</label>
                                                    <input type="text" id="customername-field"
                                                        class="form-control" placeholder="Enter name"
                                                        name="name"
                                                        required  value="{{ old('name') }}"/>

                                                </div>


                                                <div>
                                                    <label for="status-field"
                                                        class="form-label">System Activities</label>
                                                    <select name="activity_id" class="form-select" required>
                                                        @foreach ($activities as $activity)
                                                        <option @if (old('activity_id') == $activity->name) selected @endif value="{{ $activity->id }}">{{ $activity->name }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light"
                                                        data-bs-dismiss="modal">
                                                        Close
                                                    </button>
                                                    <button type="submit" class="btn btn-success"
                                                        id="add-btn">
                                                        Add Permission
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="datatableAjax" class="table table-centered table-hover align-middle table-nowrap mb-0"
                              style="width: 100%;">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col">
                                        #
                                    </th>

                                    <th class="sort" data-sort="activity">
                                        System Activity
                                    </th>
                                    <th class="sort" data-sort="name">
                                        Permission Name
                                    </th>
                                    <th class="sort" data-sort="date">
                                        Created Date
                                    </th>
                                    <th class="sort" data-sort="action" style="width: 140px">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($permissions as $key => $permission)
                                <tr>
                                    <th scope="row">
                                       {{ str_pad($key + 1, 2, '0', STR_PAD_LEFT) }}
                                    </th>
                                    <td class="name">{{ $permission->activity->name }}</td>
                                    <td class="name">{{ $permission->name }}</td>
                                    <td class="date">
                                        {{ $permission->created_at->format('d M, Y') }}
                                    </td>

                                    <td>
                                        <a href="#showModal{{ $permission->id }}" data-bs-toggle="modal" type="button"
                                            class="btn btn-primary btn-sm"><span>Edit</span></a>
                                        <div class="modal fade" id="showModal{{ $permission->id }}" tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light p-3">
                                                        <h5 class="modal-title">Branch Modification</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close" id="close-modal"></button>
                                                    </div>
                                                    <form class="tablelist-form" id="myForm" method="post" action="{{ route('admin.permissions.update',$permission->id) }}">
                                                        @csrf
                                                        @method('PUT')
                                                        <div class="modal-body">
                                                            <input type="hidden" id="token" value="{{ $permission->id }}"/>
                                                            <div class="mb-3">
                                                                @if($errors->any())
                                                                <div class="alert alert-danger">
                                                                  <p><strong>Opps Something went wrong</strong></p>
                                                                  <ul>
                                                                  @foreach ($errors->all() as $error)
                                                                    <li>* {{ $error }}</li>
                                                                  @endforeach
                                                                  </ul>
                                                                </div>
                                                                  @endif
                                                            </div>
                                                            <div class="mb-3">

                                                                <label for="customername-field"
                                                                    class="form-label">Permission
                                                                    Name</label>
                                                                <input type="text" id="customername-field"
                                                                    class="form-control" placeholder="Enter name"
                                                                    name="name" required  value="{{ $permission->name }}"/>

                                                            </div>


                                                            <div>
                                                                <label for="status-field"
                                                                    class="form-label">System Activities</label>
                                                                <select name="activity_id" class="form-select" required>
                                                                    @foreach ($activities as $activity)
                                                                    <option @if ($permission->activity_id == $activity->id) selected @endif value="{{ $activity->id }}">{{ $activity->name }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <div class="hstack gap-2 justify-content-end">
                                                                <button type="button" class="btn btn-light"
                                                                    data-bs-dismiss="modal">
                                                                    Close
                                                                </button>
                                                                <button type="submit" class="btn btn-success"
                                                                    id="add-btn">
                                                                    Edit Permission
                                                                </button>
                                                                <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>

                                        <a href="#deleteRecordModal{{ $permission->id }}" data-bs-toggle="modal"  type="button" class="btn btn-danger btn-sm"><span>Delete</span></a>

                                        <!-- Modal -->
                                        <div class="modal fade zoomIn" id="deleteRecordModal{{ $permission->id }}" tabindex="-1"
                                            aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <button type="button" class="btn-close" id="deleteRecord-close"
                                                            data-bs-dismiss="modal" aria-label="Close"
                                                            id="btn-close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <form method="post" action="{{ route('admin.permissions.destroy',$permission->id) }}">
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
                                        <!-- end modal -->
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection

@section('script')
@if($errors->any())
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('showModal'), {
        keyboard: false
        })
        myModal.show()
    </script>
@endif
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script>
    $(document).ready(function () {
        $('#datatableAjax').DataTable({

            processing: true,
            dom: 'Bfrtip',
            buttons: [
                'print',
                {
                    extend: 'excelHtml5',
                    title: 'Physical P.O Box'
                },
                {
                    extend: 'pdfHtml5',
                    title: 'Physical P.O Box'
                }
            ]

        });
    });

</script>
@endsection

