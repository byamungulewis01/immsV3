@extends('layouts.admin.app')
@section('page-name')Branch Orders @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Branch Orders</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS MAIL</a>
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
                            @can('make branchorder-')
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                                data-bs-target="#showModal">
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
                            <th class="sort" data-sort="branch">BRANCH</th>
                            <th class="sort" data-sort="employee">EMPLOYEE</th>
                            <th class="sort" data-sort="status">STATUS</th>
                            <th class="sort" data-sort="action">ACTION</th>
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
                            <td>{{ $order->branch->name }}</td>
                            <td>{{ $order->user->name }}</td>
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
                                        data-suppliername="{{ $supplier->suppliername }}" data-tinnumber="{{ $supplier->tinnumber }}"
                                        data-phone="{{ $supplier->phone }}"
                                        data-id="{{ $supplier->id }}"
                                        data-action="{{ route('admin.supplier.update',$supplier->id) }}"
                                        data-bs-toggle="modal" data-bs-target="#updatemodal"
                                        ><span>Edit</span></a>
                                @endcan

                                @can('read branchorder')
                                <a type="button" href="{{ route('branch.order.view',$order->regnumber) }}"
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

@can ('make branchorder')

<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="exampleModalLabel">New Branch Order</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" method="post"
                action="{{ route('branch.order.index') }}" enctype="multipart/form-data">
                @csrf
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
                    <button type="button" class="btn btn-primary btn-block" id="add-row"><i class="mdi mdi-plus-circle me-2"></i> Add new Product Row</button>
                    <table class="table table-bordered " id="my-table">
                        <thead>
                        <tr>
                            <th>
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
                        <tr>
                            <td>

                                <select required name="item_id[]" type="text" class="item_id cv sellect" id="" onchange="upd();"
                                        autocomplete="off">
                                    <option value="">Select Product</option>
                                    @php
                                        $products = App\Models\main_stock_balance::main_stock_balance(array(),'available');
                                    @endphp
                                    @foreach ($products as $prod)

                                        <option value="{{ $prod['item_id'] }}">{{ $prod['name'] }}</option>
                                    @endforeach
                                </select>
                            </td>
                            <td>
                                <input required name="quantity[]" type="text" class="form-control cv p_qty"
                                       autocomplete="off" value="0" oninput="upd();">
                            </td>
                            <td>
                                <button class="btn btn-danger remove-row" type="button"><i class="fa fa-times-circle"></i> X</button>
                            </td>
                        </tr>
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
        <tbody >
            <tr>
                <td>

                    <select required name="item_id[]" type="text" class="item_id cv" id="" onchange="upd();"autocomplete="off">
                        <option value="">Select Product</option>
                        @php
                            $products = App\Models\main_stock_balance::main_stock_balance(array(),'available');
                        @endphp
                        @foreach ($products as $prod)

                            <option value="{{ $prod['item_id'] }}">{{ $prod['name'] }}</option>
                        @endforeach
                    </select>
                </td>
                <td>
                    <input required name="quantity[]" type="text" class="form-control cv p_qty"
                           autocomplete="off" value="0" oninput="upd();">
                </td>
                <td>
                    <button class="btn btn-danger remove-row" type="button"><i class="fa fa-times-circle"></i> X</button>
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
@if($errors->any())
<script>
    var myModal = new bootstrap.Modal(document.getElementById('showModal'), {
        keyboard: false
    })
    myModal.show()

</script>
@endif
<script>
    $(document).ready(function () {
        $(".phoneNumber").on("input", function () {
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.jquery.min.js" integrity="sha512-rMGGF4wg1R73ehtnxXBt5mbUfN9JUJwbk21KMlnLZDJh7BkPmeovBuddZCENJddHYYMkCh9hPFnPmS9sspki8g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
<script>
    $(document).ready(function () {

        // manage brand table
        manageBrandTable = $("#manageBrandTable").DataTable({
            'order': [],
            'dom': 'Bfrtip',
        buttons: [
            {
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
        var price = $('#price_'+p_id).val();
        var qty = $('#qty_'+p_id).val();
        var total = $('#total_'+p_id).html();
        var pd_change = $('#pd_change_'+p_id).val();
        $('#total_'+p_id).html(parseFloat(qty)*parseFloat(price));
        $('#pd_change_'+p_id).val('yes');
    }
    $(".sellect").chosen({ no_results_text: 'Oops, nothing found!',width:   '100%' });

    function parse_receiver(selected="") {
        var in_nm = selected+"_row";
        $('.check_row').hide();
        $('#'+in_nm).show();
    }
    $(".cv").on('input', function() { upd(); });
    function upd (){

        $('#my-table tbody tr').each(function() {
            var in2 = $(this).find('.p_name');
            var prod_in = in2.find('option:selected');
            var price_pro = prod_in.attr('data-price');
            // alert(price_pro);

            var prod_out = in2.find('option:selected');
            var rem_qty = prod_out.attr('data-remaining');
            $(this).find('.rem_balance').attr('readonly',false);
            $(this).find('.rem_balance').val(rem_qty);
            $(this).find('.rem_balance').attr('readonly',true);

            $(this).find('.p_price').attr('readonly',false);
            $(this).find('.p_price').val(price_pro);
            $(this).find('.p_price').attr('readonly',true);

            var input1 = $(this).find('.p_price');
            var input2 = $(this).find('.p_qty');

            input2.attr("maxlength",rem_qty);

            if (parseFloat(input2.val()) > parseFloat(input2.attr("maxlength"))) {
                input2.val(0);
            }
            var total = $(this).find('.total_save');

            input1.add(input2).on('input', function() {
                var sum = parseFloat(input1.val()) * parseFloat(input2.val());

                total.val(sum);
            });
        });
        // Add event listener to "Add Row" button
    }

    $("#add-row").click(function() {


    var lastSelect = $("#my-table tbody tr:last").find(".sellect:last");
    if (lastSelect.val() == "") {
      alert("Please fill out the last input before adding a new row.");
      return;
    }
        // Clone the first table row
        const newRow = $("#my-table2 tbody tr:first").clone();
        // Reset input values in the cloned row
        newRow.find("input").val("");
          newRow.find("select").val("");
        newRow.find("select").addClass("sellect")
         // Initialize Chosen select boxes in the new row
        newRow.find(".sellect").chosen({ no_results_text: 'Oops, nothing found!',width:   '100%' });


        // Append the new row to the table body
        $("#my-table tbody").append(newRow);




  // Get all selected values from previous rows
  var selectedValues = [];
  $(".sellect").not($(this).closest('#my-table tbody tr').find('.sellect')).each(function() {
    $(this).find("option:selected").each(function() {
      selectedValues.push($(this).val());
    });
  });

  // Remove all options from the dropdown menu that have already been selected in other select boxes
  $(".sellect:last").on("chosen:showing_dropdown", function() {
    $(this).find("option").each(function() {
      if (selectedValues.includes($(this).val())) {
        $(this).remove();
      }
    });
    $(this).trigger("chosen:updated");
  });

  // Remove all selected options from the cloned select box
  $(".sellect:last").val('').trigger('chosen:updated');

  // Reinitialize the Chosen select boxes on the new row
  $(".sellect").chosen({ no_results_text: 'Oops, nothing found!',width:   '100%' });


  // When a Chosen select option is changed
  $('.sellect').on('change', function() {
    var selectedValue = $(this).val();
    // Loop through all other select elements
    $('.sellect').not(this).each(function() {
      // Remove the selected option from their list of options
      $(this).find('option[value="' + selectedValue + '"]').remove();
      // Update Chosen to reflect the change in options
      $(this).trigger('chosen:updated');
    });
  });

    });


    // Add event listener to "Remove" button
    $(document).on("click", ".remove-row", function() {
        $(this).closest("tr").remove(); // Remove the row containing the clicked button
    });
</script>
@endsection
