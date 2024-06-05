@extends('layouts.admin.app')
@section('page-name') Branch POBox @endsection
@section('body')
<!-- start page title -->

@php
$rentYearNumber = now()->year - $box->year;
$totalRent = $box->amount * $rentYearNumber;
if (now()->month == 1 && now()->day <= 31): if ($box->year == now()->year):
    $pernaty = 0;
    else :
    $pernaty = now()->year - $box->year - 1;
    endif;
    else :
    $pernaty = now()->year - $box->year;
    endif;
    $total = $totalRent + ($box->amount * 0.25 * $pernaty);
    @endphp

    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Branch POBox</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS P.O B</a>
                        </li>
                        <li class="breadcrumb-item active">Branch POBox</li>
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
                                <h5 class="card-title mb-0">P.O BOX INFORMATION</h5>
                            </div>

                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <a href="" class="btn btn-sm btn-info" data-bs-toggle="modal" id="create-btn"
                                    data-bs-target="#update">
                                    <span> Update </span>
                                </a>
                                <div class="modal fade" id="update" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light p-3">
                                                <h5 class="modal-title" id="exampleModalLabel">P.O BOX INFORMATION
                                                    UPDATE
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="close-modal"></button>
                                            </div>
                                            <form class="tablelist-form" method="post"
                                                action="{{ route('branchManager.updatePob',$box->id) }}">
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

                                                    <div class="row mb-2">
                                                        <div class="col-md-3">
                                                            <label for="formrow-firstname-input" class="form-label">P.O
                                                                BOX</label>
                                                            <input type="text" class="form-control" id="pob" name="pob"
                                                                value="{{ $box->pob }}" disabled>
                                                        </div>
                                                        <div class="col-md-9">
                                                            <label for="formrow-firstname-input"
                                                                class="form-label">NAMES</label>
                                                            <input type="text" class="form-control" id="names"
                                                                name="name" value="{{ $box->name }}">
                                                        </div>

                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <label for="formrow-firstname-input"
                                                                class="form-label">PHONE</label>
                                                            <input type="text" class="form-control" id="phone"
                                                                name="phone" value="{{ $box->phone }}">

                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="formrow-firstname-input" class="form-label">LAST
                                                                PAYMENT YEAR</label>
                                                            <select class="form-select" name="year" required
                                                                aria-label="Default select example">
                                                                @foreach ($years as $year)
                                                                <option value="{{ $year->year }}"
                                                                    {{ $year->year == $box->year ? 'selected' : '' }}>
                                                                    {{ $year->year }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <label for="formrow-firstname-input" class="form-label">P.O
                                                                BOX
                                                                TYPE</label>
                                                            <select class="form-select" name="pob_category" required
                                                                aria-label="Default select example">
                                                                <option value="Individual"
                                                                    {{ $box->pob_category == 'Individual' ? 'selected' : '' }}>
                                                                    Individual</option>
                                                                <option value="Company"
                                                                    {{ $box->pob_category == 'Company' ? 'selected' : '' }}>
                                                                    Company</option>
                                                            </select>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="formrow-firstname-input" class="form-label">P.O
                                                                BOX
                                                                SIZE</label>
                                                            <select class="form-select" name="size" required
                                                                aria-label="Default select example">
                                                                <option value="Pte"
                                                                    {{ $box->size == 'Pte' ? 'selected' : '' }}>Pte
                                                                </option>
                                                                <option value="Gde"
                                                                    {{ $box->size == 'Gde' ? 'selected' : '' }}>Gde
                                                                </option>
                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="row mb-2">
                                                        <div class="col-md-6">
                                                            <label for="formrow-firstname-input"
                                                                class="form-label">COTION</label>
                                                            <select class="form-select" name="cotion" required
                                                                aria-label="Default select example">
                                                                <option value="1"
                                                                    {{ $box->cotion == 1 ? 'selected' : '' }}>
                                                                    YES</option>
                                                                <option value="0"
                                                                    {{ $box->cotion == 0 ? 'selected' : '' }}>
                                                                    NO</option>
                                                            </select>

                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="formrow-firstname-input"
                                                                class="form-label">AVAIBALE</label>
                                                            <select class="form-select" name="available" required
                                                                aria-label="Default select example">
                                                                <option value="1"
                                                                    {{ $box->available == 1 ? 'selected' : '' }}>YES
                                                                </option>
                                                                <option value="0"
                                                                    {{ $box->available == 0 ? 'selected' : '' }}>NO
                                                                </option>
                                                            </select>
                                                        </div>

                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn btn-success" id="add-btn">
                                                            Update
                                                        </button>
                                                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                <a href="" class="btn btn-sm btn-success" data-bs-toggle="modal"
                                    data-bs-target="#firstmodal">
                                    <span>Transfer </span>
                                </a>

                                <div class="modal fade" id="firstmodal" aria-hidden="true" aria-labelledby="..."
                                    tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <form action="{{ route('branchManager.transfer',$box->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body text-center p-5">
                                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json"
                                                        trigger="loop" colors="primary:#f7b84b,secondary:#405189"
                                                        style="width:130px;height:130px">
                                                    </lord-icon>
                                                    <div class="mt-4 pt-4">
                                                        <h4>Are you sure you want to do this !!</h4>
                                                        <p class="text-muted"> The transfer will make this pob available
                                                            to all customer ,
                                                            are you sure you want to transfer this pob? </p>
                                                        <!-- Toogle to second dialog -->
                                                        <button class="btn btn-danger">
                                                            Yes Continue
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                <a href="" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#pobboxpament">
                                    <span>P.o Box Payment</span>
                                </a>

                                <div class="modal fade" id="pobboxpament" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light p-3">
                                                <h5 class="modal-title" id="exampleModalLabel">P.O BOX PAYEMENT
                                                </h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="close-modal"></button>
                                            </div>

                                            <div class="modal-body">
                                                @if($errors->any())
                                                <div class="alert alert-danger">
                                                    <p><strong>Opps Something went wrong</strong></p>
                                                    <ul>
                                                        @foreach ($errors->all() as $error)
                                                        <li>* {{ $error }}</li>
                                                        @endforeach
                                                    </ul>
                                                </div>
                                                <br><br>
                                                @endif
                                                @if (session('alert'))
                                                <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0"
                                                    role="alert">
                                                    <i class="ri-close-line label-icon"></i><strong>Alert</strong>
                                                    {{ session('alert') }}
                                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                                        aria-label="Close"></button>
                                                </div>
                                                <br><br>
                                                @endif

                                                <form action="{{ route('branchManager.paymentStore') }}" method="post">
                                                    @csrf
                                                    @php
                                                    $event = $box->year >= now()->year ? 'disabled' : '';
                                                    @endphp
                                                    <div class="row mb-3">
                                                        <div class="col-lg-5">
                                                            <label for="nameInput" class="form-label">Owner Name</label>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <input type="text" class="form-control" disabled
                                                                value="{{ $box->name }}">
                                                            <input type="hidden" name="pob_id" value="{{ $box->id }}">

                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-5">
                                                            <label for="websiteUrl" class="form-label">Payment
                                                                Type</label>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <select {{ $event }} class="form-select" name="payment_type"
                                                                id="payment_type" required
                                                                aria-label="Default select example">
                                                                <option value="" selected disabled>Select payment type
                                                                </option>
                                                                <option value="rent">Rent</option>
                                                                <option value="cert">Certificate</option>
                                                                <option value="key">Key</option>
                                                                <option value="cotion">Cotion</option>
                                                                <option value="ingufuri">Ingufuri</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-5">
                                                            <label for="dateInput" class="form-label">Payment
                                                                Year</label>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <select {{ $event }} class="form-select" name="payment_year"
                                                                id="payment_year" required
                                                                aria-label="Default select example">
                                                                <option value="all" selected>Payment All</option>
                                                                {{-- yearsNotpaid --}}
                                                                @foreach ($yearsNotpaid as $year)
                                                                <option value="{{ $year }}">{{ $year }}</option>
                                                                @endforeach

                                                            </select>
                                                        </div>

                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-5">
                                                            <label for="dateInput" class="form-label">Payment
                                                                Model</label>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <select {{ $event }} class="form-select"
                                                                name="payment_model" id="payment_model" required
                                                                aria-label="Default select example">
                                                                <option value="" selected disabled>Select payment model
                                                                </option>
                                                                <option value="mobile_money">Mobile Money</option>
                                                                <option value="bank">Bank</option>
                                                                <option value="cash">Cash</option>
                                                                <option value="cos">COS</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-5">
                                                            <label for="timeInput" class="form-label">Payment
                                                                Reference</label>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <input {{ $event }} type="text" class="form-control"
                                                                required name="payment_ref"
                                                                placeholder="Enter your payment reference">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-5">
                                                            <label for="leaveemails" class="form-label">Amount</label>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <input {{ $event }} type="number" class="form-control"
                                                                required name="amount" id="amount"
                                                                placeholder="Enter your amount">
                                                            <input type="hidden" name="allAmount" id="allAmount">
                                                        </div>
                                                    </div>

                                                    <div class="text-end">
                                                        <button {{ $event }} type="submit"
                                                            class="btn btn-primary">submit</button>
                                                    </div>
                                                </form>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table align-middle" id="customerTable">
                                <thead class="table-light text-muted">
                                    <tr>

                                        <th class="sort" data-sort="pob">
                                            P.OB </th>
                                        <th class="sort" data-sort="names">
                                            NAMES</th>

                                        <th class="sort" data-sort="phone">
                                            PHONE </th>

                                        <th class="sort" data-sort="type">
                                            TYPE</th>
                                        <th class="sort" data-sort="size">
                                            SIZE</th>
                                        <th class="sort" data-sort="date">
                                            DATE</th>
                                        <th class="sort" data-sort="status">
                                            STATUS</th>
                                        <th class="sort" data-sort="cotion">
                                            COTION</th>
                                        <th class="sort" data-sort="payment">
                                            PAYMENT</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <tr>
                                        <td class="pob">{{ $box->pob }}</td>
                                        <td class="names">{{ $box->name }}</td>
                                        <td class="phone">{{ $box->phone }}</td>
                                        <td class="type">{{ $box->pob_category }}</td>
                                        <td class="size">{{ $box->size }}</td>
                                        <td class="date">{{ $box->date }}</td>
                                        <td class="status">
                                            @if ($box->year >= now()->year)
                                            <span class="badge bg-success">Paid</span>
                                            @else
                                            <span class="badge bg-danger">Unpaid</span>
                                            @endif
                                        </td>
                                        <td class="cotion">
                                            @if ($box->cotion == 1) YES @else NO @endif
                                        </td>
                                        <td class="payment">
                                            {{ number_format($total) }}
                                        </td>
                                    </tr>

                                </tbody>

                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-8">
            <div class="card" id="customerList">
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table align-middle" id="customerTable">

                                <thead class="table-light text-muted">
                                    <tr>

                                        <th class="sort" data-sort="pob">UNPAID TYPE</th>
                                        <th class="sort" data-sort="names">
                                            NUMBER OF YEAR</th>
                                        <th class="sort" data-sort="phone">
                                            CHARGES/FRW </th>

                                        <th class="sort" data-sort="type">
                                            AMOUNR/FRW</th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <tr>
                                        <th>PENALITIES</th>
                                        <td class="pernarty">
                                            {{ $pernaty }}
                                        </td>
                                        <td class="phone">

                                            {{ number_format($box->amount * 0.25)  }}
                                        </td>
                                        <td class="total">
                                            {{-- 25% of $box->amount * number of year --}}
                                            {{ number_format($box->amount * 0.25 * $pernaty) }}
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>P.O BOX RENT</th>
                                        <td class="names">
                                            {{ $rentYearNumber }}
                                        </td>
                                        <td class="phone">
                                            {{-- dispay amount in number format --}}
                                            {{ number_format($box->amount)  }}
                                        </td>
                                        <td class="total">
                                            {{-- dispay amount in number format --}}
                                            {{ number_format($box->amount * $rentYearNumber) }}
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
        <div class="col-lg-4">
            <div class="card" id="customerList">
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table align-middle" id="customerTable">
                                <thead class="table-light text-muted">
                                    <tr>

                                        <th>MORE INFO</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <tr>
                                        <th>ID / Certificate</th>
                                        <td class="names">
                                            {{-- attachment if is null --}}
                                            @if ($box->attachment == null)
                                            <span class="badge bg-danger">Not Uploaded</span>
                                            @else
                                            {{-- view attachment --}}
                                            <a href="{{ route('branchManager.download',$box->attachment) }}">View</a>
                                            @endif

                                        </td>
                                    </tr>
                                    @if ($box->aprooved == 1)
                                    <tr>
                                        <th>P.O Contract</th>
                                        <td class="names">
                                            {{-- view certificate --}}
                                            <a href="" target="_blank">View</a>
                                        </td>
                                    </tr>
                                    @endif

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>


    @endsection

    @section('script')
    <script>
        const payment_type = document.getElementById('payment_type');
        const amount = document.getElementById('amount');
        const payment_year = document.getElementById('payment_year');
        const allAmount = document.getElementById('allAmount');
        // if (payment_type.value == 'rent') { disable amount input } else { enable amount input }
        payment_type.addEventListener('change', (e) => {
            if (e.target.value == 'rent') {
                amount.disabled = true;
                amount.value = '{{ $total }}';
                allAmount.value = '{{ $total }}';
                payment_year.value = 'all';
            } else if (e.target.value == 'cert') {
                amount.disabled = false;
                amount.value = '';
                allAmount.value = '';
                payment_year.value = 'all';
            } else if (e.target.value == 'key') {
                amount.disabled = false;
                amount.value = '';
                allAmount.value = '';
                payment_year.value = 'all';
            } else if (e.target.value == 'cotion') {
                amount.disabled = false;
                amount.value = '';
                allAmount.value = '';
                payment_year.value = 'all';
            } else if (e.target.value == 'ingufuri') {
                amount.disabled = false;
                amount.value = '';
                allAmount.value = '';
                payment_year.value = 'all';
            }
        });
        // if (payment_year.value == 'all' $$ payment_type== 'rent') { disable amount input } else { enable amount input }
        payment_year.addEventListener('change', (e) => {
            if (e.target.value == 'all' && payment_type.value == 'rent') {
                amount.disabled = true;
                amount.value = '{{ $total }}';
                allAmount.value = '{{ $total }}';
            } else {
                if (payment_type.value == 'rent') {
                    amount.disabled = true;
                    amount.value = '{{ $box->amount + ($box->amount * 0.25) }}';
                    allAmount.value = '{{ $box->amount + ($box->amount * 0.25) }}';
                } else {
                    amount.disabled = true;
                    amount.value = '';
                    allAmount.value = '';
                }
            }
        });

    </script>

    <script>
        @if(session('alert'))
        var myModal = new bootstrap.Modal(document.getElementById('pobboxpament'), {
            keyboard: false
        })
        myModal.show()
        @endif

    </script>
    @endsection
