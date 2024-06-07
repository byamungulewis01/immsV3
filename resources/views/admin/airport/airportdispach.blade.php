@extends('layouts.admin.app')
@section('page-name')
    Mail Dispatch
@endsection
@php
    $countries = App\Models\Country::country_tarif();
@endphp
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
                <h4 class="mb-sm-0">DISPATCH REGISTRATION</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS</a>
                        </li>
                        <li class="breadcrumb-item active">Mail Dispach</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <form action="{{ route('admin.inbox.update') }}" method="post">
            @csrf
            @method('PUT')
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">DISPATCH LIST</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">

                                    <a class="btn btn-soft-primary" style="display: none;" id="deleteBtn"
                                        href="#deleteRecordModal" data-bs-toggle="modal">
                                        Transfer To CNTP || G7 || EMS
                                    </a>

                                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#showModal">
                                        <i class="ri-add-line align-bottom me-1"></i>NEW DISPATCH
                                    </button>

                                    <!-- Modal -->
                                    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" id="deleteRecord-close"
                                                        data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="mt-2 text-center">

                                                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                            <h4>Are you Sure To Transfer Dispatch?</h4>
                                                            <p class="text-muted mx-4 mb-0">

                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                        <button type="button" class="btn w-sm btn-light"
                                                            data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn w-sm btn-primary"
                                                            id="delete-record">
                                                            Yes, Approve It!
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end modal -->


        </form>



    </div>
    </div>
    </div>
    </div>
    <div class="card-body">
        <table id="datatableAjax" class="table table-centered table-hover align-middle table-nowrap mb-0"
            style="width: 100%;">
            <thead>
                <tr>
                    <th>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                        </div>
                    </th>
                    <th scope="col">
                        #
                    </th>

                    <th class="sort" data-sort="name">
                        Dispatch Number
                    </th>

                    <th class="sort" data-sort="phone">Gross Weight (Kg)</th>
                    <th class="sort" data-sort="branch">Dispatch Type</th>
                    <th class="sort" data-sort="branch">Number of Items</th>
                    <th class="sort" data-sort="branch">Country</th>
                    <th class="sort" data-sort="date">Date</th>
                    <th class="sort" data-sort="status">Status</th>
                    <th class="sort" data-sort="action">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inboxings as $key => $inboxing)
                    <tr>
                        <td scope="row">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="dispatchid[]"
                                    value="{{ $inboxing->id }}">
                            </div>
                        </td>
                        <td scope="row">
                            {{ $key + 1 }}
                        </td>
                        <td class="name">{{ $inboxing->dispatchNumber }}</>
                        </td>
                        <td class="email">{{ $inboxing->grossweight }}</td>

                        <td class="phone">{{ ($inboxing->dispachetype == 'PERCEL' ? 'Parcel' : $inboxing->dispachetype) }}</td>
                        <td class="phone">{{ $inboxing->numberitem }}</td>
                        <td class="country">{{  Str::words($inboxing->country->countryname, 2, ' ...') }}</td>


                        <td class="date"> {{ $inboxing->created_at->format('d M, Y') }}</td>

                        <td>
                            @if ($inboxing->status == 0)
                                <span class="badge bg-success">Pending</span>
                            @elseif($inboxing->status == 1)
                                <span class="badge bg-info">Transfered</span>
                            @elseif ($inboxing->status == 2)
                                <span class="badge bg-primary">CNTP Approved</span>
                            @elseif ($inboxing->status == 3)
                                <span class="badge bg-primary">Dispatch Opened</span>
                            @endif
                        </td>
                        <td>

                            <a href="#show{{ $inboxing->id }}" data-bs-toggle="modal" type="button"
                                class="btn btn-primary btn-sm"><span>Edit</span></a>
                            <div class="modal fade" id="show{{ $inboxing->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title">DISPACH INFORMATION UPDATE</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form class="tablelist-form" id="myForm" method="post"
                                            action="{{ route('admin.inbox.AirportDispacheup', $inboxing->id) }}">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">

                                                <div class="mb-3">
                                                    @if ($errors->any())
                                                        <div class="alert alert-danger">
                                                            <p><strong>Opps Something went wrong</strong>
                                                            </p>
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                    <li>* {{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    @endif
                                                </div>
                                                <div class="mb-3">
                                                    <label for="dispatchNumber" class="form-label">Dispatch Number
                                                    </label>
                                                    <input type="text" id="dispatchNumber" name="dispatchNumber"
                                                        class="form-control" placeholder="Enter Dispach Number"
                                                        value="{{ $inboxing->dispatchNumber }} {{ old('dispatchNumber') }}"
                                                        required autocomplete="off" />
                                                    <div class="invalid-feedback">
                                                        Please enter Orgin Country .
                                                    </div>

                                                </div>



                                                <div class="row">
                                                    <div class="col-md-6 mb-3">

                                                        <label for="grossweight" class="form-label">Gross
                                                            Weight/kg</label>
                                                        <input type="number" id="grossweight" class="form-control"
                                                            name="grossweight" placeholder="Enter Gross Weight" required
                                                            value="{{ $inboxing->grossweight }} {{ old('grossweight') }}"
                                                            autocomplete="off" />
                                                        <div class="invalid-feedback">
                                                            Please enter grossweight.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="mailweight" class="form-label">Mail Weight/Kg
                                                        </label>
                                                        <input type="number" id="mailweight" name="mailweight"
                                                            class="form-control" placeholder=" Mail Weight"
                                                            value="{{ $inboxing->grossweight }} {{ old('mailweight') }}"
                                                            autocomplete="off" />
                                                        <div class="invalid-feedback">
                                                            Please enter Mail Weight
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="numberitem" class="form-label">Number of Item
                                                        </label>
                                                        <input type="number" id="numberitem" name="numberitem"
                                                            class="form-control" placeholder="Enter Number of Item"
                                                            value="{{ $inboxing->numberitem }} {{ old('numberitem') }}"
                                                            required autocomplete="off" />
                                                        <div class="invalid-feedback">
                                                            Please enter numberitem
                                                        </div>

                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="currentweight" class="form-label">Current Weight
                                                            (kg)
                                                        </label>
                                                        <input type="number" id="currentweight"
                                                            name="currentweight" class="form-control"
                                                            placeholder="Current Weight"
                                                            value="{{ $inboxing->currentweight }} {{ old('currentweight') }}"
                                                            autocomplete="off" />
                                                        <div class="invalid-feedback">
                                                            Please enter current weight
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="dispachetype" class="form-label">Dispatch Type</label>
                                                        <select class="form-control" data-choices data-choices-search-false
                                                            name="dispachetype" id="dispachetype" required>
                                                            <option value="Mails" selected>
                                                                Mails</option>
                                                            <option {{ old('dispachetype') == 'EMS' ? 'selected' : '' }}
                                                                @if ($inboxing->dispachetype == 'EMS') selected @endif
                                                                value="EMS">EMS
                                                            </option>
                                                            <option {{ old('dispachetype') == 'PERCEL' ? 'selected' : '' }}
                                                                @if ($inboxing->dispachetype == 'PERCEL') selected @endif
                                                                value="PERCEL">
                                                                PARCEL
                                                            </option>


                                                            </option>
                                                        </select>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="countries" class="form-label">Orgin
                                                            Country</label>

                                                        <select class="form-select" name="orgincountry" id="countries"
                                                            required>
                                                            <option value="" disabled selected>Orgin Country</option>
                                                            @foreach ($countries as $country)
                                                                <option
                                                                    {{ $country['c_id'] == $inboxing->orgincountry ? 'selected' : '' }}
                                                                    value="{{ $country['c_id'] }}">
                                                                    {{ $country['countryname'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="comment" class="form-label">Comment</label>
                                                    <textarea class="form-control" id="comment" name="comment" rows="3"
                                                        placeholder="Enter your comment">{{ $inboxing->comment }}  {{ old('comment') }}</textarea>

                                                </div>
                                                <div class="modal-footer">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn btn-success" id="add-btn"
                                                            onclick="submitForm()">
                                                            UPDATE
                                                        </button>
                                                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                    </div>
                                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->


                                        </form>
                                    </div>



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


    <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">Dispatch Information Registration</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form class="tablelist-form" method="post" action="{{ route('admin.inbox.store') }}"
                    x1onsubmit="disableSubmitButton()">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            @if ($errors->any())
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
                            <label for="dispatchNumber" class="form-label">Dispatch Number
                            </label>
                            <input type="text" id="dispatchNumber" name="dispatchNumber" class="form-control"
                                placeholder="Enter Dispatch Number" value="{{ old('dispatchNumber') }}" required
                                autocomplete="off" />
                            <div class="invalid-feedback">
                                Please enter Orgin Country .
                            </div>

                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">

                                <label for="grossweight" class="form-label">Gross Weight(kg)</label>
                                <input type="number" min="0" step="0.1" id="grossweight" class="form-control"
                                    name="grossweight" placeholder="Enter Gross Weight" required
                                    value="{{ old('grossweight') }}" />
                                <div class="invalid-feedback">
                                    Please enter grossweight.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="mailweight" class="form-label">Mail Weight(kg)
                                </label>
                                <input type="number" min="0" step="0.1" id="mailweight" name="mailweight"
                                    class="form-control" placeholder="Mail Weight" value="{{ old('mailweight') }}"
                                    autocomplete="off" />
                                <div class="invalid-feedback">
                                    Please enter Mail Weight
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="number_item" class="form-label">Number of Item
                                </label>
                                <input type="number" min="0" id="number_item" name="numberitem"
                                    class="form-control" placeholder="Enter Number of Item"
                                    value="{{ old('numberitem') }}" required autocomplete="off" />
                                <div class="invalid-feedback">
                                    Please enter numberitem
                                </div>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="currentweigth" class="form-label">Current Weight(kg)
                                </label>
                                <input type="number" min="0" step="0.1" id="currentweigth" name="currentweight"
                                    class="form-control" placeholder="Current Weight" value="{{ old('currentweight') }}"
                                    autocomplete="off" />
                                <div class="invalid-feedback">
                                    Please enter current weight
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status-field" class="form-label">Dispatch Type</label>
                                <select class="form-control" data-choices data-choices-search-false name="dispachetype"
                                    id="status-field" required>
                                    <option value="" disabled selected>Dispatch Type</option>
                                    <option {{ old('dispachetype') == 'EMS' ? 'selected' : '' }} value="EMS">EMS
                                    </option>
                                    <option {{ old('dispachetype') == 'PERCEL' ? 'selected' : '' }} value="PERCEL">PARCEL
                                    </option>
                                    <option {{ old('dispachetype') == 'Mails' ? 'selected' : '' }} value="Mails">Mails
                                    </option>
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="countries" class="form-label">Orgin Country</label>

                                <select class="form-select" name="orgincountry" type="text" id="countries" required>
                                    <option value="" disabled selected>Orgin Country</option>
                                    @foreach ($countries as $country)
                                        <option value="{{ $country['c_id'] }}">{{ $country['countryname'] }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>



                        <div class="mb-3">
                            <label for="comment" class="form-label">Comment</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3"
                                placeholder="Enter your comment">{{ old('comment') }}</textarea>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-success" id="submitButton">
                                Save
                            </button>
                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script')
    @if ($errors->any())
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('showModal'), {
                keyboard: false
            })
            myModal.show()
        </script>
    @endif
    <script>
        var checkAll = document.getElementById("checkAll");
        var checkboxes = document.querySelectorAll("tbody input[type=checkbox]");
        var deleteBtn = document.getElementById("deleteBtn");

        checkAll.addEventListener("change", function(e) {
            var t = e.target.checked;
            checkboxes.forEach(function(e) {
                e.checked = t;
            });
            toggleDeleteBtn();
        });

        checkboxes.forEach(function(e) {
            e.addEventListener("change", function(e) {
                checkAll.checked = Array.from(checkboxes).every(function(e) {
                    return e.checked;
                });
                toggleDeleteBtn();
            });
        });

        function toggleDeleteBtn() {
            var checkedBoxes = document.querySelectorAll("tbody input[type=checkbox]:checked");
            if (checkedBoxes.length > 0) {
                deleteBtn.style.display = "block";
            } else {
                deleteBtn.style.display = "none";
            }
        }
    </script>
    <script>
        function disableSubmitButton() {
            document.getElementById('submitButton').disabled = true;
        }
    </script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#datatableAjax').DataTable({
                processing: true,


            });
        });
    </script>
@endsection
