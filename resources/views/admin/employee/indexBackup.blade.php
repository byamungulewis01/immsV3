@extends('layouts.admin.app')
@section('page-name')Employees @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Employees</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS P.O B</a>
                    </li>
                    <li class="breadcrumb-item active">Employees</li>
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
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                                data-bs-target="#showModal">
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
                                                <div class="row mb-3">
                                                    <div class="col-lg-6">
                                                        <label for="level" class="form-label">Employee Level</label>
                                                        <select class="form-control level" name="level" id="level" required>
                                                            <option {{ old('level') == 'NULL' ? 'selected':'' }} value="NULL" selected disabled>-- Select level --
                                                            </option>
                                                            <option {{ old('level') == 'register' ? 'selected':'' }} value="register">Register</option>
                                                            <option {{ old('level') == 'backOffice' ? 'selected':'' }} value="backOffice">Back Office</option>
                                                            <option {{ old('level') == 'branchManager' ? 'selected':'' }} value="branchManager">Branch Manager</option>
                                                            <option {{ old('level') == 'pob' ? 'selected':'' }} value="pob">P.O B</option>
                                                            <option {{ old('level') == 'administrative' ? 'selected':'' }} value="administrative">Administrative</option>
                                                            <option {{ old('level') == 'airport' ? 'selected':'' }} value="airport">Airport</option>
                                                            <option {{ old('level') == 'cntp' ? 'selected':'' }} value="cntp">cntp</option>
                                                            <option {{ old('level') == 'driver' ? 'selected':'' }} value="driver">Driver</option>
                                                        </select>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="office-id" class="form-label">Office</label>
                                                        <select class="form-control office" name="office"
                                                            id="office-id">
                                                            <option {{ old('office') == 'N/A' ? 'selected':'' }}  value="NULL" disabled selected>N/A</option>
                                                            <option {{ old('office') == 'o' ? 'selected':'' }} value="o">Oridinary</option>
                                                            <option {{ old('office') == 'r' ? 'selected':'' }} value="r">Registared</option>
                                                            <option {{ old('office') == 'p' ? 'selected':'' }}  value="p">Percel</option>
                                                            <option  {{ old('office') == 'ems' ? 'selected':'' }}  value="ems">EMS</option>
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
                                                        <label for="status-field" class="form-label">Branch Name</label>
                                                        <select class="form-control" data-choices
                                                            data-choices-search-false name="branch" id="status-field"
                                                            required>
                                                            <option value="" disabled selected>Select branch</option>
                                                            @foreach ($branches as $branch)
                                                            <option @if (old('branch')==$branch->id) selected @endif
                                                                value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="driverDiv" style="display:none">
                                                    <div class="row mb-3">
                                                        <div class="col-lg-6">
                                                            <label for="driverRole" class="form-label">Driver
                                                                Role</label>
                                                            <select class="form-control" name="driverRole"
                                                                id="driverRole">
                                                                <option {{ old('driverRole') == 'chief' ? 'selected':'' }} value="chief" selected>Chief of Driver</option>
                                                                <option {{ old('driverRole') == 'driver' ? 'selected':'' }} value="driver">Driver</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label for="driving_category" class="form-label">Driving
                                                                Category</label>
                                                            <select class="form-control" name="driving_category"
                                                                id="driving_category">
                                                                <option {{ old('driving_category') == 'A' ? 'selected':'' }} value="A" selected>A</option>
                                                                <option {{ old('driving_category') == 'B' ? 'selected':'' }} value="B">B</option>
                                                                <option {{ old('driving_category') == 'C' ? 'selected':'' }} value="C">C</option>
                                                                <option {{ old('driving_category') == 'D' ? 'selected':'' }} value="D">D</option>
                                                                <option {{ old('driving_category') == 'E' ? 'selected':'' }} value="E">E</option>
                                                                <option {{ old('driving_category') == 'F' ? 'selected':'' }} value="F">F</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="driving_licence" class="form-label">Driving
                                                            Licence</label>
                                                        <input type="file" id="driving_licence" name="driving_licence"
                                                            class="form-control" />

                                                    </div>
                                                </div>




                                            </div>
                                            <div class="modal-footer">
                                                <div class="hstack gap-2 justify-content-end">
                                                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
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

                            @endcan

                            {{-- <button type="button" class="btn btn-info">
                                    <i class="ri-file-download-line align-bottom me-1"></i>
                                    Import
                                </button> --}}
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
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
                            <th class="sort" data-sort="status">Status</th>
                            <th class="sort" data-sort="action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($employees as $key => $employee)
                        <tr>
                            <td scope="row">
                                {{ $key + 1 }}
                            </td>
                            <td class="name"><a href="{{ route('admin.employee.profile',$employee->id) }}">{{ $employee->name }}</a>
                            </td>
                            <td class="email">{{ $employee->email }}</td>
                            <td class="phone">{{ $employee->phone }}</td>
                            <td class="branch">{{ $employee->branchname->name }}</td>

                            <td class="date"> {{ $employee->created_at->format('d M, Y') }}</td>
                            <td class="status">
                                @if ($employee->status == 'active')
                                <span class="badge badge-soft-success text-uppercase">Active</span>
                                @else
                                <span class="badge badge-soft-danger text-uppercase">inactive</span>
                                @endif
                            </td>
                            <td>
                                @can('update employee')
                                <a type="button" class="btn btn-primary btn-sm edit-record{{ $employee->id }}"><span
                                        data-name="{{ $employee->name }}" data-email="{{ $employee->email }}"
                                        data-phone="{{ $employee->phone }}" data-branch="{{ $employee->branch }}"
                                        data-status="{{ $employee->status }}"
                                        data-id="{{ $employee->id }}">Edit</span></a>
                                @endcan

                                @can('delete employee')
                                <a href="#deleteRecordModal" data-bs-toggle="modal" type="button"
                                    class="btn btn-danger btn-sm"><span>Delete</span></a>
                                @endcan

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


<!-- Modal -->
<div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal"
                    aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">
                <form method="post" action="{{ route('admin.employee.destroy',$employee->id) }}">
                    @csrf
                    @method('DELETE')
                    <div class="mt-2 text-center">
                        <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                            colors="primary:#f7b84b,secondary:#f06548" style="width: 100px; height: 100px"></lord-icon>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">
                                Are you sure you want to remove this record ?
                            </p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn w-sm btn-danger" id="delete-record">
                            Yes, Delete It!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end modal -->

@endsection
@section('css')
<!--datatable css-->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
<!--datatable responsive css-->
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

<link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
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


<!--open editUser model js-->
<script>
    var office = document.querySelector('.office');
    var level = document.querySelector('.level');
    var driverDiv = document.querySelector('.driverDiv');
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

</script>

<!--datatable js-->

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

<!--datatable js-->
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>

<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

@endsection
