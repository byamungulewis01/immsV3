@extends('layouts.admin.app')
@section('page-name')
    Employees
@endsection
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
                        <li class="breadcrumb-item active">All Employees</li>
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
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                    <i class="ri-delete-bin-2-line"></i>
                                </button>
                                @can('create employee')
                                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#showModal">
                                        <i class="ri-add-line align-bottom me-1"></i> Add
                                        Employee
                                    </button>
                                    <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog model-lg">
                                            <div class="modal-content">
                                                <div class="modal-header p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Employee Registration</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" method="post"
                                                    action="{{ route('admin.employee.store') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">

                                                        @if ($errors->any())
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

                                                        <div class="row mb-3">
                                                            <div class="col-lg-6">
                                                                <label for="level" class="form-label">Employee Type</label>
                                                                <select class="form-control level" name="level" required>
                                                                    <option {{ old('level') == 'NULL' ? 'selected' : '' }}
                                                                        value="NULL" selected disabled>-- Select level --
                                                                    </option>
                                                                    <option {{ old('level') == 'register' ? 'selected' : '' }}
                                                                        value="register">Register</option>
                                                                    <option {{ old('level') == 'backOffice' ? 'selected' : '' }}
                                                                        value="backOffice">Back Office</option>
                                                                    <option
                                                                        {{ old('level') == 'branchManager' ? 'selected' : '' }}
                                                                        value="branchManager">Branch Manager</option>
                                                                    <option {{ old('level') == 'pob' ? 'selected' : '' }}
                                                                        value="pob">P.O B</option>
                                                                    <option
                                                                        {{ old('level') == 'administrative' ? 'selected' : '' }}
                                                                        value="administrative">Administrative</option>
                                                                    {{-- <option {{ old('level') == 'airport' ? 'selected' : '' }}
                                                                        value="airport">Airport</option> --}}
                                                                    <option {{ old('level') == 'cntp' ? 'selected' : '' }}
                                                                        value="cntp">CNTP</option>
                                                                    {{-- <option {{ old('level') == 'driver' ? 'selected' : '' }}
                                                                        value="driver">Driver</option> --}}
                                                                </select>
                                                            </div>
                                                            <div style="display:block" class="col-lg-6 registerDiv">
                                                                <label for="office-id" class="form-label">Register
                                                                    Office</label>
                                                                <select class="form-control office" name="office"
                                                                    id="office-id">
                                                                    <option {{ old('office') == 'N/A' ? 'selected' : '' }}
                                                                        value="NULL" disabled selected>N/A</option>
                                                                    <option {{ old('office') == 'o' ? 'selected' : '' }}
                                                                        value="o">Oridinary</option>
                                                                    <option {{ old('office') == 'r' ? 'selected' : '' }}
                                                                        value="r">Registared</option>
                                                                    <option {{ old('office') == 'p' ? 'selected' : '' }}
                                                                        value="p">Percel</option>
                                                                    <option {{ old('office') == 'ems' ? 'selected' : '' }}
                                                                        value="ems">EMS</option>

                                                                </select>
                                                            </div>
                                                            <div style="display:none" class="col-lg-6 cntpDiv">
                                                                <label for="office" class="form-label">CNTP Office
                                                                </label>
                                                                <select class="form-control cntpoffice" name="cntpoffice">
                                                                    <option disabled selected>Select CNTP Office</option>
                                                                    <option
                                                                        {{ old('cntpoffice') == 'emscntp' ? 'selected' : '' }}
                                                                        value="emscntp">EMS Office</option>
                                                                    <option
                                                                        {{ old('office') == 'perceloffice' ? 'selected' : '' }}
                                                                        value="perceloffice">Percel Office</option>
                                                                    <option
                                                                        {{ old('cntpoffice') == 'boxoffice' ? 'selected' : '' }}
                                                                        value="boxoffice">Boxing Office</option>
                                                                    <option
                                                                        {{ old('cntpoffice') == 'cntpoffice' ? 'selected' : '' }}
                                                                        value="cntpoffice">CNTP Office</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="customername-field" class="form-label">Employee
                                                                Name</label>
                                                            <input type="text" id="customername-field" name="name"
                                                                class="form-control" placeholder="Enter name"
                                                                value="{{ old('name') }}" required />
                                                            <div class="invalid-feedback">
                                                                Please enter a employee name.
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="email-field" class="form-label">Email</label>
                                                            <input type="email" id="email-field" class="form-control"
                                                                name="email" placeholder="Enter email" required
                                                                value="{{ old('email') }}" />
                                                            <div class="invalid-feedback">
                                                                Please enter an email.
                                                            </div>
                                                        </div>

                                                        <div class="row mb-3 ">
                                                            <div class="col-lg-6">
                                                                <label for="phone-field" class="form-label">Phone</label>
                                                                <input type="text" id="phone-field" name="phone"
                                                                    class="form-control phoneNumber" minlength="10"
                                                                    maxlength="10" placeholder="Enter phone no." required
                                                                    value="{{ old('phone') }}" />
                                                                <div class="invalid-feedback">
                                                                    Please enter a phone.
                                                                </div>
                                                            </div>

                                                            <div class="col-lg-6">
                                                                <label for="status-field" class="form-label">Branch
                                                                    Name</label>
                                                                <select class="form-control" data-choices
                                                                    data-choices-search-false name="branch" id="status-field"
                                                                    required>
                                                                    <option value="" disabled selected>Select branch
                                                                    </option>
                                                                    @foreach ($branches as $branch)
                                                                        <option
                                                                            @if (old('branch') == $branch->id) selected @endif
                                                                            value="{{ $branch->id }}">{{ $branch->name }}
                                                                        </option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>


                                                        {{-- <div class="driverDiv" style="display:none">
                                                            <div class="row mb-3">
                                                                <div class="col-lg-6">
                                                                    <label for="driverRole" class="form-label">Driver
                                                                        Role</label>
                                                                    <select class="form-control" name="driverRole"
                                                                        id="driverRole">
                                                                        <option
                                                                            {{ old('driverRole') == 'chief' ? 'selected' : '' }}
                                                                            value="chief" selected>Chief of Driver</option>
                                                                        <option
                                                                            {{ old('driverRole') == 'driver' ? 'selected' : '' }}
                                                                            value="driver">Driver</option>
                                                                    </select>
                                                                </div>

                                                                <div class="col-lg-6">
                                                                    <label for="driving_category" class="form-label">Driving
                                                                        Category</label>
                                                                    <select class="form-control" name="driving_category"
                                                                        id="driving_category">
                                                                        <option
                                                                            {{ old('driving_category') == 'A' ? 'selected' : '' }}
                                                                            value="A" selected>A</option>
                                                                        <option
                                                                            {{ old('driving_category') == 'B' ? 'selected' : '' }}
                                                                            value="B">B</option>
                                                                        <option
                                                                            {{ old('driving_category') == 'C' ? 'selected' : '' }}
                                                                            value="C">C</option>
                                                                        <option
                                                                            {{ old('driving_category') == 'D' ? 'selected' : '' }}
                                                                            value="D">D</option>
                                                                        <option
                                                                            {{ old('driving_category') == 'E' ? 'selected' : '' }}
                                                                            value="E">E</option>
                                                                        <option
                                                                            {{ old('driving_category') == 'F' ? 'selected' : '' }}
                                                                            value="F">F</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="driving_licence" class="form-label">Driving
                                                                    Licence</label>
                                                                <input type="file" id="driving_licence"
                                                                    name="driving_licence" class="form-control" />

                                                            </div>
                                                        </div> --}}

                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">
                                                                Close
                                                            </button>
                                                            <button type="submit" class="btn btn-success" id="add-btn">
                                                                Add Employee
                                                            </button>
                                                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end modal -->
                                @endcan
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
        @if ($errors->any())
            <script>
                var myModal = new bootstrap.Modal(document.getElementById('editUser'), {
                    keyboard: false
                })
                myModal.show()
            </script>
        @endif
    @else
        @if ($errors->any())
            <script>
                var myModal = new bootstrap.Modal(document.getElementById('showModal'), {
                    keyboard: false
                })
                myModal.show()
            </script>
        @endif
    @endif

    <script>
        $(document).ready(function() {
            $(".phoneNumber").on("input", function() {
                var value = $(this).val();
                var decimalRegex = /^[0-9]+(\.[0-9]{1,2})?$/;
                if (!decimalRegex.test(value)) {
                    $(this).val(value.substring(0, value.length - 1));
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            var office = document.querySelector('.office'),
                level = document.querySelector('.level'),
                driverDiv = document.querySelector('.driverDiv');
            cntpDiv = document.querySelector('.cntpDiv');
            registerDiv = document.querySelector('.registerDiv');

            cntpDiv = document.querySelector('.cntpDiv');
            cntpoffice = document.querySelector('.cntpoffice');

            level.addEventListener("change", function() {
                if (level.value == 'register') {
                    office.disabled = false;
                    office.required = true;
                    driverDiv.style.display = 'none';

                    cntpDiv.style.display = 'none';
                    cntpoffice.disabled = true;
                    cntpoffice.required = false;
                    registerDiv.style.display = 'block';
                } else if (level.value == 'driver') {
                    office.disabled = true;
                    office.required = false;
                    driverDiv.style.display = 'block';
                    cntpDiv.style.display = 'none';
                    registerDiv.style.display = 'block';

                    cntpoffice.disabled = true;
                    cntpoffice.required = false;
                } else if (level.value == 'cntp') {
                    office.disabled = true;
                    office.required = false;
                    cntpoffice.disabled = false;

                    cntpDiv.style.display = 'block';
                    registerDiv.style.display = 'none';

                    cntpoffice.disabled = false;
                    cntpoffice.required = true;
                } else {
                    office.disabled = true;
                    office.required = false;
                    driverDiv.style.display = 'none';
                    registerDiv.style.display = 'block';
                    cntpDiv.style.display = 'none';

                    cntpoffice.disabled = true;
                    cntpoffice.required = false;
                }
            });
        });
        // $(document).ready(function() {
        //     var office = document.querySelector('.office1'),
        //         level = document.querySelector('.level1'),
        //         driverDiv = document.querySelector('.driverDiv1');
        //     cntpDiv = document.querySelector('.cntpDiv');
        //     registerDiv = document.querySelector('.registerDiv');
        //     level.addEventListener("change", function() {
        //         if (level.value == 'register') {
        //             office.disabled = false;
        //             office.required = true;
        //             driverDiv.style.display = 'none';
        //             registerDiv.style.display = 'none';
        //         } else if (level.value == 'driver') {
        //             office.disabled = true;
        //             office.required = false;
        //             cntpDiv.style.display = 'none';
        //             registerDiv.style.display = 'block';
        //             driverDiv.style.display = 'block';

        //         } else if (level.value == 'cntp') {
        //             office.disabled = true;
        //             office.required = false;
        //             cntpDiv.style.display = 'block';
        //             registerDiv.style.display = 'none';
        //         } else {
        //             office.disabled = true;
        //             office.required = false;
        //             driverDiv.style.display = 'none';
        //             registerDiv.style.display = 'block';
        //             cntpDiv.style.display = 'none';

        //         }
        //     });
        // });
    </script>

    {{-- <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script> --}}
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#users').DataTable({
                scrollX: true,
                ajax: "{{ route('employee.api') }}",
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
                        render: function(data, type, row, meta) {
                            return (meta.row) + 1;
                        },
                    },
                    {
                        targets: 1,
                        render: function(data, type, row) {
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
                        render: function(data, type, row) {
                            var branch = row.branchname;
                            return branch.name
                        },
                    },
                    {
                        targets: 5,
                        render: function(data, type, row) {
                            if (row.status == 'active') {
                                return '<span class="badge bg-success text-uppercase">Active</span>';
                            } else {
                                return '<span class="badge bg-danger text-uppercase">Inactive</span>';
                            }
                        },
                    },
                    {
                        targets: 6,
                        render: function(data, type, row) {
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
                        render: function(data, type, row) {
                            var id = row.id;
                            var name = row.name;
                            var route = "{{ route('admin.employee.profile', ['id' => ':id']) }}";
                            route = route.replace(':id', id);
                            return `
                        <a href="${route}" class="btn btn-sm btn-success">View</a>
                        <button class="btn btn-sm btn-primary editUser" data-bs-toggle="modal" data-bs-target="#editUser">
                        <span data-id="${row.id}" data-name="${row.name}" data-email="${row.email}" data-status="${row.status}" data-phone="${row.phone}" data-branch="${row.branch}" data-level="${row.level}" data-office="${row.office}" data-driverRole="${row.driverRole}" data-driving_category="${row.driving_category}">Edit</span>
                        </button>
                        <a href="" class="btn btn-sm btn-danger deleteUser" data-bs-toggle="modal" data-bs-target="#deleteRecordModal"> <span data-id="${row.id}">Delete</span></a>
                        `;
                        },
                    },
                ],
                order: [],


            });
        });

        $(document).on('click', '.editUser', function() {
            var id = $(this).find('span').data('id');
            var name = $(this).find('span').data('name');
            var email = $(this).find('span').data('email');
            var phone = $(this).find('span').data('phone');
            var branch = $(this).find('span').data('branch');
            var status = $(this).find('span').data('status');
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
        $(document).on('click', '.deleteUser', function() {
            var id = $(this).find('span').data('id');
            var route = "{{ route('admin.employee.destroy', ['id' => ':id']) }}";
            route = route.replace(':id', id);
            $('#deleteRecordModal').find('#deleteForm').attr('action', route);
        });
    </script>
@endsection
