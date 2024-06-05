@extends('layouts.admin.app')
@section('page-name')
    Selling Carte Postel
@endsection
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Selling Carte Postel</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS Mails</a>
                        </li>
                        <li class="breadcrumb-item active">Selling Carte Postel</li>
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
                                <h5 class="card-title mb-0">Selling Carte Postel List</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                    <i class="ri-delete-bin-2-line"></i>
                                </button>
                                @can('make branchorder')
                                    {{-- <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#showModal">
                                        <i class="ri-add-line align-bottom me-1"></i> New Sell
                                    </button> --}}
                                    <a href="{{ route('branch.sellingpostel.create') }}" class="btn btn-success add-btn">
                                        <i class="ri-add-line align-bottom me-1"></i> New Sell
                                    </a>
                                @endcan

                                {{-- <button type="button" class="btn btn-info">
                                    <i class="ri-file-download-line align-bottom me-1"></i>
                                    Import
                                </button> --}}
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="manageBrandTable" class="table nowrap table-bordered align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th class="sort" data-sort="reg_date">DATE PURCHASE</th>
                                <th class="sort" data-sort="snames">FULL NAME</th>
                                <th class="sort" data-sort="phone">PHONE</th>
                                <th class="sort" data-sort="amount">TOTAL</th>
                                <th class="sort" data-sort="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($outboxings as $key => $outbox)
                                <tr>
                                    <td scope="row">
                                        {{ $key + 1 }}
                                    </td>
                                    <td>{{ $outbox->created_at }}</td>
                                    <td>{{ $outbox->name }}</td>
                                    <td>{{ $outbox->phone }}</td>
                                    <td>{{ $outbox->amount }}</td>
                                    <td>
                                        @can('make outboxing')
                                            <a type="button" href="{{ route('branch.sellingpostel.edit', $outbox->out_id) }}"
                                                class="btn btn-success btn-sm"><span>View / Edit</span></a>
                                        @endcan
                                        @can('make outboxing')
                                            <a href="#deleteRecordModal" data-bs-toggle="modal" type="button"
                                                data-action="{{ route('branch.sellingpostel.destroy', $outbox->out_id) }}"
                                                class="btn btn-danger btn-sm delete-item"><span>Delete</span></a>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        {{-- <tfoot>
                      <th colspan="6">
                        Today's Income
                      </th>
                      <th id="amount_rep"></th>
                      <th id="tax_rep"></th>
                      <th id="carton_rep"></th>
                      <th id="total_rep"></th>
                    </tfoot> --}}
                    </table>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->

    <!-- Modal -->
    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="btn-close" id="deleteRecord-close" data-bs-dismiss="modal"
                        aria-label="Close" id="btn-close"></button>
                </div>
                <div class="modal-body">
                    <form id="deleteitem" method="post" action="#">
                        @csrf
                        @method('DELETE')
                        <div class="mt-2 text-center">
                            <lord-icon src="https://cdn.lordicon.com/gsqxdxog.json" trigger="loop"
                                colors="primary:#f7b84b,secondary:#f06548"
                                style="width: 100px; height: 100px"></lord-icon>
                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                <h4>Are you sure ?</h4>
                                <p class="text-muted mx-4 mb-0">
                                    Are you sure you want to remove this record ?
                                </p>
                            </div>
                        </div>
                        <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                            <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn w-sm btn-danger" id="delete-record">
                                Yes, Delete It!
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--end modal -->
    @can('make outboxing')
        <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog  modal-xl">
                <div class="modal-content">
                    <div class="modal-header p-3">
                        <h5 class="modal-title" id="exampleModalLabel">Selling Carte Postel Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                    </div>
                    <form class="tablelist-form" method="post" action="{{ route('branch.sellingpostel.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">

                        </div>
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="createBrandBtn"
                                    data-loading-text="Loading..." autocomplete="off">Save Changes</button>
                                <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        {{-- <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog  modal-xl">
                <div class="modal-content">
                    <div class="modal-header p-3">
                        <h5 class="modal-title" id="exampleModalLabel">Selling Carte Postel Form</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                    </div>
                    <form class="tablelist-form" method="post" action="{{ route('branch.sellingpostel.store') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">


                                <center>
                                    <h4 class="modal-title" id="standard-modalLabel">CUSTOMER INFORMATION</h4>
                                </center>



                                <div class="col-12">

                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom01">Full Name</label>
                                        <input name="snames" type="text" class="form-control" id="validationCustom01"
                                            autocomplete="off">
                                        <div class="valid-feedback"> ok </div>
                                    </div>
                                </div>

                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom01">MOBILE PHONE </label>
                                        <input name="sphone" required type="text" class="form-control"
                                            id="validationCustom01" autocomplete="off">
                                        <div class="valid-feedback"> ok </div>
                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom01">CUSTOMER ADDRESS</label>
                                        <input name="saddress" type="text" class="form-control" id="validationCustom01"
                                            required autocomplete="off">
                                        <div class="valid-feedback"> ok </div>
                                    </div>
                                </div>

                                <label class="form-label" for="validationCustom01"><b>PRODUCT INFORMATION</b></label>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label for="item_id" class="form-label">SELECT CARTE POSTEL</label>
                                        <select class="form-control sellect" id="item_id" name='item_id' required>

                                            <option selected value="" disabled>Select Product</option>
                                            @foreach ($items as $item)
                                                @php
                                                    $itemm_1 = App\Models\Item::with('category_info')->find(
                                                        $item['item_id'],
                                                    );
                                                    $cate = $itemm_1->category_info->categoryname;
                                                    //transform category to lower case
                                                    $cate = strtolower($cate);
                                                    if (trim($cate) != 'postel') {
                                                        continue;
                                                    }
                                                @endphp
                                                <option price="{{ $item['sellingprice'] }}" value="{{ $item['item_id'] }}">
                                                    {{ $item['name'] }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom01">QUANTITY</label>
                                        <input name="qty" type="text" class="form-control" id="qty" required
                                            autocomplete="off" oninput="walk_on();">
                                        <div class="valid-feedback"> ok </div>
                                    </div>
                                </div>




                                <div class="col-4">
                                    <div class="mb-3">
                                        <label class="form-label" for="prrice">AMOUNT per unit</label>
                                        <input type="number" class="form-control" name="postage" id="prrice" required
                                            autocomplete="off" oninput="walk_on();">
                                        <div class="valid-feedback"> ok </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label class="form-label" for="prrice">Total Amount To Pay</label>
                                        <input type="number" class="form-control" name="amount" id="tot" required
                                            autocomplete="off" readonly>
                                        <div class="valid-feedback"> ok </div>
                                    </div>
                                </div>


                                <div class="col-6">
                                    <div class="mb-3">
                                        <label class="form-label" for="validationCustom01">PAYEMENT MODE</label>
                                        <select name="ptype" class="form-control" required>
                                            <option value="cash" selected>Cash</option>
                                            <option value="momo">Momo</option>
                                            <option value="pos">Pos</option>
                                        </select>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn btn-primary" id="createBrandBtn"
                                    data-loading-text="Loading..." autocomplete="off">Save Changes</button>
                                <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div> --}}
    @endcan
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

    {{-- <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"
        integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <style type="text/css">
        .green-text {
            display: none;
            color: green;
            animation: blink 1.5s infinite;
        }

        @keyframes blink {
            50% {
                opacity: 0;
            }
        }

        .dot-1,
        .dot-2,
        .dot-3 {
            animation: loading 1.5s infinite;
            opacity: 0;
        }

        .dot-2 {
            animation-delay: 0.5s;
        }

        .dot-3 {
            animation-delay: 1s;
        }

        @keyframes loading {
            0% {
                opacity: 0;
            }

            25% {
                opacity: 0.3;
            }

            50% {
                opacity: 0.6;
            }

            75% {
                opacity: 0.3;
            }

            100% {
                opacity: 0;
            }
        }
    </style>
    <script type="text/javascript">
        $(".sellect").chosen({
            width: '100%'
        });
    </script>
    <script>
        $('#amount').val('').attr("readonly", true);
        $('#tax').val('').attr("readonly", true);
        $('#prrice').val('').attr("readonly", true);
        $(document).ready(function() {
            $(document).on('click', '.delete-item', function() {
                // var itemid = $(this).data('itemid');
                var formaction = $(this).data('action');
                $('#deleteitem').attr('action', formaction);
                // $('#itemid').val(itemid);
            });
            // When the user types something in the weight input field
            $("#weight,#rcountry").on("input", function() {
                // empty fields to store result before typing there
                $('#amount').val('').attr("readonly", true);
                $('#tax').val('').attr("readonly", true);
                // Get the weight value from the input field
                var weight = $("#weight").val();

                // Get the country code value from the select box
                var country_code = $("#rcountry").val();
                // alert(country_code);
                if ($("#weight").val() && $("#rcountry").val()) {
                    // Set the AJAX parameters
                    var params = {
                        service: "get_price",
                        token: "INSIDER",
                        country_code: country_code,
                        servty_id: "1",
                        weight_type: "g",
                        qty: weight
                    };

                    // Get the current directory URL
                    var current_directory = window.location.href.substring(0, window.location.href
                        .lastIndexOf("/")) + "/";

                    // Send the AJAX request to the API
                    $.ajax({
                        url: '{{ route('price.getPrice') }}',
                        type: "POST",
                        data: params,
                        dataType: "json",
                        beforeSend: function() {
                            // Show the loading icon
                            $(".green-text").show();
                        },
                        success: function(response) {
                            // Check if the response status is success
                            if (response.status == "success") {
                                // Get the amount from the response and calculate the tax
                                // var amount = response.amount_unit * weight;
                                var amount = response.amount_unit * 1;
                                var tax = amount * 0.18;
                                $('#amount').val('').attr("readonly", false);
                                $('#tax').val('').attr("readonly", false);
                                // Update the amount and tax input fields with the calculated values
                                $("#amount").val(amount.toFixed(2)).attr("readonly", true);
                                $("#tax").val(tax.toFixed(2)).attr("readonly", true);
                                tt_walk();
                            } else {
                                // Notify the user that no results were found
                                // alert("No results found.");
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            // Show the error message
                            // alert("Error: " + errorThrown);
                            $(".green-text").hide();
                        },
                        complete: function() {
                            $(".green-text").hide();
                            // Remove the loading icon
                            // $(".loading-icon").remove();
                        }
                    });
                }
            });
        });
        $('#item_id').change(function() {

            $('#prrice').attr("readonly", false);
            $('#prrice').val(0);
            // var p = $(this).val();
            //alert(p);
            var b = $('#item_id');
            var get_op = b.find('option:selected');
            var sel_op = get_op.attr('price');
            // alert(sel_op);
            $("#prrice").val(sel_op).attr("readonly", true);
            tt_walk();


        });

        function walk_on() {
            var a = parseFloat($("#qty").val());
            var b = parseFloat($("#prrice").val());
            var c = parseFloat(a * b);
            $("#tot").val(c);

        }

        function tt_walk() {
            var price = parseFloat($("#prrice").val());
            var amount = parseFloat($("#amount").val());
            // check if the value is a number
            if (isNaN(parseFloat($("#prrice").val()))) {
                price = 0;
            }
            // check if the value is a number
            if (isNaN(parseFloat($("#amount").val()))) {
                amount = 0;
            }
            var walk = price + amount;
            // now add price and amount and store in total price input field
            $("#total_amount_full").val(walk.toFixed(2));

        }
    </script>
    <script>
        $(document).ready(function() {

            // top bar active

            // manage brand table
            var rep_tbl = $("#manageBrandTable").DataTable({
                // 'processing': true,
                // 'serverSide': true,
                'order': [],

                'dom': 'Bfrtip',
                buttons: [{
                        extend: 'print',
                        customize: function(win) {
                            $(win.document.body).find('table').addClass('print-table');
                            $(win.document.body).find('table tr td:last-child').remove();
                            $(win.document.body).find('table tr th:last-child').remove();
                        }
                    },
                    {
                        extend: 'csv',
                        customize: function(csv) {
                            // remove last column from CSV output
                            return csv.replace(/,[^\n]*\n/g, '\n');
                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ],
                "drawCallback": function(settings) {
                    var api = this.api();

                    // get the column data
                    var amountData = api.column(6, {
                        search: 'applied'
                    }).data();
                    var taxData = api.column(7, {
                        search: 'applied'
                    }).data();
                    var cartonData = api.column(8, {
                        search: 'applied'
                    }).data();
                    var totalData = api.column(9, {
                        search: 'applied'
                    }).data();

                    // calculate the sum using reduce method
                    var amount_rep = amountData.reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                    var tax_rep = taxData.reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                    var carton_rep = cartonData.reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                    var total_rep = totalData.reduce(function(a, b) {
                        return parseFloat(a) + parseFloat(b);
                    }, 0);

                    $("#amount_rep").html(amount_rep.toLocaleString('en-RW', {
                        style: 'currency',
                        currency: 'Frw'
                    }));
                    $("#tax_rep").html(tax_rep.toLocaleString('en-RW', {
                        style: 'currency',
                        currency: 'Frw'
                    }));
                    $("#carton_rep").html(carton_rep.toLocaleString('en-RW', {
                        style: 'currency',
                        currency: 'Frw'
                    }));
                    $("#total_rep").html(total_rep.toLocaleString('en-RW', {
                        style: 'currency',
                        currency: 'Frw'
                    }));
                }
            });

        });
    </script>


    <script>
        $(document).ready(function() {
            // Fetch trainings from backend
            $.ajax({
                url: "{{ route('branch.outboxing.items') }}",
                method: 'GET',
                success: function(items) {
                    // Populate dropdown list with product options
                    items.forEach(item => {
                        $('#items').append(
                            `<option value="${item.item_id}" price="${item.sellingprice}">${item.name}</option>`
                        );
                    });
                }
            });

            $('#items').change(function() {
                var selectedOption = $(this).find('option:selected');
                var itemId = $(this).val();
                var itemName = selectedOption.text();
                var price = selectedOption.attr('price');

                // Check if the product is already in the table
                if ($('#itemsTable tr[data-id="' + itemId + '"]').length > 0) {
                    alert(itemName + 'Item already added!');
                    return;
                }

                // Add selected product to the table
                var rowCount = $('#itemsTable tbody tr').length + 1;
                $('#itemsTable tbody').append(`
        <tr data-id="${itemId}">
            <td>${rowCount}</td>
            <td> <strong>${itemName}</strong> <input type="hidden" value="${itemId}" name="items[]"/></td>
            <td><input type="number" min="1" name="quantity[]" value="1" class="form-control bg-light border-0 quantity" required> </td>
            <td><input type="number" name="unitprice[]" value="${price}" class="form-control bg-light border-0" readonly required> </td>
            <td><input type="number" name="amount[]" class="form-control bg-light border-0 amount" required> </td>
            <td><button type="button" class="btn btn-sm btn-danger removeBtn">Remove</button></td>
        </tr>`);

                // Calculate and set the amount
                calculateAmount();
            });

            // Function to calculate the amount and total
            function calculateAmount() {
                var totalAmount = 0;
                $('#itemsTable tbody tr').each(function(index) {
                    var quantity = parseFloat($(this).find('.quantity').val());
                    var unitPrice = parseFloat($(this).find('input[name="unitprice[]"]').val());
                    var amount = quantity * unitPrice;
                    $(this).find('.amount').val(amount.toFixed(2));
                    $(this).find('td:first').text(index + 1); // Update the row count
                    totalAmount += amount;
                });
                $('#totalFooterAmount').text(totalAmount.toFixed(2));
            }

            // Handle input event on quantity fields
            $(document).on('input', '.quantity', function() {
                calculateAmount(); // Recalculate amounts when quantity changes
            });

            // Handle removing items from the table
            $(document).on('click', '.removeBtn', function() {
                $(this).closest('tr').remove();
                calculateAmount(); // Recalculate amounts after removal
            });

        });
    </script>
@endsection
