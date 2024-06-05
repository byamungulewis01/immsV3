@extends('layouts.admin.app')
@section('page-name')Active Employees @endsection
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
                    <li class="breadcrumb-item active">Active Employees</li>
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
                            <th class="sort" data-sort="status">Status</th>
                            <th class="sort" data-sort="date">Joining Date</th>
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

@include('admin.employee.model')


@endsection
@section('css')
{{-- <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" /> --}}

<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script')
@if (old('id'))
@if($errors->any())
<script>
    var myModal = new bootstrap.Modal(document.getElementById('editUser'), {keyboard: false })
    myModal.show()
</script>
@endif
@else
  @if($errors->any())
    <script>
        var myModal = new bootstrap.Modal(document.getElementById('showModal'), { keyboard: false})
        myModal.show()
    </script>
  @endif
@endif

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
<script>
  $(document).ready(function () {
    var office = document.querySelector('.office'),
    level = document.querySelector('.level'),
    driverDiv = document.querySelector('.driverDiv');
    level.addEventListener("change", function () {
        if (level.value == 'register') {
            office.disabled = false;
            office.required = true;
            driverDiv.style.display = 'none';
        } else if (level.value == 'driver') {
            office.disabled = true;
            office.required = false;
            driverDiv.style.display = 'block';
        } else {
            office.disabled = true;
            office.required = false;
            driverDiv.style.display = 'none';
        }
    });
  });
  $(document).ready(function () {
    var office = document.querySelector('.office1'),
    level = document.querySelector('.level1'),
    driverDiv = document.querySelector('.driverDiv1');
    level.addEventListener("change", function () {
        if (level.value == 'register') {
            office.disabled = false;
            office.required = true;
            driverDiv.style.display = 'none';
        } else if (level.value == 'driver') {
            office.disabled = true;
            office.required = false;
            driverDiv.style.display = 'block';
        } else {
            office.disabled = true;
            office.required = false;
            driverDiv.style.display = 'none';
        }
    });
  });

</script>

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
            ajax: "{{ route('employee.activeApi') }}",
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
                    data: 'status'
                },
                {
                    data: 'create_at'
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
                        var id = row.id;
                        var name = row.name;
                        var route = "{{ route('admin.employee.profile', ['id' => ':id']) }}";
                        route = route.replace(':id', id);
                        var link = `<a href="${route}"> ${name} </a>`;
                        return link;
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
                        if (row.status == 'active') {
                            return '<span class="badge bg-success text-uppercase">Active</span>';
                        } else {
                            return '<span class="badge bg-danger text-uppercase">Inactive</span>';
                        }
                    },
                },
                {
                    targets: 6,
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
                    targets: 7,
                    render: function (data, type, row) {
                        var id = row.id;
                        var name = row.name;
                        var route = "{{ route('admin.employee.profile', ['id' => ':id']) }}";
                        route = route.replace(':id', id);
                        return `
                        <a href="${route}" class="btn btn-sm btn-success">View</a>
                        <button class="btn btn-sm btn-primary editUser" data-bs-toggle="modal" data-bs-target="#editUser">
                        <span data-id="${row.id}" data-name="${row.name}"  data-status="${row.status}" data-email="${row.email}" data-phone="${row.phone}" data-branch="${row.branch}" data-level="${row.level}" data-office="${row.office}" data-driverRole="${row.driverRole}" data-driving_category="${row.driving_category}">Edit</span>
                        </button>
                        <a href="" class="btn btn-sm btn-danger deleteUser" data-bs-toggle="modal" data-bs-target="#deleteRecordModal"> <span data-id="${row.id}">Delete</span></a>
                        `;
                    },
                },
            ],
            order: [],


        });
    });

    $(document).on('click', '.editUser', function () {
        var id = $(this).find('span').data('id');
        var name = $(this).find('span').data('name');
        var email = $(this).find('span').data('email');
        var phone = $(this).find('span').data('phone');
        var status = $(this).find('span').data('status');
        var branch = $(this).find('span').data('branch');
        var level = $(this).find('span').data('level');
        var office = $(this).find('span').data('office');
        var driverRole = $(this).find('span').data('driverRole');
        var driving_category = $(this).find('span').data('driving_category');


        // Populate the modal fields with the retrieved data
        $('#editUser').find('#id').val(id);
        $('#editUser').find('#name').val(name);
        $('#editUser').find('#email').val(email);
        $('#editUser').find('#phone').val(phone);
        $('#editUser').find('#branch').val(branch);
        $('#editUser').find('#userStatus').val(status);
        $('#editUser').find('#level').val(level);
        $('#editUser').find('#office').val(office);
        $('#editUser').find('#driverRole').val(driverRole);
        $('#editUser').find('#driving_category').val(driving_category);

        var route = "{{ route('admin.employee.update', ['id' => ':id']) }}";
        route = route.replace(':id', id);

        $('#updateform').attr('action', route);

    });
    $(document).on('click', '.deleteUser', function () {
        var id = $(this).find('span').data('id');
        var route = "{{ route('admin.employee.destroy', ['id' => ':id']) }}";
        route = route.replace(':id', id);
        $('#deleteRecordModal').find('#deleteForm').attr('action', route);
    });

</script>

@endsection
