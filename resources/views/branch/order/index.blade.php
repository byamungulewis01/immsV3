@extends('layouts.admin.app')
@section('page-name')
    Branch Orders
@endsection
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Branch Orders</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS Mail</a>
                        </li>
                        <li class="breadcrumb-item active">Branch Orders</li>
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
                                <h5 class="card-title mb-0">Branch Orders List</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                    <i class="ri-delete-bin-2-line"></i>
                                </button>
                                @can('make branchorder')
                                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#showModal">
                                        <i class="ri-add-line align-bottom me-1"></i> New Order
                                    </button>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <table id="manageBrandTable" class="table nowrap table-bordered align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th class="sort" data-sort="order">ORDER CODE</th>
                                <th class="sort" data-sort="date">DATE ORDER</th>
                                <th class="sort" data-sort="total">TOTAL PRODUCT</th>
                                <th class="sort" data-sort="status">Status</th>
                                <th class="sort" data-sort="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($orders as $key => $order)
                                <tr>
                                    <td scope="row">
                                        {{ $key + 1 }}
                                    </td>
                                    <td class="order">{{ $order->regnumber }}</td>
                                    <td class="date">{{ $order->created_at }}</td>
                                    @php
                                        $total = App\Models\BranchOrder::where('regnumber', $order->regnumber)->count();
                                    @endphp
                                    <td class="total" align="center">{{ $total }}</td>
                                    <td class="status">
                                        @if ($order->status == 0)
                                            <span class="badge bg-soft-warning text-warning">Pending</span>
                                        @elseif($order->status == 1)
                                            <span class="badge bg-soft-success text-success">Approved</span>
                                        @elseif($order->status == 2)
                                            <span class="badge bg-soft-danger text-danger">Rejected</span>
                                        @endif
                                    </td>
                                    <td>
                                        @can('updates supplier')
                                            <a type="button" class="btn btn-primary btn-sm edit-supplier"
                                                data-suppliername="{{ $supplier->suppliername }}"
                                                data-tinnumber="{{ $supplier->tinnumber }}" data-phone="{{ $supplier->phone }}"
                                                data-id="{{ $supplier->id }}"
                                                data-action="{{ route('admin.supplier.update', $supplier->id) }}"
                                                data-bs-toggle="modal" data-bs-target="#updatemodal"><span>Edit</span></a>
                                        @endcan

                                        @can('read branchorder')
                                            <a type="button" href="{{ route('branch.order.view', $order->regnumber) }}"
                                                class="btn btn-success btn-sm"><span>View Order</span></a>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <!--end col-->
    </div>
    <!--end row-->

    @can('make branchorder')
        <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-md modal-simple">
                <div class="modal-content">
                    <div class="modal-header p-3">
                        <h5 class="modal-title" id="exampleModalLabel">New Branch Order</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                            id="close-modal"></button>
                    </div>

                    <form class="tablelist-form" method="post" action="{{ route('branch.order.index') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="modal-body">
                            <div class="row">
                                <div class="col-sm-12">
                                    <select type="text" class="item_id cv" id="item_id" autocomplete="off">
                                        @foreach ($items as $item)
                                            <option value="{{ $item->item_id }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
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
                            <button type="button" class="btn btn-primary btn-block" id="add-row" style="display: none;"><i
                                    class="mdi mdi-plus-circle me-2"></i> Add new Product Row</button>
                            <table class="table table-bordered " id="my-table">
                                <thead>
                                    <tr>
                                        <th style="width: 40%">
                                            Product Name
                                        </th>
                                        <th>
                                            Product Quantity
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>

                        </div>
                        <div class="modal-footer">
                            <div class="hstack gap-2 justify-content-end">
                                <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-success" id="add-btn">
                                    Make Order
                                </button>
                                <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endcan

    <div class="B" style="display: none;">
        <table id="my-table2">
            <tbody>
                <tr data-id="">
                    <td>
                        <b class="prodname"></b>
                        <input type="hidden" name="item_id[]" type="text" class="item_id cv" id="item_2"
                            autocomplete="off">
                        <input type="hidden">
                    </td>
                    <td>
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <button type="button" class="btn btn-outline-secondary quantity-minus-btn">-</button>
                                </div>
                                <input type="number" class="form-control quantity-input p_qty" name="quantity[]"
                                    oninput="calc();" min="1">
                                <div class="input-group-append">
                                    <button type="button" class="btn btn-outline-secondary quantity-plus-btn">+</button>
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <button class="btn btn-danger remove-row" type="button"><i class="fa fa-times-circle"></i>
                            X</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

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
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.13.3/js/standalone/selectize.min.js"></script>

    {{-- <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js"
        integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function() {
            // Plus button click event
            $(document).on("click", ".quantity-plus-btn", function() {
                var inputField = $(this).closest(".input-group").find(".p_qty");
                var value = parseInt(inputField.val());
                inputField.val(value + 1);
                calc();
            });

            // Minus button click event
            $(document).on("click", ".quantity-minus-btn", function() {
                var inputField = $(this).closest(".input-group").find(".p_qty");
                var value = parseInt(inputField.val());
                if (value > 0) {
                    inputField.val(value - 1);
                    calc();
                }
            });

            // Quantity input change event
            $(document).on("change", ".p_qty", function() {
                var inputField = $(this);
                var value = parseInt(inputField.val());
                if (isNaN(value) || value < 1) {
                    inputField.val(1);
                }
            });
        });
    </script>
    <script>
        $(document).ready(function() {


            var $select = $('#item_id');
            var allOptions = Array.from($select[0].options).map(function(option) {
                return {
                    value: option.value,
                    text: option.text
                };
            });

            $select.selectize({
                plugins: ['remove_button'],
                hideSelected: true,
                closeAfterSelect: true,
                // dropdownParent: ".modal-body",
                render: {
                    item: function(item, escape) {
                        return '<div class="item">' + escape(item.text) + '</div>';
                    },
                    option: function(item, escape) {
                        return '<div class="option">' + item.text + '</div>';
                    }
                },
                onInitialize: function() {
                    this.$control_input.attr('autocomplete', 'on');
                    this.clearOptions();
                    this.onSearchChange('');
                },
                onDropdownOpen: function() {
                    if (this.$control_input.val().trim() !== '') {
                        this.$control_input.focus();
                    } else {
                        this.clearOptions();
                    }
                },
                onDelete: function(values) {
                    // Handle delete event
                    this.clearOptions();
                    this.onSearchChange('');
                    this.close();
                },
                dropdownDirection: 'down',
                placeholder: 'Search For product to order...',
                allowEmptyOption: false,
                loadThrottle: 300,
                valueField: 'value',
                labelField: 'text',
                searchField: ['text'],
                create: false,
                onType: function(str) {
                    if (str.trim() === '') {
                        this.clearOptions();
                        this.close();
                    } else {
                        var filteredOptions = allOptions.filter(function(option) {
                            return option.text.toLowerCase().includes(str.toLowerCase());
                        });

                        this.clearOptions();
                        this.load(function(callback) {
                            callback(filteredOptions);
                        });
                        this.open();
                    }
                }
            });
            //detect item_id change
            $('#item_id').change(function() {
                var selectize = $select[0].selectize;
                var selectedItem = selectize.getValue();
                if (selectedItem > 0) {
                    var selectedOption = selectize.options[selectedItem];
                    // make #item_2 has the same value as #item_1
                    $('#my-table2 #item_2').val(selectedOption.value);
                    // make prodname has the same value as #item_1 selected option text
                    $('#my-table2 .prodname').html(selectedOption.text);
                    $("#add-row").click();
                    selectize.clear();
                }


            })
            // manage brand table
            manageBrandTable = $("#manageBrandTable").DataTable({
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
                ]
            });
        });

        function p_master(p_id) {
            var price = $('#price_' + p_id).val();
            var qty = $('#qty_' + p_id).val();
            var total = $('#total_' + p_id).html();
            var pd_change = $('#pd_change_' + p_id).val();
            $('#total_' + p_id).html(parseFloat(qty) * parseFloat(price));
            $('#pd_change_' + p_id).val('yes');
        }

        // $(".sellect").chosen({ no_results_text: 'Oops, nothing found!',width:   '100%' });

        function parse_receiver(selected = "") {
            var in_nm = selected + "_row";
            $('.check_row').hide();
            $('#' + in_nm).show();
        }
        $(".cv").on('input', function() {
            upd();
        });

        function upd() {
            return true
            // Add event listener to "Add Row" button
        }

        $("#add-row").click(function() {

            var item = $('#item_id').val();
            if ($('table#my-table tbody').find('tr[data-id="' + item + '"]').length > 0) {
                alert('Item is already exists on the list.', 'error');
                return false;
            }
            if (item > 0) {
                // Clone the first table row
                const newRow = $("#my-table2 tbody tr:first").attr('data-id', item).clone();
                // Reset input values in the cloned row
                // newRow.find("input").val("");
                // newRow.find("tr");
                newRow.find(".p_qty").val(1);


                // Append the new row to the table body
                $("#my-table tbody").append(newRow);
            }



            // Get all selected values from previous rows
            //   var selectedValues = [];
            //   $(".sellect").not($(this).closest('#my-table tbody tr').find('.sellect')).each(function() {
            //     $(this).find("option:selected").each(function() {
            //       selectedValues.push($(this).val());
            //     });
            //   });


        });


        // Add event listener to "Remove" button
        $(document).on("click", ".remove-row", function() {
            $(this).closest("tr").remove(); // Remove the row containing the clicked button
        });
    </script>
@endsection
