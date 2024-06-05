@extends('layouts.admin.app')
@section('page-name')Mail Registration @endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@php
    $countries = App\Models\Country::country_tarif();
@endphp
@section('body')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                @foreach ($bras as $key => $bra)
                    <h4 class="mb-sm-0">EMS Mail Registration {{ $bra->name }}</h4>
                @endforeach

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS Mail</a>
                        </li>
                        <li class="breadcrumb-item active">EMS Mail</li>
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
                                @foreach ($bras as $key => $bra)
                                    <h5 class="card-title mb-0">EMS MAIL REGISTRATION LIST IN {{ $bra->name }}</h5>
                                @endforeach
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                    <i class="ri-delete-bin-2-line"></i>
                                </button>

                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                    id="create-btn" data-bs-target="#showModal">
                                    <i class="ri-add-line align-bottom me-1"></i>New
                                    EMS Mail
                                </button>


                                {{-- <button type="button" class="btn btn-info">
                                    <i class="ri-file-download-line align-bottom me-1"></i>
                                    Import
                                </button> --}}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-body">
                    <table id="datatableAjax" class="table table-centered table-hover align-middle table-nowrap mb-0"
                        style="width: 100%;">
                        <thead>

                            <tr>
                                <th scope="col" style="width: 80px">
                                    #
                                </th>

                                <th class="sort" data-sort="MAIL CODE">
                                    MAIL CODE
                                </th>
                                <th class="sort" data-sort="TRACKING NUMBER">TRACKING NUMBER</th>
                                <th class="sort" data-sort="NAME">NAME</th>
                                <th class="sort" data-sort="PHONE">PHONE</th>
                                <th class="sort" data-sort="P.O BOX">P.O BOX</th>
                                <th class="sort" data-sort="WEIGHT">WEIGHT</th>
                                <th class="sort" data-sort="DATE">DATE</th>
                                <th class="sort" data-sort="action">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach ($inboxings as $key => $inboxing)
                                <tr>
                                    <th scope="row">
                                        {{ $key + 1 }}
                                    </th>
                                    <td class="MAIL CODE"><a href="">{{ $inboxing->innumber }}</a></td>
                                    <td class="TRACKING NUMBER">{{ $inboxing->intracking }}</td>
                                    <td class="NAME">{{ $inboxing->inname }}</td>
                                    <td class="PHONE">{{ $inboxing->phone }}</td>
                                    <td>
                                        @if (is_null($inboxing->pob_bid))
                                            <span class="badge bg-info">NO P.O BOX</span>
                                        @endif

                                        @if (!is_null($inboxing->pob_bid))
                                            {{ $inboxing->pob }} {{ $inboxing->branches->name }}
                                    </td>
                            @endif



                            <td class="WEIGHT">{{ $inboxing->weight }} {{ $inboxing->unit }}</td>

                            {{-- <tdclass="inboxing">$inboxing->inboxingname->name</td> --}}

                            <td class="date"> {{ $inboxing->created_at->format('d M, Y') }}</td>


                            <td>

                                <a href="#showModal{{ $inboxing->id }}" data-bs-toggle="modal" type="button"
                                    class="btn btn-primary btn-sm"><span>Edit</span></a>

                                <div class="modal fade" id="showModal{{ $inboxing->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light p-3">
                                                <h5 class="modal-title">EMS MAIL INFORMATION UPDATE</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="close-modal"></button>
                                            </div>
                                            <form class="tablelist-form" id="myForm" method="post"
                                                action="{{ route('admin.mailsem.update', $inboxing->id) }}">
                                                @csrf
                                                @method('PUT')
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
                                                        <label for="customername-field" class="form-label">Tracking
                                                            Number</label>
                                                        <input type="text" id="customername-field" name="intracking"
                                                            class="form-control" placeholder="Enter Tracking Number"
                                                            value="{{ $inboxing->intracking }} {{ old('intracking') }}"
                                                            required autocomplete="off" />
                                                        <div class="invalid-feedback">
                                                            Please enter a Tracting Number .
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="name-field" class="form-label">Names</label>
                                                        <input type="text" id="email-field" class="form-control"
                                                            name="inname" placeholder="Enter Names" required
                                                            value="{{ $inboxing->inname }} {{ old('inname') }}"
                                                            autocomplete="off" />
                                                        <div class="invalid-feedback">
                                                            Please enter Names.
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="status-field" class="form-label">Weight
                                                                /Kg</label>
                                                            <input type="text" id="phone-field" name="weight"
                                                                class="form-control phoneNumber"
                                                                placeholder="Enter Weight." required
                                                                value="{{ $inboxing->weight }} {{ old('weight') }}"
                                                                autocomplete="off" />
                                                            <div class="invalid-feedback">
                                                                Please enter a Weight
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="" class="form-label">Phone</label>
                                                            <input type="text" name="phone"
                                                                class="form-control phoneNumber"
                                                                placeholder="Enter phone no." maxlength="10"
                                                                minlength="10"
                                                                value=" {{ $inboxing->phone }} {{ old('phone') }}"
                                                                required autocomplete="off" />
                                                            <div class="invalid-feedback">
                                                                Please enter a phone.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">

                                                        <div class="col-md-6 mb-3">
                                                            <label for="customername-field" class="form-label">P.O BOX
                                                            </label>
                                                            <input type="text" id="customername-field" name="pob"
                                                                class="form-control" placeholder="Enter P.O BOX "
                                                                value="{{ $inboxing->pob }}{{ old('pob') }}"
                                                                autocomplete="off" requiredcnt />
                                                            <div class="invalid-feedback">
                                                                Please enter POB .
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label for="branch" class="form-label">Branch Name</label>
                                                            <select class="form-control" required name="pob_bid"
                                                                id="branch">
                                                                <option value="" disabled selected>Select branch
                                                                </option>
                                                                @foreach ($branches as $branch)
                                                                    <option
                                                                        @if ($inboxing->pob_bid == $branch->id) selected @endif
                                                                        value="{{ $branch->id }}">{{ $branch->name }}
                                                                    </option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="customername-field" class="form-label">Orgin
                                                                Country
                                                            </label>
                                                            <select class="form-select" name="orgcountry" type="text"
                                                                id="countries" required>
                                                                <option value="" disabled selected>Orgin Country
                                                                </option>
                                                                @foreach ($countries as $country)
                                                                    <option
                                                                        {{ old('orgcountry', $inboxing->orgcountry) == $country['c_id'] ? 'selected' : '' }}
                                                                        value="{{ $country['c_id'] }}">
                                                                        {{ $country['countryname'] }}</option>
                                                                @endforeach
                                                            </select>

                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="status-field" class="form-label">Comment</label>
                                                            <select class="form-control" data-choices
                                                                data-choices-search-false name="comment" id="status-field"
                                                                required>
                                                                <option @if (old('comment') == 'Item recieved') selected @endif
                                                                    value="Item recieved">Item recieved</option>
                                                                <option @if (old('comment') == 'Item recieved torn and Repaired at the CNTP') selected @endif
                                                                    value="Item recieved torn and Repaired at the CNTP">
                                                                    Item recieved torn and Repaired at the CNTP</option>

                                                            </select>
                                                        </div>

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
                                                    </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </td>
                            </tr>
                            @endforeach

                        </tbody>
                    </table>
                </div>

            </div>
            <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel">EMS Mail Registration</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" method="post" action="{{ route('admin.mailsem.store') }}">
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
                                <input type="hidden" name="location" value="{{ decrypt($id) }}" />
                                <div class="mb-3">
                                    <label for="customername-field" class="form-label">Tracking
                                        Number</label>
                                    <input type="text" id="customername-field" name="intracking" class="form-control"
                                        placeholder="Enter Tracking Number" value="{{ old('intracking') }}" required
                                        autocomplete="off" />
                                    <div class="invalid-feedback">
                                        Please enter a Tracting Number .
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="name-field" class="form-label">Names</label>
                                    <input type="text" id="email-field" class="form-control" name="inname"
                                        placeholder="Enter Names" required value="{{ old('inname') }}"
                                        autocomplete="off" />
                                    <div class="invalid-feedback">
                                        Please enter Names.
                                    </div>
                                </div>


                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="status-field" class="form-label">Weight /Kg</label>
                                        <input type="text" id="phone-field" name="weight"
                                            class="form-control phoneNumber" placeholder="Enter Weight." required
                                            value="{{ old('weight') }}" autocomplete="off" />
                                        <div class="invalid-feedback">
                                            Please enter a Weight
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="" class="form-label">Phone</label>
                                        <input type="number" name="phone" class="form-control phoneNumber"
                                            placeholder="Enter phone no." required maxlength="10" minlength="10"
                                            value="{{ old('phone') }}" autocomplete="off" />
                                        <div class="invalid-feedback">
                                            Please enter a phone.
                                        </div>
                                    </div>
                                </div>
                                <div class="row">

                                    <div class="col-md-6 mb-3">
                                        <label for="customername-field" class="form-label">P.O BOX
                                        </label>
                                        <input type="text" id="customername-field" name="pob"
                                            class="form-control" placeholder="Enter P.O BOX "
                                            value="{{ old('pob') }}" autocomplete="off" />
                                        <div class="invalid-feedback">
                                            Please enter POB .
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="branch" class="form-label">Branch Name</label>
                                        <select class="form-control" required name="pob_bid" id="branch">
                                            <option value="" disabled selected>Select branch</option>
                                            @foreach ($branches as $branch)
                                                <option @if (old('pob_bid') == $branch->id) selected @endif
                                                    value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="country" class="form-label">Orgin Country
                                        </label>
                                        <select class="form-select" name="orgcountry" type="text" id="country"
                                            required>
                                            <option value="" disabled selected>Orgin Country</option>
                                            @foreach ($countries as $country)
                                                <option {{ old('orgcountry') == $country['c_id'] ? 'selected' : '' }}
                                                    value="{{ $country['c_id'] }}">{{ $country['countryname'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="status-field" class="form-label">Comment</label>
                                        <select class="form-control" data-choices data-choices-search-false name="comment"
                                            id="status-field" required>
                                            <option @if (old('comment') == 'Item recieved') selected @endif
                                                value="Item recieved">Item recieved</option>
                                            <option @if (old('comment') == 'Item recieved torn and Repaired at the CNTP') selected @endif
                                                value="Item recieved torn and Repaired at the CNTP">Item recieved torn and
                                                Repaired at the CNTP</option>

                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-success" id="add-btn">
                                            Save
                                        </button>
                                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                    </div>
                                </div>
                        </form>
                    </div>
                </div>
            </div>


        </div>
    </div>
    </div>
    <!--end col-->
    </div>
    <!--end row-->
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
@section('script')
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
        $(document).ready(function() {
            $('#datatableAjax').DataTable({
                processing: true,


            });
        });
    </script>

@endsection
