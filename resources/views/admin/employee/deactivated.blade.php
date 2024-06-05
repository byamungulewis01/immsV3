@extends('layouts.admin.app')
@section('page-name')Deactivated Employees @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Employees</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">Users</a>
                    </li>
                    <li class="breadcrumb-item active">Deactivated Employees</li>
                </ol>
            </div>
        </div>
    </div>
</div>

<!-- end page title -->
<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">Employee List</h5>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="users" class="table table-centered table-hover align-middle table-nowrap mb-0"
                    style="width: 100%;">
                    <thead>
                        <tr>
                            <th scope="col">
                                #
                            </th>

                            <th class="sort" data-sort="name">
                                Employee Name
                            </th>
                            <th class="sort" data-sort="email">Email</th>
                            <th class="sort" data-sort="phone">Phone</th>
                            <th class="sort" data-sort="branch">Branch</th>
                            <th class="sort" data-sort="date">Joining Date</th>
                            <th class="sort" data-sort="remove">Removed Date</th>
                            <th class="sort" data-sort="action">Action</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->


<div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal"
                    aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="activateForm">
                    @csrf
                    @method('PUT')
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json" trigger="loop" colors="primary:#f7b84b,secondary:#405189" style="width:130px;height:130px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">
                                Are you sure you want to Activate this Employee ?
                            </p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn w-sm btn-danger" id="delete-record">
                            Yes, Activate !
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection
@section('css')
{{-- <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" /> --}}

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script')

{{-- <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script> --}}
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
        $('#users').DataTable({
            scrollX: true,
            ajax: "{{ route('employee.deactivateApi') }}",
            columns: [{
                    data: 'id'
                },
                {
                    data: 'name'
                },
                {
                    data: 'email'
                },
                {
                    data: 'phone'
                },
                {
                    data: 'branch'
                },
                {
                    data: 'create_at'
                },
                {
                    data: 'delete_at'
                },
                {
                    data: ''
                },
            ],
            columnDefs: [{
                    targets: 0,
                    render: function (data, type, row, meta) {
                        return (meta.row) + 1;
                    },
                },
                {
                    targets: 1,
                    render: function (data, type, row) {
                        var name = row.name;
                        return name;
                    },
                },
                {
                    targets: 4,
                    render: function (data, type, row) {
                        var branch = row.branchname;
                        return branch.name
                    },
                },
                {
                    targets: 5,
                    render: function (data, type, row) {
                        var date = new Date(row.created_at).toLocaleDateString('en-US', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                        return date;
                    },
                },
                {
                    targets: 6,
                    render: function (data, type, row) {
                        var date = new Date(row.deleted_at).toLocaleDateString('en-US', {
                            day: 'numeric',
                            month: 'long',
                            year: 'numeric'
                        });
                        return date;
                    },
                },
                {
                    targets: 7,
                    render: function (data, type, row) {
                        return `
                        <a href="" class="btn btn-sm btn-light activate" data-bs-toggle="modal" data-bs-target="#deleteRecordModal"> <span data-id="${row.id}">Activate</span></a>
                        `;
                    },
                },
            ],


        });
    });

    $(document).on('click', '.activate', function () {
        var id = $(this).find('span').data('id');
        var route = "{{ route('admin.employee.activate', ['id' => ':id']) }}";
        route = route.replace(':id', id);
        $('#deleteRecordModal').find('#activateForm').attr('action', route);
    });

</script>

@endsection
