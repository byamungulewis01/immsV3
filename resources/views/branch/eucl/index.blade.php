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

        <div class="col-xxl-4 col-xl-6">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Acount Name:</h4>
                    <div class="flex-shrink-0">
                        <div class="form-check form-switch form-switch-right form-switch-md">
                            <label for="listbutton-showcode" class="form-label text-muted">IPOSITA</label>
                        </div>
                    </div>
                </div><!-- end card header -->
                <div class="card-body">
                    <div class="live-preview">
                        <div class="list-group">
                            <button id="accountSammary" type="button" class="list-group-item list-group-item-action active"
                                aria-current="true"><i class="ri-shield-check-line align-middle me-2"></i>Account
                                Summary</button>
                            <button id="paymentRetry" type="button" class="list-group-item list-group-item-action"><i
                                    class="ri-equalizer-line align-middle me-2"></i>Meter History</button>
                            <button id="changePassword" type="button" class="list-group-item list-group-item-action"><i
                                    class="ri-lockx`-line align-middle me-2"></i>Change Password</button>

                        </div>
                    </div>

                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <div class="col-xxl-8 col-xl-12 ">
            <div class="card h-100">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">EUCL Information</h4>

                </div><!-- end card header -->
                <div class="card-body">
                    <div id="sammaryRespone">
                    </div>
                    <div id="paymentRetryResponse">

                    </div>
                    <div style="display: none" id="change-password-form">
                        @csrf
                        @method('PUT')
                        <div class="card-body">
                            <div class="form-group row mb-3">
                                <label class="col-xl-3 col-lg-3 col-form-label text-alert">Current
                                    Password</label>
                                <div class="col-lg-9 col-xl-6">
                                    <input type="password" class="form-control"
                                        id="current_password" placeholder="Current password">

                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-xl-3 col-lg-3 col-form-label text-alert">New Password</label>
                                <div class="col-lg-9 col-xl-6">
                                    <input type="password" class="form-control"
                                        id="new_password" placeholder="New password">
                                </div>
                            </div>
                            <div class="form-group row mb-3">
                                <label class="col-xl-3 col-lg-3 col-form-label text-alert">Verify
                                    Password</label>
                                <div class="col-lg-9 col-xl-6">
                                    <input type="password" class="form-control"
                                        id="confirm_password" placeholder="Verify password">
                                </div>
                            </div>
                            <button type="button" id="paswordChange" class="btn btn-success mr-2">Change
                                Password</button>
                        </div>
                    </div>

                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <!--end row-->

    <div class="row mt-4">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <h2>Vendor Account History</h2>
                    <table id="kt_datatable1" class="table table-centered table-hover align-middle table-nowrap mb-0"
                        style="width: 100%;">
                        <thead>
                            <tr>
                                <th># </th>
                                <th>Transaction ID </th>
                                <th>Meter number </th>
                                <th>Amount</th>
                                <th>Receipt number </th>
                                <th>Total units</th>
                                <th>Transaction time </th>
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
@endsection
@section('css')
    {{-- <link href="https://cdn.datatables.net/1.13.2/css/jquery.dataTables.min.css" rel="stylesheet" /> --}}

    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection

@section('script')
<script src="https://cdn.datatables.net/1.13.2/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>

    <script>
        $(document).on('click', '#accountSammary', function() {
            $(this).addClass('active');
            $('#paymentRetry').removeClass('active');
            $('#changePassword').removeClass('active');
            $('#paymentRetryResponse').html('');
            $('#change-password-form').hide();
            let btn = $(this);
            btn.attr('disabled', true);
            btn.html(`<div class="spinner-border spinner-border-sm" role="status">
                            <span class="sr-only">Loading...</span>
                    </div>`);
            $.ajax({
                url: "{{ route('admin.eucl-service.sammary') }}",
                method: "get",
                dataType: 'json',
                success: function(response) {
                    if (response) {
                        // let meteName = response.meter_name;
                        if (response.messages == 'No Response Found') {

                            Swal.fire({
                                title: 'Error',
                                text: response.messagess,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        } else {
                            // console.log(response);
                            let p3 = new Intl.NumberFormat().format(response.p3);
                            let p5 = new Intl.NumberFormat().format(response.p5);
                            let p11 = new Intl.NumberFormat().format(response.p11);

                            $('#sammaryRespone').html(`<div class="row m-0" >
                            <div class="col px-3 py-2 ">
                                <div class="font-size-sm text-muted font-weight-bold">Account balance </div>
                                <div class="font-weight-bold"><strong>RWF ${p3}</strong></div>
                            </div>
                            <div class="col px-3 py-2">
                                <div class="font-size-sm text-muted font-weight-bold">Daily opening balance</div>
                                <div class="font-weight-bold"><strong>RWF ${p5}</strong></div>
                            </div>
                            <div class="col px-3 py-2">
                                <div class="font-size-sm text-muted font-weight-bold">Monthly opening balance</div>
                                <div class="font-weight-bold"><strong>RWF ${p11}</strong></div>
                            </div>
                        </div>`);
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
                        text: "Unable to check details, try again"
                    });
                },
                complete: function() {
                    btn.html(`<i class="ri-shield-check-line align-middle me-2"></i>Account Summary`);

                }
            });
        });
    </script>

    <script>
        $(document).on('click', '#paymentRetry', function() {
            $(this).addClass('active');
            $('#accountSammary').removeClass('active');
            $('#changePassword').removeClass('active');

            $('#sammaryRespone').html('');
            $('#change-password-form').hide();
            $('#paymentRetryResponse').html(`<div class="input-group">
                                <input class="form-control py-2" placeholder="Meter Number" type="search"
                                    name="meterNumber" id="meterNumber">
                                <span class="input-group-append">
                                    <button class="btn btn-primary border-left-0 border btnCheckIdDetails"
                                        id="btnCheckIdDetails" type="button"> Check</button>
                                </span>
                            </div>`);

        });
        $(document).on('click', '#btnCheckIdDetails', function() {

            let meter = $("#meterNumber").val();

            let btn = $(this);
            btn.attr('disabled', true);
            btn.html(`<div class="spinner-border spinner-border-sm" role="status">
                            <span class="sr-only">Loading...</span>
                    </div>`);
            $.ajax({
                url: "{{ route('admin.eucl-service.meterHistory') }}?meter_number=" + meter,
                method: "get",
                dataType: 'json',
                success: function(response) {
                    console.log(response);
                    if (response) {
                        // let meteName = response.meter_name;
                        if (response.messages == 'Meter number not found') {

                            Swal.fire({
                                title: 'Error',
                                text: response.messages,
                                icon: 'error',
                                confirmButtonText: 'Ok'
                            });
                        } else {
                            $('#paymentRetryResponse').html('');
                            let table = `<table class="table">
                            <tr><th>Receipt number</th> <th>Transaction time</th><th>Total amount</th><th>Total units</th> </tr>
                            `;

                            // Assuming response is an array of objects, each object representing a row in the table
                            response.forEach(item => {
                                // Assuming each item in the response has properties you want to display in the table
                                let row = `<tr>`;

                                // Modify the following line based on the properties in your response objects
                                row += `<td>${item.p4}</td>`;
                                const dateString = item.p3;
                                const year = dateString.slice(0, 4);
                                const month = dateString.slice(4, 6);
                                const day = dateString.slice(6, 8);
                                const hours = dateString.slice(8, 10);
                                const minutes = dateString.slice(10, 12);
                                const seconds = dateString.slice(12, 14);

                                const date = new Date(
                                    `${year}-${month}-${day}T${hours}:${minutes}:${seconds}`
                                );
                                const formattedDate = date
                                    .toLocaleString(); // Use toLocaleString for a readable format

                                row += `<td>${formattedDate}</td>`;
                                row += `<td>${item.p5}</td>`;
                                row += `<td>${item.p6}</td>`;
                                // Add more cells as needed

                                row += `</tr>`;

                                // Append the generated row to the table
                                table += row;
                            });

                            // Close the table element
                            table += `</table>`;

                            // Set the HTML of #sammaryRespone with the generated table
                            $('#sammaryRespone').html(`<div class="row m-0">${table}</div>`);
                        }
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
                        text: "Unable to check details, try again"
                    });
                },
                complete: function() {
                    btn.html('Checked');

                }
            });

        });
    </script>
    <script>
        $(document).on('click', '#changePassword', function() {
            $(this).addClass('active');
            $('#accountSammary').removeClass('active');
            $('#paymentRetry').removeClass('active');
            $('#sammaryRespone').html('');
            $('#paymentRetryResponse').html('');
            $('#change-password-form').show();
            $(document).on('click', '#paswordChange', function() {
                let currect_password = $("#current_password").val();
                let new_password = $("#new_password").val();
                let confirm_password = $("#confirm_password").val();
                console.log(currect_password);
                $.ajax({
                    url: "{{ route('admin.eucl-service.changePassword') }}?currect_password=" +
                        currect_password + "&new_password=" +
                        new_password + "&confirm_password=" + confirm_password,
                    method: "get",
                    dataType: 'json',
                    success: function(response) {
                        if (response) {

                            if (response.messages == 'Not Found') {

                                Swal.fire({
                                    title: 'Error',
                                    text: response.messages,
                                    icon: 'error',
                                    confirmButtonText: 'Ok'
                                });
                            } else {
                                Swal.fire({
                                    title: 'Success',
                                    text: 'Password changed',
                                    icon: 'success',
                                    confirmButtonText: 'Ok'
                                });
                            }
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
                            text: "Unable to check details, try again"
                        });
                    },
                    complete: function() {

                        $("#current_password").val('');
                        $("#new_password").val('');
                        $("#confirm_password").val('');

                    }
                });
            });

        });
    </script>
    <script>
        $(function() {
            $.ajax({
                url: "{{ route('admin.eucl-service.historyApi') }}",
                method: "get",
                dataType: 'json',
                success: function(data) {
                    data.pop();
                    // console.log(data);
                    $('#kt_datatable1').DataTable({
                        data: data,
                        processing: true,
                        columns: [{
                                data: '',
                            },
                            {
                                data: 'p0',
                            },
                            {
                                data: '',
                            },
                            {
                                data: 'p4',
                            },
                            {
                                data: 'p12',
                            },
                            {
                                data: 'p14',
                            },
                        ],
                        columnDefs: [

                            {
                                targets: 0,
                                render: function(data, type, row, meta) {
                                    return meta.row + meta.settings._iDisplayStart + 1;
                                }
                            },
                            {
                                targets: 2,
                                render: function(data, type, row, meta) {
                                    return row.p9 ? row.p9 : null;
                                }
                            },
                            {
                                targets: 4,
                                render: function(data, type, row, meta) {
                                    return row.p12 ? row.p12 : null;
                                }
                            },
                            {
                                targets: 5,
                                render: function(data, type, row, meta) {
                                    return row.p14 ? row.p14 : null;
                                }
                            },
                            {
                                targets: 6,
                                render: function(data, type, row, meta) {
                                    const dateString = row.p7;
                                    const year = dateString.slice(0, 4);
                                    const month = dateString.slice(4, 6);
                                    const day = dateString.slice(6, 8);
                                    const hours = dateString.slice(8, 10);
                                    const minutes = dateString.slice(10, 12);
                                    const seconds = dateString.slice(12, 14);

                                    const date = new Date(
                                        `${year}-${month}-${day}T${hours}:${minutes}:${seconds}`
                                    );
                                    const formattedDate = date
                                        .toLocaleString(); // Use toLocaleString for a readable format
                                    return formattedDate;
                                }
                            },
                        ],
                    });
                }

            });
        });
    </script>
@endsection
