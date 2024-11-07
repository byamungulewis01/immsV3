@extends('layouts.customer.app')
@section('page')POBox Details @endsection
@section('content')
<!-- start page title -->

@php
use App\Models\PreFormaBill;
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
                <h4 class="mb-sm-0">POBox Details</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS P.O B</a>
                        </li>
                        <li class="breadcrumb-item active">POBox Details</li>
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

                                                <form action="{{ route('customer.physicalPayment') }}" method="post">
                                                    @csrf
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
                                                            <select class="form-select" name="payment_type" id="payment_type" required
                                                                aria-label="Default select example">
                                                                <option value="" selected disabled>Select payment type
                                                                </option>
                                                                <option value="rent">Rent</option>
                                                                <option value="cert">Certificate</option>
                                                                <option value="cotion">Cotion</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-5">
                                                            <label for="dateInput" class="form-label">Payment Year</label>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <select class="form-select" name="payment_year"
                                                                id="payment_year" required
                                                                aria-label="Default select example">
                                                                <option value="all" selected>Payment All Debits</option>
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
                                                            <select class="form-select"
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
                                                            <input type="text" class="form-control"
                                                                required name="payment_ref"
                                                                placeholder="Enter your payment reference">
                                                        </div>
                                                    </div>
                                                    <div class="row mb-3">
                                                        <div class="col-lg-5">
                                                            <label for="leaveemails" class="form-label">Amount</label>
                                                        </div>
                                                        <div class="col-lg-7">
                                                            <input type="number" class="form-control"
                                                                required name="amount" id="amount"
                                                                placeholder="Enter your amount">
                                                            <input type="hidden" name="allAmount" id="allAmount">
                                                        </div>
                                                    </div>

                                                    <div class="text-end">
                                                        <button type="submit"
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
                                            {{-- if total < 0  --}}
                                            @if ($total < 0)
                                            0
                                            @else
                                            {{ number_format($total) }}
                                            @endif
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
           <div class="row mb-3">
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
                                            @if ($pernaty < 0)
                                            0
                                            @else
                                            {{ $pernaty }}
                                            @endif

                                        </td>
                                        <td class="phone">

                                            {{ number_format($box->amount * 0.25)  }}
                                        </td>
                                        <td class="total">
                                        @php
                                            $amount = $box->amount * 0.25 * $pernaty;
                                        @endphp
                                              @if ($amount < 0)
                                              0
                                              @else
                                              {{ $amount }}
                                              @endif
                                        </td>

                                    </tr>
                                    <tr>
                                        <th>P.O BOX RENT</th>
                                        <td class="names">
                                            @if ($rentYearNumber < 0)
                                            0
                                            @else
                                            {{ $rentYearNumber }}
                                            @endif

                                        </td>
                                        <td class="phone">
                                            {{-- dispay amount in number format --}}
                                            {{ number_format($box->amount)  }}
                                        </td>
                                        <td class="total">
                                            @php
                                                $amountTotal = $box->amount * $rentYearNumber;
                                            @endphp
                                               @if ($amountTotal < 0)
                                               0
                                               @else
                                               {{ $amountTotal }}
                                               @endif
                                        </td>

                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            <div class="card" id="customerList">
                <div class="card-header border-bottom-dashed">
                    <div class="row g-4 align-items-center">
                        <div class="col-sm">
                            <div>
                                <h5 class="card-title mb-0">P.O BOX PAYMENT HISTORY</h5>
                            </div>

                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            <table class="table align-middle" id="customerTable">
                                <thead class="table-light text-muted">
                                    <th>#</th>
                                    <th>INVOICE </th>
                                    <th>DATE</th>
                                    <th>TYPE</th>
                                    <th>YEAR</th>
                                    <th>AMOUNT/FRW</th>
                                    <th>PRINT</th>
                                </thead>
                                <tbody class="list form-check-all">
                                    @forelse ($payments as $key => $payment)
                                    <tr>
                                        <td class="pob">{{ $key + 1 }}</td>
                                        <td class="names">BN{{ $payment->id }}</td>
                                        <td class="phone">{{ $payment->created_at }}</td>
                                        <td class="type">{{ strtoupper($payment->payment_type) }}</td>
                                        <td class="size">{{ $payment->year }}</td>
                                        <td class="size">{{ number_format($payment->amount) }}</td>
                                        <td class="size">
                                            <a href="{{ route('customer.invoice', $payment->id) }}" class="btn btn-sm btn-primary" target="_blank">Invoice</a>
                                        </td>
                                    </tr>

                                    @empty
                                    <tr>
                                        <td class="pob">No payment history</td>

                                    </tr>


                                    @endforelse

                                </tbody>

                            </table>
                        </div>

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
                                        <th>ID Docs</th>
                                        <td class="names">
                                            {{-- attachment if is null --}}
                                            @if ($box->attachment == null)
                                            <span class="badge bg-danger">Not Uploaded</span>
                                            @else
                                            {{-- view attachment --}}
                                            <a href="{{ route('customer.physicalPob.download',$box->attachment) }}">View</a>
                                            @endif

                                        </td>
                                    </tr>
                                    <tr>
                                        <th>P.O.B Certificate</th>
                                        <td class="names">
                                            @if (App\Models\PobPay::where('box_id', $box->id)->where('payment_type', 'cert')->first())
                                                <a class="btn btn-sm btn-primary" href="{{ route('customer.certificate', $box->id) }}"
                                                    target="_blank">View</a>
                                            @else
                                                <span class="badge bg-danger">Not Paid</span>
                                            @endif
                                        </td>
                                    </tr>
                                    @if ($box->aprooved == 1)
                                    {{-- <tr>
                                        <th>P.O Contract</th>
                                        <td class="names">
                                            <a href="" target="_blank">View</a>
                                        </td>
                                    </tr> --}}
                                    @endif

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            @unless ($box->year >= now()->year)
            <div class="card" id="customerList">
                <div class="card-body">
                    <div>
                        <div class="table-responsive table-card mb-1">
                            @php
                            $items = PreFormaBill::where('box', $box->id)->latest()->first();
                            $currentYear = date('Y');

                            $billYears = [];
                            if ($items != null) {
                                $billYears = explode(',', $items->non_pay_years);
                            }

                            @endphp
                            <table class="table align-middle" id="customerTable">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th>FACTURE PREFORMA</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    <tr>
                                        <td>
                                            <strong>YEAR :</strong>
                                            @php
                                             $paidYear = $box->year + 1;
                                            $currentYear = now()->year;
                                            $yearsNotpaid = [];
                                            for ($i = $paidYear; $i <= $currentYear; $i++) {
                                                $yearsNotpaid[] = $i;
                                            }

                                            @endphp
                                            [
                                                <em>
                                                    {{ implode(', ', $yearsNotpaid) }}
                                                </em>
                                            ]
                                        </td>
                                        <td class="names">
                                            @if ($items == null)
                                            {{-- <a href="" type="submit" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#proforma">Generate</a> --}}
                                            @else
                                             @if (in_array($currentYear, $billYears))
                                                <a href="{{ route('customer.preforma',$box->id) }}" type="submit" class="btn btn-sm btn-primary" target="_black">Get Bill</a>
                                             @else
                                                {{-- <a href="" type="submit" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#proforma">Generate</a> --}}
                                             @endif
                                            @endif

                                        </td>
                                    </tr>

                                </tbody>
                            </table>
                        </div>

                    </div>
                </div>
            </div>
            @endunless

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
                payment_year.disabled = false;
            } else if (e.target.value == 'cert') {
                amount.disabled = true;
                amount.value = 5000;
                allAmount.value = 5000;
                payment_year.value = 'all';
                payment_year.disabled = true;
            } else if (e.target.value == 'key') {
                amount.disabled = true;
                amount.value = 3500;
                allAmount.value = 3500;
                payment_year.value = 'all';
                payment_year.disabled = true;
            } else if (e.target.value == 'cotion') {
                amount.disabled = true;
                amount.value = 11000;
                allAmount.value = 11000;
                payment_year.value = 'all';
                payment_year.disabled = true;
            } else if (e.target.value == 'ingufuri') {
                amount.disabled = true;
                amount.value = 5000;
                allAmount.value = 5000;
                allAmount.value = amount.value;
                payment_year.value = 'all';
                payment_year.disabled = true;
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
                    const year = new Date().getFullYear();

                    if (payment_year.value > year) {
                        amount.value = '{{ $box->amount }}';
                        allAmount.value = '{{ $box->amount }}';
                    } else {
                    amount.value = '{{ $box->amount + ($box->amount * 0.25) }}';
                    allAmount.value = '{{ $box->amount + ($box->amount * 0.25) }}';
                    }


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
