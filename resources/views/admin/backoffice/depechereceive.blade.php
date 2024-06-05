@extends('layouts.admin.app')
@section('page-name')
    DISPATCH RECEIVING
@endsection
@section('body')
    @php
        use App\Models\Eric\Transferdatails;
        use App\Models\Eric\Inboxing;
        use App\Models\Eric\Transfer;

        $countries = App\Models\Country::country_tarif();

    @endphp

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"> DISPATCH RECEIVING </h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS Mail Transfer</a>
                        </li>
                        <li class="breadcrumb-item active"> DISPATCH RECEIVING</li>
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

                            <h5 class="card-title mb-0">DISPATCH RECEIVING</h5>

                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                    <i class="ri-delete-bin-2-line"></i>
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
                    <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                        <thead class="table-light text-muted">
                            <tr>
                                <th scope="col" style="width: 80px">
                                    #
                                </th>
                                <th class="sort" data-sort="FROM">
                                    DISPATCH CODE
                                </th>
                                <th class="sort" data-sort="FROM">
                                    FROM
                                </th>

                                <th class="sort" data-sort="BRANCH">TO BRANCH</th>
                                <th class="sort" data-sort="PHONE">MAIL NUMBER</th>
                                <th class="sort" data-sort="PHONE">MAIL TYPE</th>
                                <th class="sort" data-sort="DATE">DATE</th>
                                <th class="sort" data-sort="action">Action</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach ($results as $key => $result)
                                <tr>
                                    <th scope="row">
                                        {{ $key + 1 }}
                                    </th>
                                    {{-- <td class="MAIL CODE"> <a target="_blank" href="print/mailtransfer.php"> <button
                                                class="btn btn-dark waves-effect waves-light">DSP
                                                {{ $result->id }}</button>
                                    </td> --}}
                                    <td class="MAIL CODE"><button class="btn btn-dark btn-sm waves-effect waves-light">DSP
                                            {{ $result->id }}</button>
                                    </td>
                                    <td class="MAIL CODE">{{ $result->emplo->name }} </td>



                                    <td class="NAME">{{ $result->branches->name }}</td>

                                    <td class="PHONE">{{ $result->mnumber }}
                                        /{{ $receivedmail = Transferdatails::where('trid', $result->id)->count() }}</td>

                                    <td class="PHONE">
                                        @if ($result->mailtype == 'ems')
                                        EMS
                                        @elseif ($result->mailtype == 'p')
                                            Parcel
                                        @elseif ($result->mailtype == 'r')
                                            Registered
                                        @else
                                            Ordinary
                                        @endif
                                    </td>

                                    <td class="date"> {{ $result->created_at->format('d M, Y') }}</td>

                                    <td>
                                        @php

                                            $tumaze = $receivedmail + 1;
                                            if ($tumaze == $result->mnumber) {
                                                $closes = 1;
                                            } else {
                                                $closes = 0;
                                            }

                                        @endphp

                                        @if ($receivedmail == $result->mnumber)
                                            <a href="#standard-modal{{ $result->id }}" data-bs-toggle="modal"
                                                type="button" class="btn btn-primary btn-sm"><span>D.RECEIVING</span></a>

                                            <!-- Modal -->
                                            <div id="standard-modal{{ $result->id }}" class="modal fade" tabindex="-1"
                                                role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">

                                                        <form method="post"
                                                            action="{{ route('admin.dreceive.update', $result->id) }}">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="modal-header">
                                                                <h4 class="modal-title" id="standard-modalLabel">DISPATCH
                                                                    RECEIVING (DSP{{ $result->id }}) </h4>

                                                                <button type="button" class="btn-close"
                                                                    data-bs-dismiss="modal" aria-hidden="true"></button>
                                                            </div>
                                                            <div class="modal-body">




                                                                <table class="table table-centered mb-0">
                                                                    <tr>
                                                                        <th>#</th>
                                                                        <th>MAIL CODE</th>
                                                                        <th>NAMES</th>
                                                                        <th>PHONE</th>

                                                                    </tr>
                                                                    @php

                                                                        $data = DB::table('inboxings')
                                                                            ->join(
                                                                                'transferdatails',
                                                                                'inboxings.id',
                                                                                '=',
                                                                                'transferdatails.inid',
                                                                            )
                                                                            ->where('transferdatails.trid', $result->id)
                                                                            ->select(
                                                                                'inboxings.id AS inbox_id',
                                                                                'inboxings.innumber',
                                                                                'inboxings.inname',
                                                                                'inboxings.phone',
                                                                            )
                                                                            ->get();
                                                                    @endphp

                                                                    @foreach ($data as $key => $item)
                                                                        <tr>

                                                                            <th scope="row">
                                                                                {{ $key + 1 }}
                                                                            </th>
                                                                            <input type="hidden"
                                                                                value="{{ $item->inbox_id }}"
                                                                                name="inid[]">
                                                                            <td>{{ $item->innumber }} </td>
                                                                            <td>{{ $item->inname }} </td>
                                                                            <td>{{ $item->phone }}</td>
                                                                    @endforeach
                                </tr>




                                <tr>

                                    <td colspan="3"><b>TOTAL NUMBER OF MAIL {{ $result->mnumber }} </b> </td>
                                    <td> <b> </b>
                                        <br>


                                    </td>



                                </tr>


                    </table>


                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">D Receiving</button>

                    <input name='number' value="" type='hidden'>
                </div>

                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
    <!--end modal -->
@else
    @if ($result->mailtype == 'p')
        <a href="#standard-modals{{ $result->id }}" data-bs-toggle="modal" type="button"
            class="btn btn-secondary btn-sm"><span> PARCEL.REG</span></a>
        <div class="modal fade" id="standard-modals{{ $result->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light p-3">
                        <h5 class="modal-title" id="exampleModalLabel">Percel Registration</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                    </div>
                    <form class="tablelist-form" method="post"
                        action="{{ route('admin.dreceive.Dispachdp', $result->id) }}" onsubmit="disableSubmitButton()">
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
                            <input type="hidden" name="branch" value="{{ $result->branches->name }}" />
                            <input type="hidden" name="location" value="{{ auth()->user()->branch }}" />
                            <input type="hidden" name="trid" value="{{ $result->id }}" />
                            <input type="hidden" name="closes" value="{{ $closes }}" />
                            <div class="mb-3">
                                <label for="customername-field" class="form-label">
                                </label>
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
                                        <label for="phone-field" class="form-label">Phone</label>
                                        <input type="text" id="phone-field" name="phone"
                                            class="form-control phoneNumber" minlength="10" maxlength="10"
                                            placeholder="Enter phone no." required value="{{ old('phone') }}"
                                            autocomplete="off" />
                                        <div class="invalid-feedback">
                                            Please enter a phone.
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-3">
                                        <label for="status-field" class="form-label">Weight</label>
                                        <input type="text" id="phone-field" name="weight" class="form-control"
                                            placeholder="Enter Weight." required value="{{ old('phone') }}"
                                            autocomplete="off" />
                                        <div class="invalid-feedback">
                                            Please enter a Weight
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label for="phone-field" class="form-label">Sherf</label>
                                        <input type="text" id="phone-field" name="akabati" class="form-control"
                                            placeholder="Enter Sherf." required value="{{ old('akabati') }}"
                                            autocomplete="off" />
                                        <div class="invalid-feedback">
                                            Please enter a phone.
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-6 mb-3">
                                        <label for="status-field" class="form-label">P.O Box</label>
                                        <input type="text" id="phone-field" name="pob"
                                            class="form-control phoneNumber" placeholder="Enter P.O Box." required
                                            value="{{ old('pob') }}" autocomplete="off" />
                                        <div class="invalid-feedback">
                                            Please enter a Weight
                                        </div>
                                    </div>
                                    <div class="col-lg-6">
                                        <label for="branch" class="form-label">Branch Name</label>
                                        <select class="form-control" required name="pob_bid" id="branch">
                                            <option value="" disabled selected>Select branch</option>
                                            @foreach ($branches as $branch)
                                                <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                            @endforeach

                                        </select>
                                    </div>

                                </div>

                                <div class="mb-3">
                                    <label for="country" class="form-label">Orgin Country
                                    </label>
                                    <select class="form-select" name="orgcountry" type="text"
                                        id="country" required>
                                        <option value="" disabled selected>Orgin Country</option>
                                        @foreach ($countries as $country)
                                            <option
                                                {{ old('orgcountry') == $country['c_id'] ? 'selected' : '' }}
                                                value="{{ $country['c_id'] }}">
                                                {{ $country['countryname'] }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="status-field" class="form-label">Comment</label>
                                    <select class="form-control" data-choices data-choices-search-false name="comment"
                                        id="status-field" required>
                                        <option @if (old('comment') == 'Item recieved torn and Repaired at the CNTP')  @endif
                                            value="Item recieved torn and Repaired at the CNTP">Item recieved torn and
                                            Repaired at the CNTP</option>
                                        <option @if (old('comment') == 'Item recieved') selected @endif value="Item recieved">
                                            Item recieved</option>

                                    </select>
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
        @elseif($result->mailtype == 'ems')
            <a href="#standard-modals{{ $result->id }}" data-bs-toggle="modal" type="button"
                class="btn btn-secondary btn-sm"><span> EMS.REG</span></a>
            <div class="modal fade" id="standard-modals{{ $result->id }}" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light p-3">
                            <h5 class="modal-title" id="exampleModalLabel">EMS Registration</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                id="close-modal"></button>
                        </div>
                        <form class="tablelist-form" method="post"
                            action="{{ route('admin.dreceive.Dispachdems', $result->id) }}">
                            @csrf
                            @method('PUT')
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
                                <input type="hidden" name="branch" value="{{ $result->branches->name }}" />
                                <input type="hidden" name="location" value="{{ auth()->user()->branch }}" />
                                <input type="hidden" name="trid" value="{{ $result->id }}" />
                                <input type="hidden" name="closes" value="{{ $closes }}" />
                                <div class="mb-3">
                                    <label for="customername-field" class="form-label">
                                    </label>
                                    <div class="mb-3">
                                        <label for="customername-field" class="form-label">Tracking
                                            Number</label>
                                        <input type="text" id="customername-field" name="intracking"
                                            class="form-control" placeholder="Enter Tracking Number"
                                            value="{{ old('intracking') }}" required autocomplete="off" />
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
                                            <label for="phone-field" class="form-label">Phone</label>
                                            <input type="text" id="phone-field" name="phone"
                                                class="form-control phoneNumber" minlength="10" maxlength="10"
                                                placeholder="Enter phone no." required value="{{ old('phone') }}"
                                                autocomplete="off" />
                                            <div class="invalid-feedback">
                                                Please enter a phone.
                                            </div>
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="status-field" class="form-label">Weight</label>
                                            <input type="text" id="phone-field" name="weight" class="form-control"
                                                placeholder="Enter Weight." required value="{{ old('phone') }}"
                                                autocomplete="off" />
                                            <div class="invalid-feedback">
                                                Please enter a Weight
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="phone-field" class="form-label">Sherf</label>
                                            <input type="text" id="phone-field" name="akabati" class="form-control"
                                                placeholder="Enter Sherf." required value="{{ old('akabati') }}"
                                                autocomplete="off" />
                                            <div class="invalid-feedback">
                                                Please enter a phone.
                                            </div>
                                        </div>


                                        <div class="row">
                                            <div class="col-md-6 mb-3">
                                                <label for="status-field" class="form-label">P.O Box</label>
                                                <input type="text" id="phone-field" name="pob"
                                                    class="form-control phoneNumber" placeholder="Enter P.O Box." required
                                                    value="{{ old('pob') }}" autocomplete="off" />
                                                <div class="invalid-feedback">
                                                    Please enter a Weight
                                                </div>
                                            </div>
                                            <div class="col-lg-6">
                                                <label for="branch" class="form-label">Branch Name</label>
                                                <select class="form-control" required name="pob_bid" id="branch">
                                                    <option value="" disabled selected>Select branch</option>
                                                    @foreach ($branches as $branch)
                                                        <option value="{{ $branch->id }}">{{ $branch->name }}</option>
                                                    @endforeach

                                                </select>
                                            </div>
                                        </div>



                                        <div class="mb-3">
                                            <label for="country" class="form-label">Orgin Country
                                            </label>
                                            <select class="form-select" name="orgcountry" type="text" id="country"
                                                required>
                                                <option value="" disabled selected>Orgin Country</option>
                                                @foreach ($countries as $country)
                                                    <option {{ old('orgcountry') == $country['c_id'] ? 'selected' : '' }}
                                                        value="{{ $country['c_id'] }}">{{ $country['countryname'] }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="status-field" class="form-label">Comment</label>
                                            <select class="form-control" data-choices data-choices-search-false
                                                name="comment" id="status-field" required>
                                                <option @if (old('comment') == 'Item recieved') selected @endif
                                                    value="Item recieved">Item recieved</option>

                                                <option @if (old('comment') == 'Item recieved torn and Repaired at the CNTP')  @endif
                                                    value="Item recieved torn and Repaired at the CNTP">Item recieved torn
                                                    and Repaired at the CNTP</option>

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
            @elseif($result->mailtype == 'o')
                <a href="#standard-modals{{ $result->id }}" data-bs-toggle="modal" type="button"
                    class="btn btn-secondary btn-sm"><span> Ordinary.REG</span></a>
                <div class="modal fade" id="standard-modals{{ $result->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">Ordinary Mail Registration</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            <form class="tablelist-form" method="post"
                                action="{{ route('admin.dreceive.Dispachdo', $result->id) }}">
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
                                    <input type="hidden" name="branch" value="{{ $result->branches->name }}" />
                                    <input type="hidden" name="location" value="{{ auth()->user()->branch }}" />
                                    <input type="hidden" name="trid" value="{{ $result->id }}" />
                                    <input type="hidden" name="closes" value="{{ $closes }}" />
                                    <div class="mb-3">
                                        <label for="customername-field" class="form-label">
                                        </label>
                                        <div class="mb-3">
                                            <label for="customername-field" class="form-label">Tracking
                                                Number</label>
                                            <input type="text" id="customername-field" name="intracking"
                                                class="form-control" placeholder="Enter Tracking Number"
                                                value="{{ old('intracking') }}" required autocomplete="off" />
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
                                                <label for="phone-field" class="form-label">Phone</label>
                                                <input type="text" id="phone-field" name="phone"
                                                    class="form-control phoneNumber" minlength="10" maxlength="10"
                                                    placeholder="Enter phone no." required value="{{ old('phone') }}"
                                                    autocomplete="off" />
                                                <div class="invalid-feedback">
                                                    Please enter a phone.
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-3">
                                                <label for="status-field" class="form-label">Weight</label>
                                                <input type="text" id="phone-field" name="weight"
                                                    class="form-control" placeholder="Enter Weight." required
                                                    value="{{ old('phone') }}" autocomplete="off" />
                                                <div class="invalid-feedback">
                                                    Please enter a Weight
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="phone-field" class="form-label">Sherf</label>
                                                <input type="text" id="phone-field" name="akabati"
                                                    class="form-control" placeholder="Enter Sherf." required
                                                    value="{{ old('akabati') }}" autocomplete="off" />
                                                <div class="invalid-feedback">
                                                    Please enter a phone.
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="status-field" class="form-label">P.O Box</label>
                                                    <input type="text" id="phone-field" name="pob"
                                                        class="form-control phoneNumber" placeholder="Enter P.O Box."
                                                        required value="{{ old('pob') }}" autocomplete="off" />
                                                    <div class="invalid-feedback">
                                                        Please enter a Weight
                                                    </div>
                                                </div>
                                                <div class="col-lg-6">
                                                    <label for="branch" class="form-label">Branch Name</label>
                                                    <select class="form-control" required name="pob_bid" id="branch">
                                                        <option value="" disabled selected>Select branch</option>
                                                        @foreach ($branches as $branch)
                                                            <option value="{{ $branch->id }}">{{ $branch->name }}
                                                            </option>
                                                        @endforeach

                                                    </select>
                                                </div>
                                            </div>






                                            <div class="mb-3">
                                                <label for="customername-field" class="form-label">Orgin Country
                                                </label>
                                                <input type="text" id="customername-field" name="orgcountry"
                                                    class="form-control" placeholder="Enter Orgin Country"
                                                    value="{{ old('orgcountry') }}" required autocomplete="off" />
                                                <div class="invalid-feedback">
                                                    Please enter Orgin Country .
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="status-field" class="form-label">Comment</label>
                                                <select class="form-control" data-choices data-choices-search-false
                                                    name="comment" id="status-field" required>
                                                    <option @if (old('comment') == 'Item recieved') selected @endif
                                                        value="Item recieved">Item recieved</option>

                                                    <option @if (old('comment') == 'Item recieved torn and Repaired at the CNTP')  @endif
                                                        value="Item recieved torn and Repaired at the CNTP">Item recieved
                                                        torn and Repaired at the CNTP</option>

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
                @elseif($result->mailtype == 'r')
                    <a href="#standard-modals{{ $result->id }}" data-bs-toggle="modal" type="button"
                        class="btn btn-secondary btn-sm"><span> Registered.REG</span></a>
                    <div class="modal fade" id="standard-modals{{ $result->id }}" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header bg-light p-3">
                                    <h5 class="modal-title" id="exampleModalLabel">Registered Mail Registration</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                        id="close-modal"></button>
                                </div>
                                <form class="tablelist-form" method="post"
                                    action="{{ route('admin.dreceive.Dispachdr', $result->id) }}">
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
                                        <input type="hidden" name="branch" value="{{ $result->branches->name }}" />
                                        <input type="hidden" name="location" value="{{ auth()->user()->branch }}" />
                                        <input type="hidden" name="trid" value="{{ $result->id }}" />
                                        <input type="hidden" name="closes" value="{{ $closes }}" />
                                        <div class="mb-3">
                                            <label for="customername-field" class="form-label">
                                            </label>
                                            <div class="mb-3">
                                                <label for="customername-field" class="form-label">Tracking
                                                    Number</label>
                                                <input type="text" id="customername-field" name="intracking"
                                                    class="form-control" placeholder="Enter Tracking Number"
                                                    value="{{ old('intracking') }}" required autocomplete="off" />
                                                <div class="invalid-feedback">
                                                    Please enter a Tracting Number .
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="name-field" class="form-label">Names</label>
                                                <input type="text" id="email-field" class="form-control"
                                                    name="inname" placeholder="Enter Names" required
                                                    value="{{ old('inname') }}" autocomplete="off" />
                                                <div class="invalid-feedback">
                                                    Please enter Names.
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6 mb-3">
                                                    <label for="phone-field" class="form-label">Phone</label>
                                                    <input type="text" id="phone-field" name="phone"
                                                        class="form-control phoneNumber" minlength="10" maxlength="10"
                                                        placeholder="Enter phone no." required
                                                        value="{{ old('phone') }}" autocomplete="off" />
                                                    <div class="invalid-feedback">
                                                        Please enter a phone.
                                                    </div>
                                                </div>
                                                <div class="col-md-6 mb-3">
                                                    <label for="status-field" class="form-label">Weight</label>
                                                    <input type="text" id="phone-field" name="weight"
                                                        class="form-control" placeholder="Enter Weight." required
                                                        value="{{ old('phone') }}" autocomplete="off" />
                                                    <div class="invalid-feedback">
                                                        Please enter a Weight
                                                    </div>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="phone-field" class="form-label">Sherf</label>
                                                    <input type="text" id="phone-field" name="akabati"
                                                        class="form-control" placeholder="Enter Sherf." required
                                                        value="{{ old('akabati') }}" autocomplete="off" />
                                                    <div class="invalid-feedback">
                                                        Please enter a phone.
                                                    </div>
                                                </div>


                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="status-field" class="form-label">P.O Box</label>
                                                        <input type="text" id="phone-field" name="pob"
                                                            class="form-control phoneNumber" placeholder="Enter P.O Box."
                                                            required value="{{ old('pob') }}" autocomplete="off" />
                                                        <div class="invalid-feedback">
                                                            Please enter a Weight
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-6">
                                                        <label for="branch" class="form-label">Branch Name</label>
                                                        <select class="form-control" required name="pob_bid"
                                                            id="branch">
                                                            <option value="" disabled selected>Select branch</option>
                                                            @foreach ($branches as $branch)
                                                                <option value="{{ $branch->id }}">{{ $branch->name }}
                                                                </option>
                                                            @endforeach

                                                        </select>
                                                    </div>
                                                </div>


                                                <div class="mb-3">
                                                    <label for="country" class="form-label">Orgin Country
                                                    </label>
                                                    <select class="form-select" name="orgcountry" type="text"
                                                        id="country" required>
                                                        <option value="" disabled selected>Orgin Country</option>
                                                        @foreach ($countries as $country)
                                                            <option
                                                                {{ old('orgcountry') == $country['c_id'] ? 'selected' : '' }}
                                                                value="{{ $country['c_id'] }}">
                                                                {{ $country['countryname'] }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label for="status-field" class="form-label">Comment</label>
                                                    <select class="form-control" data-choices data-choices-search-false
                                                        name="comment" id="status-field" required>
                                                        <option @if (old('comment') == 'Item recieved') selected @endif
                                                            value="Item recieved">Item recieved</option>
                                                        <option @if (old('comment') == 'Item recieved torn and Repaired at the CNTP')  @endif
                                                            value="Item recieved torn and Repaired at the CNTP">Item
                                                            recieved torn and Repaired at the CNTP</option>


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
                    @elseif($result->mailtype == 'POD')
                        <a href="#standard-modals{{ $result->id }}" data-bs-toggle="modal" type="button"
                            class="btn btn-secondary btn-sm"><span> Postal Card.REG</span></a>
                        <div class="modal fade" id="standard-modals{{ $result->id }}" tabindex="-1"
                            aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-header bg-light p-3">
                                        <h5 class="modal-title" id="exampleModalLabel">Postal Card Mail Registration</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close" id="close-modal"></button>
                                    </div>
                                    <form class="tablelist-form" method="post"
                                        action="{{ route('admin.dreceive.Dispachdpostal', $result->id) }}">
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
                                            <input type="hidden" name="branch"
                                                value="{{ $result->branches->name }}" />
                                            <input type="hidden" name="location"
                                                value="{{ auth()->user()->branch }}" />
                                            <input type="hidden" name="trid" value="{{ $result->id }}" />
                                            <input type="hidden" name="closes" value="{{ $closes }}" />
                                            <div class="mb-3">
                                                <label for="customername-field" class="form-label">
                                                </label>
                                                <div class="mb-3">
                                                    <label for="customername-field" class="form-label">Tracking
                                                        Number</label>
                                                    <input type="text" id="customername-field" name="intracking"
                                                        class="form-control" placeholder="Enter Tracking Number"
                                                        value="{{ old('intracking') }}" required autocomplete="off" />
                                                    <div class="invalid-feedback">
                                                        Please enter a Tracting Number .
                                                    </div>
                                                </div>

                                                <div class="mb-3">
                                                    <label for="name-field" class="form-label">Names</label>
                                                    <input type="text" id="email-field" class="form-control"
                                                        name="inname" placeholder="Enter Names" required
                                                        value="{{ old('inname') }}" autocomplete="off" />
                                                    <div class="invalid-feedback">
                                                        Please enter Names.
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-6 mb-3">
                                                        <label for="phone-field" class="form-label">Phone</label>
                                                        <input type="text" id="phone-field" name="phone"
                                                            class="form-control phoneNumber" minlength="10"
                                                            maxlength="10" placeholder="Enter phone no." required
                                                            value="{{ old('phone') }}" autocomplete="off" />
                                                        <div class="invalid-feedback">
                                                            Please enter a phone.
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6 mb-3">
                                                        <label for="status-field" class="form-label">Weight</label>
                                                        <input type="text" id="phone-field" name="weight"
                                                            class="form-control" placeholder="Enter Weight." required
                                                            value="{{ old('phone') }}" autocomplete="off" />
                                                        <div class="invalid-feedback">
                                                            Please enter a Weight
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="phone-field" class="form-label">Sherf</label>
                                                        <input type="text" id="phone-field" name="akabati"
                                                            class="form-control" placeholder="Enter Sherf." required
                                                            value="{{ old('akabati') }}" autocomplete="off" />
                                                        <div class="invalid-feedback">
                                                            Please enter a phone.
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="status-field" class="form-label">P.O Box</label>
                                                            <input type="text" id="phone-field" name="pob"
                                                                class="form-control phoneNumber"
                                                                placeholder="Enter P.O Box." required
                                                                value="{{ old('pob') }}" autocomplete="off" />
                                                            <div class="invalid-feedback">
                                                                Please enter a Weight
                                                            </div>
                                                        </div>
                                                        <div class="col-lg-6">
                                                            <label for="branch" class="form-label">Branch Name</label>
                                                            <select class="form-control" required name="pob_bid"
                                                                id="branch">
                                                                <option value="" disabled selected>Select branch
                                                                </option>
                                                                @foreach ($branches as $branch)
                                                                    <option value="{{ $branch->id }}">
                                                                        {{ $branch->name }}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="country" class="form-label">Orgin Country
                                                        </label>
                                                        <select class="form-select" name="orgcountry" type="text"
                                                            id="country" required>
                                                            <option value="" disabled selected>Orgin Country</option>
                                                            @foreach ($countries as $country)
                                                                <option
                                                                    {{ old('orgcountry') == $country['c_id'] ? 'selected' : '' }}
                                                                    value="{{ $country['c_id'] }}">
                                                                    {{ $country['countryname'] }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="status-field" class="form-label">Comment</label>
                                                        <select class="form-control" data-choices data-choices-search-false
                                                            name="comment" id="status-field" required>
                                                            <option @if (old('comment') == 'Item recieved') selected @endif
                                                                value="Item recieved">Item recieved</option>
                                                            <option @if (old('comment') == 'Item recieved torn and Repaired at the CNTP')  @endif
                                                                value="Item recieved torn and Repaired at the CNTP">Item
                                                                recieved torn and Repaired at the CNTP</option>


                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">
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
                        @elseif($result->mailtype == 'GAD')
                            <a href="#standard-modals{{ $result->id }}" data-bs-toggle="modal" type="button"
                                class="btn btn-secondary btn-sm"><span> Google AD.REG</span></a>
                            <div class="modal fade" id="standard-modals{{ $result->id }}" tabindex="-1"
                                aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light p-3">
                                            <h5 class="modal-title" id="exampleModalLabel">Google Adjacent Mail
                                                Registration</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close" id="close-modal"></button>
                                        </div>
                                        <form class="tablelist-form" method="post"
                                            action="{{ route('admin.dreceive.Dispachdgooglead', $result->id) }}">
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
                                                <input type="hidden" name="branch"
                                                    value="{{ $result->branches->name }}" />
                                                <input type="hidden" name="location"
                                                    value="{{ auth()->user()->branch }}" />
                                                <input type="hidden" name="trid" value="{{ $result->id }}" />
                                                <input type="hidden" name="closes" value="{{ $closes }}" />
                                                <div class="mb-3">
                                                    <label for="customername-field" class="form-label">
                                                    </label>
                                                    <div class="mb-3">
                                                        <label for="customername-field" class="form-label">Tracking
                                                            Number</label>
                                                        <input type="text" id="customername-field" name="intracking"
                                                            class="form-control" placeholder="Enter Tracking Number"
                                                            value="{{ old('intracking') }}" required
                                                            autocomplete="off" />
                                                        <div class="invalid-feedback">
                                                            Please enter a Tracting Number .
                                                        </div>
                                                    </div>

                                                    <div class="mb-3">
                                                        <label for="name-field" class="form-label">Names</label>
                                                        <input type="text" id="email-field" class="form-control"
                                                            name="inname" placeholder="Enter Names" required
                                                            value="{{ old('inname') }}" autocomplete="off" />
                                                        <div class="invalid-feedback">
                                                            Please enter Names.
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 mb-3">
                                                            <label for="phone-field" class="form-label">Phone</label>
                                                            <input type="text" id="phone-field" name="phone"
                                                                class="form-control phoneNumber" minlength="10"
                                                                maxlength="10" placeholder="Enter phone no." required
                                                                value="{{ old('phone') }}" autocomplete="off" />
                                                            <div class="invalid-feedback">
                                                                Please enter a phone.
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 mb-3">
                                                            <label for="status-field" class="form-label">Weight</label>
                                                            <input type="text" id="phone-field" name="weight"
                                                                class="form-control" placeholder="Enter Weight." required
                                                                value="{{ old('phone') }}" autocomplete="off" />
                                                            <div class="invalid-feedback">
                                                                Please enter a Weight
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="phone-field" class="form-label">Sherf</label>
                                                            <input type="text" id="phone-field" name="akabati"
                                                                class="form-control" placeholder="Enter Sherf." required
                                                                value="{{ old('akabati') }}" autocomplete="off" />
                                                            <div class="invalid-feedback">
                                                                Please enter a phone.
                                                            </div>
                                                        </div>


                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="status-field" class="form-label">P.O
                                                                    Box</label>
                                                                <input type="text" id="phone-field" name="pob"
                                                                    class="form-control phoneNumber"
                                                                    placeholder="Enter P.O Box." required
                                                                    value="{{ old('pob') }}" autocomplete="off" />
                                                                <div class="invalid-feedback">
                                                                    Please enter a Weight
                                                                </div>
                                                            </div>
                                                            <div class="col-lg-6">
                                                                <label for="branch" class="form-label">Branch
                                                                    Name</label>
                                                                <select class="form-control" required name="pob_bid"
                                                                    id="branch">
                                                                    <option value="" disabled selected>Select branch
                                                                    </option>
                                                                    @foreach ($branches as $branch)
                                                                        <option value="{{ $branch->id }}">
                                                                            {{ $branch->name }}</option>
                                                                    @endforeach

                                                                </select>
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="country" class="form-label">Orgin Country
                                                            </label>
                                                            <select class="form-select" name="orgcountry" type="text"
                                                                id="country" required>
                                                                <option value="" disabled selected>Orgin Country
                                                                </option>
                                                                @foreach ($countries as $country)
                                                                    <option
                                                                        {{ old('orgcountry') == $country['c_id'] ? 'selected' : '' }}
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
                                                                <option @if (old('comment') == 'Item recieved torn and Repaired at the CNTP')  @endif
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
                                                            <button type="submit" class="btn btn-success"
                                                                id="add-btn">
                                                                Save
                                                            </button>
                                                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                        </div>
                                                    </div>
                                        </form>
                                    </div>
                                </div>
                            @elseif($result->mailtype == 'JUR')
                                <a href="#standard-modals{{ $result->id }}" data-bs-toggle="modal" type="button"
                                    class="btn btn-secondary btn-sm"><span> Jurnal.REG</span></a>
                                <div class="modal fade" id="standard-modals{{ $result->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light p-3">
                                                <h5 class="modal-title" id="exampleModalLabel">Jurnal Mail Registration
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="close-modal"></button>
                                            </div>
                                            <form class="tablelist-form" method="post"
                                                action="{{ route('admin.dreceive.Dispachdjurnal', $result->id) }}">
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
                                                    <input type="hidden" name="branch"
                                                        value="{{ $result->branches->name }}" />
                                                    <input type="hidden" name="location"
                                                        value="{{ auth()->user()->branch }}" />
                                                    <input type="hidden" name="trid" value="{{ $result->id }}" />
                                                    <input type="hidden" name="closes"
                                                        value="{{ $closes }}" />
                                                    <div class="mb-3">
                                                        <label for="customername-field" class="form-label">
                                                        </label>
                                                        <div class="mb-3">
                                                            <label for="customername-field" class="form-label">Tracking
                                                                Number</label>
                                                            <input type="text" id="customername-field"
                                                                name="intracking" class="form-control"
                                                                placeholder="Enter Tracking Number"
                                                                value="{{ old('intracking') }}" required
                                                                autocomplete="off" />
                                                            <div class="invalid-feedback">
                                                                Please enter a Tracting Number .
                                                            </div>
                                                        </div>

                                                        <div class="mb-3">
                                                            <label for="name-field" class="form-label">Names</label>
                                                            <input type="text" id="email-field"
                                                                class="form-control" name="inname"
                                                                placeholder="Enter Names" required
                                                                value="{{ old('inname') }}" autocomplete="off" />
                                                            <div class="invalid-feedback">
                                                                Please enter Names.
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 mb-3">
                                                                <label for="phone-field"
                                                                    class="form-label">Phone</label>
                                                                <input type="text" id="phone-field" name="phone"
                                                                    class="form-control phoneNumber" minlength="10"
                                                                    maxlength="10" placeholder="Enter phone no."
                                                                    required value="{{ old('phone') }}"
                                                                    autocomplete="off" />
                                                                <div class="invalid-feedback">
                                                                    Please enter a phone.
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 mb-3">
                                                                <label for="status-field"
                                                                    class="form-label">Weight</label>
                                                                <input type="text" id="phone-field" name="weight"
                                                                    class="form-control" placeholder="Enter Weight."
                                                                    required value="{{ old('phone') }}"
                                                                    autocomplete="off" />
                                                                <div class="invalid-feedback">
                                                                    Please enter a Weight
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="phone-field"
                                                                    class="form-label">Sherf</label>
                                                                <input type="text" id="phone-field" name="akabati"
                                                                    class="form-control" placeholder="Enter Sherf."
                                                                    required value="{{ old('akabati') }}"
                                                                    autocomplete="off" />
                                                                <div class="invalid-feedback">
                                                                    Please enter a phone.
                                                                </div>
                                                            </div>


                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="status-field" class="form-label">P.O
                                                                        Box</label>
                                                                    <input type="text" id="phone-field"
                                                                        name="pob" class="form-control phoneNumber"
                                                                        placeholder="Enter P.O Box." required
                                                                        value="{{ old('pob') }}"
                                                                        autocomplete="off" />
                                                                    <div class="invalid-feedback">
                                                                        Please enter a Weight
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label for="branch" class="form-label">Branch
                                                                        Name</label>
                                                                    <select class="form-control" required name="pob_bid"
                                                                        id="branch">
                                                                        <option value="" disabled selected>Select
                                                                            branch</option>
                                                                        @foreach ($branches as $branch)
                                                                            <option value="{{ $branch->id }}">
                                                                                {{ $branch->name }}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </div>
                                                            </div>





                                                            <div class="mb-3">
                                                                <label for="country" class="form-label">Orgin Country
                                                                </label>
                                                                <select class="form-select" name="orgcountry"
                                                                    type="text" id="country" required>
                                                                    <option value="" disabled selected>Orgin Country
                                                                    </option>
                                                                    @foreach ($countries as $country)
                                                                        <option
                                                                            {{ old('orgcountry') == $country['c_id'] ? 'selected' : '' }}
                                                                            value="{{ $country['c_id'] }}">
                                                                            {{ $country['countryname'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="status-field"
                                                                    class="form-label">Comment</label>
                                                                <select class="form-control" data-choices
                                                                    data-choices-search-false name="comment"
                                                                    id="status-field" required>
                                                                    <option
                                                                        @if (old('comment') == 'Item recieved') selected @endif
                                                                        value="Item recieved">Item recieved</option>
                                                                    <option @if (old('comment') == 'Item recieved torn and Repaired at the CNTP')  @endif
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
                                                                <button type="submit" class="btn btn-success"
                                                                    id="add-btn">
                                                                    Save
                                                                </button>
                                                                <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                            </div>
                                                        </div>
                                            </form>
                                        </div>
                                    </div>
                                @elseif($result->mailtype == 'PRM')
                                    <a href="#standard-modals{{ $result->id }}" data-bs-toggle="modal"
                                        type="button"
                                        class="btn btn-secondary btn-sm"><span>PrintedMaterial.REG</span></a>
                                    <div class="modal fade" id="standard-modals{{ $result->id }}" tabindex="-1"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header bg-light p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">Printed Material Mail
                                                        Registration</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" method="post"
                                                    action="{{ route('admin.dreceive.Dispachdprinted', $result->id) }}">
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
                                                        <input type="hidden" name="branch"
                                                            value="{{ $result->branches->name }}" />
                                                        <input type="hidden" name="location"
                                                            value="{{ auth()->user()->branch }}" />
                                                        <input type="hidden" name="trid"
                                                            value="{{ $result->id }}" />
                                                        <input type="hidden" name="closes"
                                                            value="{{ $closes }}" />
                                                        <div class="mb-3">
                                                            <label for="customername-field" class="form-label">
                                                            </label>
                                                            <div class="mb-3">
                                                                <label for="customername-field"
                                                                    class="form-label">Tracking
                                                                    Number</label>
                                                                <input type="text" id="customername-field"
                                                                    name="intracking" class="form-control"
                                                                    placeholder="Enter Tracking Number"
                                                                    value="{{ old('intracking') }}" required
                                                                    autocomplete="off" />
                                                                <div class="invalid-feedback">
                                                                    Please enter a Tracting Number .
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="name-field" class="form-label">Names</label>
                                                                <input type="text" id="email-field"
                                                                    class="form-control" name="inname"
                                                                    placeholder="Enter Names" required
                                                                    value="{{ old('inname') }}" autocomplete="off" />
                                                                <div class="invalid-feedback">
                                                                    Please enter Names.
                                                                </div>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="phone-field"
                                                                        class="form-label">Phone</label>
                                                                    <input type="text" id="phone-field"
                                                                        name="phone" class="form-control phoneNumber"
                                                                        minlength="10" maxlength="10"
                                                                        placeholder="Enter phone no." required
                                                                        value="{{ old('phone') }}"
                                                                        autocomplete="off" />
                                                                    <div class="invalid-feedback">
                                                                        Please enter a phone.
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="status-field"
                                                                        class="form-label">Weight</label>
                                                                    <input type="text" id="phone-field"
                                                                        name="weight" class="form-control"
                                                                        placeholder="Enter Weight." required
                                                                        value="{{ old('phone') }}"
                                                                        autocomplete="off" />
                                                                    <div class="invalid-feedback">
                                                                        Please enter a Weight
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="phone-field"
                                                                        class="form-label">Sherf</label>
                                                                    <input type="text" id="phone-field"
                                                                        name="akabati" class="form-control"
                                                                        placeholder="Enter Sherf." required
                                                                        value="{{ old('akabati') }}"
                                                                        autocomplete="off" />
                                                                    <div class="invalid-feedback">
                                                                        Please enter a phone.
                                                                    </div>
                                                                </div>


                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="status-field" class="form-label">P.O
                                                                            Box</label>
                                                                        <input type="text" id="phone-field"
                                                                            name="pob"
                                                                            class="form-control phoneNumber"
                                                                            placeholder="Enter P.O Box." required
                                                                            value="{{ old('pob') }}"
                                                                            autocomplete="off" />
                                                                        <div class="invalid-feedback">
                                                                            Please enter a Weight
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label for="branch" class="form-label">Branch
                                                                            Name</label>
                                                                        <select class="form-control" required
                                                                            name="pob_bid" id="branch">
                                                                            <option value="" disabled selected>
                                                                                Select branch</option>
                                                                            @foreach ($branches as $branch)
                                                                                <option value="{{ $branch->id }}">
                                                                                    {{ $branch->name }}</option>
                                                                            @endforeach

                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="country" class="form-label">Orgin
                                                                        Country
                                                                    </label>
                                                                    <select class="form-select" name="orgcountry"
                                                                        type="text" id="country" required>
                                                                        <option value="" disabled selected>Orgin
                                                                            Country</option>
                                                                        @foreach ($countries as $country)
                                                                            <option
                                                                                {{ old('orgcountry') == $country['c_id'] ? 'selected' : '' }}
                                                                                value="{{ $country['c_id'] }}">
                                                                                {{ $country['countryname'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status-field"
                                                                        class="form-label">Comment</label>
                                                                    <select class="form-control" data-choices
                                                                        data-choices-search-false name="comment"
                                                                        id="status-field" required>
                                                                        <option
                                                                            @if (old('comment') == 'Item recieved') selected @endif
                                                                            value="Item recieved">Item recieved</option>
                                                                        <option @if (old('comment') == 'Item recieved torn and Repaired at the CNTP')  @endif
                                                                            value="Item recieved torn and Repaired at the CNTP">
                                                                            Item recieved torn and Repaired at the CNTP
                                                                        </option>


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
                                                                        Save
                                                                    </button>
                                                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                                </div>
                                                            </div>
                                                </form>
                                            </div>
                                        </div>
                                    @elseif($result->mailtype == 'ol')
                                        <a href="#standard-modals{{ $result->id }}" data-bs-toggle="modal"
                                            type="button" class="btn btn-secondary btn-sm"><span>Ordinary
                                                Letter.REG</span></a>
                                        <div class="modal fade" id="standard-modals{{ $result->id }}"
                                            tabindex="-1" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered">
                                                <div class="modal-content">
                                                    <div class="modal-header bg-light p-3">
                                                        <h5 class="modal-title" id="exampleModalLabel">Ordinary Letter
                                                            Registration</h5>
                                                        <button type="button" class="btn-close"
                                                            data-bs-dismiss="modal" aria-label="Close"
                                                            id="close-modal"></button>
                                                    </div>
                                                    <form class="tablelist-form" method="post"
                                                        action="{{ route('admin.dreceive.storeletterod', $result->id) }}">
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
                                                            <input type="hidden" name="branch"
                                                                value="{{ $result->branches->name }}" />
                                                            <input type="hidden" name="location"
                                                                value="{{ auth()->user()->branch }}" />
                                                            <input type="hidden" name="trid"
                                                                value="{{ $result->id }}" />
                                                            <input type="hidden" name="closes"
                                                                value="{{ $closes }}" />
                                                            <div class="mb-3">
                                                                <label for="name-field" class="form-label">Names</label>
                                                                <input type="text" id="email-field"
                                                                    class="form-control" name="inname"
                                                                    placeholder="Enter Names" required
                                                                    value="{{ old('inname') }}" autocomplete="off" />
                                                                <div class="invalid-feedback">
                                                                    Please enter Names.
                                                                </div>
                                                            </div>


                                                            <div class="mb-3">
                                                                <label for="phone-field"
                                                                    class="form-label">Phone</label>
                                                                <input type="text" id="phone-field" name="phone"
                                                                    class="form-control phoneNumber" minlength="10"
                                                                    maxlength="10" placeholder="Enter phone no."
                                                                    value="{{ old('phone') }}" autocomplete="off" />
                                                                <div class="invalid-feedback">
                                                                    Please enter a phone.
                                                                </div>
                                                            </div>
                                                            <div class="mb-3">
                                                                <label for="phone-field"
                                                                    class="form-label">Sherf</label>
                                                                <input type="text" id="phone-field" name="akabati"
                                                                    class="form-control" placeholder="Enter Sherf."
                                                                    required value="{{ old('akabati') }}"
                                                                    autocomplete="off" />
                                                                <div class="invalid-feedback">
                                                                    Please enter a phone.
                                                                </div>
                                                            </div>

                                                            <div class="row">
                                                                <div class="col-md-6 mb-3">
                                                                    <label for="customername-field"
                                                                        class="form-label">P.O Box
                                                                    </label>
                                                                    <input type="text" id="customername-field"
                                                                        name="pob" class="form-control"
                                                                        placeholder="Enter P.O Box"
                                                                        value="{{ old('pob') }}"
                                                                        autocomplete="off" />
                                                                    <div class="invalid-feedback">
                                                                        Please enter POB .
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <label for="branch" class="form-label">Branch
                                                                        Name</label>
                                                                    <select class="form-control" name="pob_bid"
                                                                        id="branch">
                                                                        <option value="" disabled selected>Select
                                                                            branch</option>
                                                                        @foreach ($branches as $branch)
                                                                            <option
                                                                                @if (old('pob_bid') == $branch->id) selected @endif
                                                                                value="{{ $branch->id }}">
                                                                                {{ $branch->name }}</option>
                                                                        @endforeach

                                                                    </select>
                                                                </div>
                                                            </div>

                                                            <div class="mb-3">
                                                                <label for="country" class="form-label">Orgin Country
                                                                </label>
                                                                <select class="form-select" name="orgcountry"
                                                                    type="text" id="country" required>
                                                                    <option value="" disabled selected>Orgin Country
                                                                    </option>
                                                                    @foreach ($countries as $country)
                                                                        <option
                                                                            {{ old('orgcountry') == $country['c_id'] ? 'selected' : '' }}
                                                                            value="{{ $country['c_id'] }}">
                                                                            {{ $country['countryname'] }}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <div class="hstack gap-2 justify-content-end">
                                                                    <button type="button" class="btn btn-light"
                                                                        data-bs-dismiss="modal">
                                                                        Close
                                                                    </button>
                                                                    <button type="submit" class="btn btn-success"
                                                                        id="add-btn">
                                                                        Save
                                                                    </button>
                                                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                                </div>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @elseif($result->mailtype == 'rl')
                                            <a href="#standard-modals{{ $result->id }}" data-bs-toggle="modal"
                                                type="button" class="btn btn-secondary btn-sm"><span>Registered
                                                    Letter.REG</span></a>
                                            <div class="modal fade" id="standard-modals{{ $result->id }}"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header bg-light p-3">
                                                            <h5 class="modal-title" id="exampleModalLabel">Registered
                                                                Letter
                                                                Registration</h5>
                                                            <button type="button" class="btn-close"
                                                                data-bs-dismiss="modal" aria-label="Close"
                                                                id="close-modal"></button>
                                                        </div>
                                                        <form class="tablelist-form" method="post"
                                                            action="{{ route('admin.dreceive.Dispachdletterr', $result->id) }}">
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
                                                                <input type="hidden" name="branch"
                                                                    value="{{ $result->branches->name }}" />
                                                                <input type="hidden" name="location"
                                                                    value="{{ auth()->user()->branch }}" />
                                                                <input type="hidden" name="trid"
                                                                    value="{{ $result->id }}" />
                                                                <input type="hidden" name="closes"
                                                                    value="{{ $closes }}" />
                                                                <div class="mb-3">
                                                                    <label for="name-field"
                                                                        class="form-label">Names</label>
                                                                    <input type="text" id="email-field"
                                                                        class="form-control" name="inname"
                                                                        placeholder="Enter Names" required
                                                                        value="{{ old('inname') }}"
                                                                        autocomplete="off" />
                                                                    <div class="invalid-feedback">
                                                                        Please enter Names.
                                                                    </div>
                                                                </div>


                                                                <div class="mb-3">
                                                                    <label for="phone-field"
                                                                        class="form-label">Phone</label>
                                                                    <input type="text" id="phone-field"
                                                                        name="phone" class="form-control phoneNumber"
                                                                        minlength="10" maxlength="10"
                                                                        placeholder="Enter phone no."
                                                                        value="{{ old('phone') }}"
                                                                        autocomplete="off" />
                                                                    <div class="invalid-feedback">
                                                                        Please enter a phone.
                                                                    </div>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="phone-field"
                                                                        class="form-label">Sherf</label>
                                                                    <input type="text" id="phone-field"
                                                                        name="akabati" class="form-control"
                                                                        placeholder="Enter Sherf." required
                                                                        value="{{ old('akabati') }}"
                                                                        autocomplete="off" />
                                                                    <div class="invalid-feedback">
                                                                        Please enter a phone.
                                                                    </div>
                                                                </div>
                                                                <div class="row">
                                                                    <div class="col-md-6 mb-3">
                                                                        <label for="customername-field"
                                                                            class="form-label">P.O Box
                                                                        </label>
                                                                        <input type="text" id="customername-field"
                                                                            name="pob" class="form-control"
                                                                            placeholder="Enter P.O Box "
                                                                            value="{{ old('pob') }}"
                                                                            autocomplete="off" />
                                                                        <div class="invalid-feedback">
                                                                            Please enter POB .
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-lg-6">
                                                                        <label for="branch" class="form-label">Branch
                                                                            Name</label>
                                                                        <select class="form-control" name="pob_bid"
                                                                            id="branch">
                                                                            <option value="" disabled selected>
                                                                                Select branch</option>
                                                                            @foreach ($branches as $branch)
                                                                                <option
                                                                                    @if (old('pob_bid') == $branch->id) selected @endif
                                                                                    value="{{ $branch->id }}">
                                                                                    {{ $branch->name }}</option>
                                                                            @endforeach

                                                                        </select>
                                                                    </div>
                                                                </div>

                                                                <div class="mb-3">
                                                                    <label for="country" class="form-label">Orgin
                                                                        Country
                                                                    </label>
                                                                    <select class="form-select" name="orgcountry"
                                                                        type="text" id="country" required>
                                                                        <option value="" disabled selected>Orgin
                                                                            Country</option>
                                                                        @foreach ($countries as $country)
                                                                            <option
                                                                                {{ old('orgcountry') == $country['c_id'] ? 'selected' : '' }}
                                                                                value="{{ $country['c_id'] }}">
                                                                                {{ $country['countryname'] }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                                <div class="mb-3">
                                                                    <label for="status-field"
                                                                        class="form-label">Comment</label>
                                                                    <select class="form-control" data-choices
                                                                        data-choices-search-false name="comment"
                                                                        id="status-field" required>
                                                                        <option
                                                                            @if (old('comment') == 'Item recieved') selected @endif
                                                                            value="Item recieved">Item recieved</option>
                                                                        <option
                                                                            @if (old('comment') == 'Item recieved torn and Repaired at the CNTP') selected @endif
                                                                            value="Item recieved torn and Repaired at the CNTP">
                                                                            Item recieved torn and Repaired at the CNTP
                                                                        </option>


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
                                                                        Save
                                                                    </button>
                                                                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                                </div>
                                                            </div>
                                                        </form>
                                                    </div>
                                                </div>
    @endif
    @endif

    <!--end modal -->
    </td>
    </tr>
    @endforeach


    </tbody>
    </table>
    </div>





    </div>
    </div>
    </div>
    <!--end col-->
    </div>
    <!--end row-->
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
