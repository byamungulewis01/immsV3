<!-- Modal -->
<div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal"
                    aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="deleteForm">
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
<div class="modal fade" id="editUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog model-lg">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="exampleModalLabel">Employee Update</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                    id="close-modal"></button>
            </div>
            <form id="updateform" class="tablelist-form" method="post" action="{{ route('admin.employee.store') }}"
                enctype="multipart/form-data">
                @csrf
                @method('PUT')
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
                            <input type="hidden" name="id" id="id" value="{{ old('id') }}">
                            <select class="form-control level" id="level" name="level" required>
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
                        <label for="name" class="form-label">Employee
                            Name</label>
                        <input type="text" id="name" name="name" class="form-control"
                            placeholder="Enter name" value="{{ old('name') }}" required />
                        <div class="invalid-feedback">
                            Please enter a employee name.
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" id="email" class="form-control" name="email" placeholder="Enter email"
                            required value="{{ old('email') }}" />
                        <div class="invalid-feedback">
                            Please enter an email.
                        </div>
                    </div>

                    <div class="row mb-3 ">
                        <div class="col-lg-6">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="text" id="phone" name="phone" class="form-control phoneNumber"
                                minlength="10" maxlength="10" placeholder="Enter phone no." required
                                value="{{ old('phone') }}" />
                            <div class="invalid-feedback">
                                Please enter a phone.
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <label for="branch" class="form-label">Branch Name</label>
                            <select class="form-control" name="branch"
                                id="branch" required>
                                <option value="" disabled selected>Select branch</option>
                                @foreach ($branches as $branch)
                                <option @if (old('branch')==$branch->id) selected @endif
                                    value="{{ $branch->id }}">{{ $branch->name }}</option>
                                @endforeach

                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="userStatus" class="form-label">Status</label>
                        <select class="form-select" name="status" id="userStatus" aria-label="Default select example">
                            <option {{ old('status') == 'active' ? 'selected' : '' }} value="active">Active</option>
                            <option {{ old('status') == 'inactive' ? 'selected' : '' }} value="inactive">Inactive</option>
                        </select>
                    </div>
                    <div class="driverDiv1" style="display:none">
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="driverRole" class="form-label">Driver
                                    Role</label>
                                <select class="form-control" name="driverRole" id="driverRole">
                                    <option {{ old('driverRole') == 'chief' ? 'selected':'' }} value="chief" selected>
                                        Chief of Driver</option>
                                    <option {{ old('driverRole') == 'driver' ? 'selected':'' }} value="driver">Driver
                                    </option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="driving_category" class="form-label">Driving
                                    Category</label>
                                <select class="form-control" name="driving_category" id="driving_category">
                                    <option {{ old('driving_category') == 'A' ? 'selected':'' }} value="A" selected>A
                                    </option>
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
                            <input type="file" id="driving_licence" name="driving_licence" class="form-control" />

                        </div>
                    </div>

                </div>
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn btn-success" id="add-btn">
                            Save changes
                        </button>
                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
