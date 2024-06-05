@extends('layouts.customer.app')
@section('page') Create Mail @endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="customerList">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">My Mails</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">

                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive table-card mb-1">
                    <table class="table align-middle" id="customerTable">
                        <thead class="table-light text-muted">
                            <tr>

                                <th scope="col" style="width: 40px">#</th>
                                <th scope="col">Invoice No</th>
                                <th scope="col">Invoice Of</th>
                                <th scope="col">Invoice Date</th>
                                <th scope="col">IBM </th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Pernalty</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoices as $invoice)
                             <tr>
                                <td><strong>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</strong></td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ Carbon\Carbon::create()->month($invoice->invoice_month)->format('F') }} - {{ $invoice->invoice_year  }} </td>
                                <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
                                <td>
                                <a href="{{ route('customer.mails.download',$invoice->id) }}" class="btn btn-outline-primary btn-sm">View IBM</a>

                                </td>
                                <td>{{ number_format($invoice->invoice_total) }}</td>
                                <td>
                                    @if ($invoice->invoice_payment_status == 'pending')
                                        <span class="badge bg-success">{{ $invoice->invoice_payment_status }}</span>
                                    @elseif($invoice->invoice_payment_status == 'paid')
                                        <span class="badge bg-warning">{{ $invoice->invoice_payment_status }}</span>
                                    @else
                                        <span class="badge bg-danger">{{ $invoice->invoice_payment_status }}</span>
                                    @endif

                                </td>
                                <td>
                                    @php
                                        $invoice_date = $invoice->invoice_date;
                                        $current_date = date('Y-m-d');
                                        $pernalty_date = date("Y-m-d", strtotime($invoice_date . " +30 days"));
                                        if ($current_date < $pernalty_date) {
                                                $due_amount = 0;
                                            } else {
                                                $due_amount = 15000;
                                            }
                                    @endphp
                                    {{ $due_amount }}
                                </td>
                                <td>
                                    {{-- pay --}}
                                    @if ($invoice->invoice_status == 'pending')
                                        <a href="" class="btn btn-outline-primary btn-sm" data-bs-toggle="modal" data-bs-target="#payment{{ $invoice->id }}">Pay Invoice</a>
                                        <div id="payment{{ $invoice->id }}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-body p-5">

                                                            <div class="text-muted text-center mx-lg-3">
                                                                <h4 class="">Invoice Payment</h4>
                                                                <p class="mb-4">Please upload your payment receipt</p>
                                                            </div>

                                                            <div class="mt-4">
                                                                <form action="{{ route('customer.mails.payInvoice',$invoice->id) }}" method="POST" enctype="multipart/form-data">
                                                                    @csrf
                                                                    @method('PUT')
                                                                    {{-- IBM Attachment --}}
                                                                    <div class="mb-3">
                                                                        <label for="formFile" class="form-label">Payment Receipt</label>
                                                                        <input class="form-control" type="file" id="formFile" name="attachment" accept=".pdf,0.jpg,.jpeg,.png" required>
                                                                    </div>

                                                                    <div class="mt-3">
                                                                        <button type="submit" class="btn btn-success w-100">Send</button>
                                                                    </div>

                                                                </form>

                                                            </div>

                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                    @endif
                                    <a href="{{ route('customer.mails.showInvoice',$invoice->id) }}" class="btn btn-outline-primary btn-sm" target="_blank">Invoice</a>
                                </td>
                             </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">No Data Found</td>
                                </tr>

                            @endforelse
                        </tbody>


                    </table>
                </div>
            </div>
        </div>
    </div>
    <!--end col-->
</div>


@endsection

@section('script')

@endsection
