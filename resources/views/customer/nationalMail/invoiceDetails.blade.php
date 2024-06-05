@extends('layouts.customer.app')
@section('page') Invoice @endsection

@section('content')
<div class="row justify-content-center">
    <div class="col-xxl-9">
        <div class="card" id="demo">
            <div class="row">
                <div class="col-lg-12">
                    <div class="card-body p-4">
                        <div class="row g-3">
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Invoice No</p>
                                <h5 class="fs-14 mb-0">#{{ $invoice->invoice_number }}</h5>
                            </div>
                            <!--end col-->
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Date</p>
                                <h5 class="fs-14 mb-0"><span id="invoice-date">{{ Carbon\Carbon::parse($invoice->created_at)->format('d M, Y') }}
                                    </span> <small class="text-muted" id="invoice-time">{{ Carbon\Carbon::parse($invoice->created_at)->format('h:iA') }}
                                        </small></h5>
                            </div>
                            <!--end col-->
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Payment Status</p>
                                @if ($invoice->invoice_payment_status == 'pending')
                                <span class="badge badge-soft-primary fs-11" id="payment-status">Pending</span>
                                @elseif($invoice->invoice_payment_status == 'paid')
                                <span class="badge badge-soft-success fs-11" id="payment-status">Paid</span>
                                @else
                                <span class="badge badge-soft-danger fs-11" id="payment-status">Overdue</span>
                                @endif

                            </div>
                            <!--end col-->
                            <div class="col-lg-3 col-6">
                                <p class="text-muted mb-2 text-uppercase fw-semibold">Total Amount</p>
                                <h5 class="fs-14 mb-0">FRW <span id="total-amount"> {{ number_format($invoice->invoice_total) }}</span></h5>
                            </div>
                            <!--end col-->
                        </div>
                        <!--end row-->
                    </div>
                    <!--end card-body-->
                </div><!--end col-->

                <div class="col-lg-12">
                    <div class="card-body p-4">
                        <div class="table-responsive">
                            <table class="table table-borderless text-center table-nowrap align-middle mb-0">
                                <thead>
                                    <tr class="table-active">
                                        <th scope="col" style="width: 50px;">#</th>
                                        <th scope="col" class="text-start">Reference</th>
                                        <th scope="col" class="text-start">Destination</th>
                                        <th scope="col" class="text-start">Date</th>
                                        <th scope="col" class="text-start">Qte</th>
                                        <th scope="col" class="text-start">Amount</th>
                                    </tr>
                                </thead>
                                <tbody id="products-list">

                                    @foreach ($mails as $mail)
                                    <tr>
                                    <td scope="row" ><strong>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</strong></td>
                                    <td class="text-start">{{  $invoice->invoice_number }}</td>
                                    <td class="text-start">{{ $mail->details->destination->address }}</td>
                                    <td class="text-start">{{ $mail->dateReceived }}</td>
                                    <td class="text-start">1.00</td>
                                    <td class="text-start">{{ number_format($mail->price) }}</td>
                                    </tr>
                                    @endforeach

                                </tbody>
                            </table><!--end table-->
                        </div>

                        {{-- <div class="hstack gap-2 justify-content-end d-print-none mt-4">
                            <a href="javascript:window.print()" class="btn btn-success"><i class="ri-printer-line align-bottom me-1"></i> Print</a>
                            <a href="javascript:void(0);" class="btn btn-primary"><i class="ri-download-2-line align-bottom me-1"></i> Download</a>
                        </div> --}}
                    </div>
                    <!--end card-body-->
                </div><!--end col-->
            </div><!--end row-->
        </div>
        <!--end card-->
    </div>
    <!--end col-->
</div>
<!--end row-->
@endsection

@section('script')

@endsection
