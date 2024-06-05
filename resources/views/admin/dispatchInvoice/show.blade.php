@extends('layouts.admin.app')
@section('page-name')Recieved Dispatch  @endsection
@section('body')

<!-- end page title -->

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">

                    <div class="col-sm-auto">
                       <h5>Customer invoice</h5>
                    </div>
                    <div class="col-sm">
                        <div class="d-md-flex justify-content-sm-end gap-2">
                            {{-- generate invoice button --}}
                            <button type="button" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#generateInvoice"> Generate Invoice</button>
                            <div id="generateInvoice" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-body p-5">

                                                <div class="text-muted text-center mx-lg-3">
                                                    <h4 class="">Generate Invoice</h4>
                                                    <p class="mb-4">Invoice will be generated for the selected month</p>
                                                </div>

                                                <div class="mt-4">
                                                    <form action="{{ route('admin.dispatchInvoice.store') }}" method="POST" enctype="multipart/form-data">
                                                        @csrf
                                                        <div class="row">
                                                            <div class="col-md-6">
                                                                {{-- from last 5 years to current --}}
                                                                <label for="formFile" class="form-label">Select Year</label>
                                                                <select class="form-select" aria-label="Default select example" name="year" required>
                                                                    <option disabled selected>Select Year</option>
                                                                    @for ($i = date('Y'); $i >= date('Y')-5; $i--)
                                                                        <option value="{{ $i }}">{{ $i }}</option>
                                                                    @endfor
                                                                </select>
                                                            </div>
                                                            <div class="col-md-6">
                                                                <div class="mb-3">
                                                                    <input type="hidden" name="customer_id" value="{{ $customer }}">
                                                                    {{-- select 12 Months --}}
                                                                    <label for="formFile" class="form-label">Select Month</label>
                                                                    <select class="form-select" aria-label="Default select example" name="month" required>
                                                                        <option disabled selected>Select Month</option>
                                                                        <option value="1">January</option>
                                                                        <option value="2">February</option>
                                                                        <option value="3">March</option>
                                                                        <option value="4">April</option>
                                                                        <option value="5">May</option>
                                                                        <option value="6">June</option>
                                                                        <option value="7">July</option>
                                                                        <option value="8">August</option>
                                                                        <option value="9">September</option>
                                                                        <option value="10">October</option>
                                                                        <option value="11">November</option>
                                                                        <option value="12">December</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        {{-- IBM Attachment --}}
                                                        <div class="mb-3">
                                                            <label for="formFile" class="form-label">IBM Attachment</label>
                                                            <input class="form-control" type="file" id="formFile" name="ibm_attachment" accept=".pdf,0.jpg,.jpeg,.png" required>
                                                        </div>

                                                        <div class="mt-3">
                                                            <button type="submit" class="btn btn-success w-100">Confirm</button>
                                                        </div>

                                                    </form>

                                                </div>

                                        </div>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
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
                                <th scope="col">Payment Recu</th>
                                <th scope="col">Total Amount</th>
                                <th scope="col">Payment Status</th>
                                <th scope="col">Pernalty</th>
                                <th scope="col">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($invoices as $invoice)
                             <tr>
                                <td>{{ $loop->index+1 }}</td>
                                <td>{{ $invoice->invoice_number }}</td>
                                <td>{{ Carbon\Carbon::create()->month($invoice->invoice_month)->format('F') }} - {{ $invoice->invoice_year  }} </td>
                                <td>{{ $invoice->created_at->format('d-m-Y') }}</td>
                                <td>
                                @if ($invoice->invoice_payment_status == 'paid')
                                    <a href="{{ route('admin.dispatchInvoice.download',$invoice->id) }}" class="btn btn-outline-dark btn-sm">View Recu</a>
                                @else
                                    <i>Not Yet Pay </i>
                                @endif
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
                                    {{-- notify --}}
                                    <a href="" class="btn btn-outline-dark btn-sm" data-bs-toggle="modal" data-bs-target="#notify{{ $invoice->id }}">Notify</a>

                                    <div id="notify{{ $invoice->id }}" class="modal fade model-lg" tabindex="-1" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-body p-5">

                                                        <div class="text-muted text-center mx-lg-3">
                                                            <h4 class="">Notify Customer</h4>
                                                            <p class="mb-4">You are about to notify <b>{{ $invoice->customerName->name }}</b> for the invoice of <b>{{ Carbon\Carbon::create()->month($invoice->invoice_month)->format('F') }} - {{ $invoice->invoice_year  }}</b></p>
                                                        </div>

                                                        <div class="mt-4">
                                                            <form action="{{ route('admin.dispatchInvoice.notificationStore',$invoice->id) }}" method="POST" enctype="multipart/form-data">
                                                                @csrf
                                                                {{-- subject --}}
                                                                <div class="mb-3">
                                                                    <label for="formFile" class="form-label">Subject</label>
                                                                    <input class="form-control" type="text" id="subject" name="subject" placeholder="Enter Subject" required>
                                                                </div>
                                                                <div class="row">
                                                                    {{-- textarea --}}
                                                                    <label for="formFile" class="form-label">Message</label>
                                                                    <div class="col-md-12 mb-3">
                                                                        <textarea name="message" class="form-control" id="meassageInput" rows="6" placeholder="Enter your message"></textarea>
                                                                    </div>

                                                                </div>
                                                                {{-- Attachment --}}
                                                                <div class="mb-3">
                                                                    <label for="formFile" class="form-label">Attachment</label>
                                                                    <input class="form-control" type="file" id="formFile" name="attachment" accept=".pdf,.jpg,.jpeg,.png">
                                                                </div>

                                                                {{-- checkbox sms or email --}}
                                                                <div class="row">
                                                                    <div class="col-6">
                                                                        <div class="form-check">
                                                                          <input class="form-check-input" checked name="sent[]" type="checkbox" value="EMAIL"
                                                                            id="defaultCheck4" />
                                                                          <label class="form-check-label" for="defaultCheck4">EMAIL (Uncheck if "NO")
                                                                          </label>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-6">
                                                                        <div class="form-check">
                                                                          <input class="form-check-input" name="sent[]" type="checkbox" value="SMS"
                                                                            id="defaultCheck3" />
                                                                          <label class="form-check-label" for="defaultCheck3">SMS (Uncheck if "NO")
                                                                          </label>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="mt-3">
                                                                    <button type="submit" class="btn btn-success w-100"> Notify</button>
                                                                </div>

                                                            </form>

                                                        </div>

                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                    {{-- view --}}
                                    <a href="{{ route('admin.dispatchInvoice.showInvoice',$invoice->id) }}" class="btn btn-outline-primary btn-sm" target="_blank">Invoice</a>
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
<!--end row-->



@endsection
@section('css')

@endsection

@section('script')

@endsection
