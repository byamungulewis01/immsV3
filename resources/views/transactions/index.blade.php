@extends('layouts.admin.app')
@section('page-name')
    Transactions
@endsection
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Transactions</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">Transactions</a>
                        </li>
                        <li class="breadcrumb-item active">All Transactions</li>
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
                                <h5 class="card-title mb-0">All Transactions</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">

                                <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                    id="create-btn" data-bs-target="#showModal">
                                    <i class="ri-add-line align-bottom me-1"></i> New Transaction
                                </button>
                                <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog model-lg">
                                        <div class="modal-content">
                                            <div class="modal-header p-3">
                                                <h5 class="modal-title" id="exampleModalLabel">Add new transaction</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="close-modal"></button>
                                            </div>
                                            <form class="tablelist-form" method="post" id="add-form"
                                                action="{{ route('admin.transactions.store') }}">
                                                @csrf
                                                <div class="modal-body">

                                                    <div class="row">
                                                        <div class="col-md-12 mb-2">
                                                            <label for="reference_number"> Electricity Meter </label>
                                                            <div class="input-group"><input
                                                                    class="form-control py-2 numbers" type="search"
                                                                    name="reference_number" id="reference-number"><span
                                                                    class="input-group-append"><button
                                                                        class="btn btn-primary border-left-0 border btnCheckIdDetails"
                                                                        id="btnCheckIdDetails" type="button">
                                                                        Check</button></span>
                                                            </div>
                                                        </div>
                                                        <div id="paymentDetails" style="display: none;">
                                                            <div class="col-md-12 mb-2">
                                                                <label for="customer-name"> Customer Name </label>
                                                                <input id="customer-name" readonly type="text"
                                                                    name="customer_name" class="form-control"
                                                                    aria-describedby="Customer Name">
                                                            </div>
                                                            <div class="col-md-12 mb-2">
                                                                <label for="amount"> Amount </label>
                                                                <input id="amount" min="500"
                                                                    type="number" name="amount" required
                                                                    class="form-control" aria-describedby="amount">
                                                            </div>

                                                            <div class="col-md-12 mb-2">
                                                                <label for="customer-phone"> Customer Phone </label>
                                                                <input id="customer-phone" required type="text"
                                                                    name="customer_phone" class="form-control"
                                                                    aria-describedby="Customer phone">
                                                            </div>
                                                            <div class="col-md-12 mb-2">
                                                                <label for="customer-email"> Customer Email </label>
                                                                <input id="customer-email" type="email"
                                                                    name="customer_email" class="form-control"
                                                                    aria-describedby="Customer email">
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" disabled class="btn btn-success confirm-btn"
                                                            id="add-btn">
                                                            Confirm Transaction
                                                        </button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="card-body">
                    <table id="transactions" class="table table-centered table-hover align-middle table-nowrap mb-0"
                        style="width: 100%;">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Meter Number</th>
                                <th>Customer Name</th>
                                <th>Customer Email</th>
                                <th>Customer Telephone</th>
                                <th>Amount(Rwf)</th>
                                <th>Token</th>
                                <th>Created At</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->
@endsection
@section('css')
    {{-- <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" /> --}}

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            $(".numbers").on("input", function() {
                var value = $(this).val();
                var decimalRegex = /^[0-9]+(\.[0-9]{1,2})?$/;
                if (!decimalRegex.test(value)) {
                    $(this).val(value.substring(0, value.length - 1));
                }
            });
        });
    </script>
    <script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>


    <script>
        $(document).on('click', '#btnCheckIdDetails', function() {
            let $reference_number = $(document).find('#reference-number')
            let $customer_name = $('#customer-name');
            var confirm_btn = $(".confirm-btn");
            let meter_number = $reference_number.val();
            let url = "{{ route('admin.transactions.fetch-meter-from-eucl') }}?meter_number=" + meter_number;


            let btn = $(this);
            btn.attr('disabled', true);
            btn.html(`<div class="spinner-border spinner-border-sm" role="status">
                                <span class="sr-only">Loading...</span> </div>`);
            $.ajax({
                url: url,
                method: "get",
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        console.log(response);
                        let meteName = response.meter_name;
                        if (meteName) {
                            $customer_name.val(meteName);
                        } else {
                            Swal.fire({
                                title: 'Error',
                                text: response.messagess,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        }
                    } else if (response.content && response.status) {
                        Swal.fire({
                            title: 'Error',
                            text: response.messagess,
                            icon: 'error',
                            confirmButtonText: 'Ok',
                            confirmButtonColor: '#3085d6',
                        });
                    } else {
                        Swal.fire({
                            title: 'Error',
                            text: "Something went wrong, please try again later",
                            icon: 'error',
                            confirmButtonText: 'Ok'
                        });
                    }
                },
                error: function(response) {
                    Swal.fire({
                        title: "Error",
                        icon: "error",
                        text: "Unable to check meter number details, try again"
                    });
                },
                complete: function() {
                    $('#paymentDetails').show();
                    btn.attr('disabled', false);
                    btn.html('Check');
                    confirm_btn.attr('disabled', false);
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#transactions').DataTable({
                scrollX: true,
                ajax: "{{ route('admin.transactions.api') }}",
                columns: [{
                        data: 'id'
                    },
                    {
                        data: 'reference_number'
                    },
                    {
                        data: 'customer_name'
                    },
                    {
                        data: 'customer_email'
                    },
                    {
                        data: 'customer_phone'
                    },
                    {
                        data: 'amount'
                    },
                    {
                        data: 'token'
                    },
                    {
                        data: 'created_at'
                    },
                    {
                        data: 'status'
                    },
                ],
                columnDefs: [{
                    targets: 0,
                    render: function(data, type, row, meta) {
                        var id = row.id;
                        var route =
                            "{{ route('admin.transactions.printReceipt', ['id' => ':id']) }}";
                        route = route.replace(':id', id);
                        return `<div class="dropdown card-header-dropdown">
                                <a class="text-reset dropdown-btn" href="#" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <span class="text-muted fs-18"><i class="mdi mdi-dots-vertical align-middle"></i></span>
                                </a>
                                <div class="dropdown-menu dropdown-menu-end" style="">
                                    <a target="_blank" class="dropdown-item" href="${route}?type=print">Print</a>
                                    ${row.customer_email ? `<a class='dropdown-item' href='${route}?type=email'>Send Email</a>` : ''}
                                    <a class="dropdown-item" href="${route}?type=sms">Send SMS</a>
                                </div>
                            </div>`;
                    },
                }, {
                    targets: 8,
                    render: function(data, type, row, meta) {
                        if (row.status == 'Success') {
                            return `<span class="badge bg-success">Success</span>`;
                        } else {
                            return `<span class="badge bg-danger">Pending</span>`;
                        }
                    },
                }],
                order: [],


            });
        });
    </script>
@endsection
