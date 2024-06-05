@extends('layouts.admin.app')
@section('page-name')Update Selling Carte Postel @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Update Selling Carte Postel</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS Mails</a>
                    </li>
                    <li class="breadcrumb-item active">Update Selling Carte Postel</li>
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
                            <h5 class="card-title mb-0">Update Selling Carte Postel</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                <i class="ri-delete-bin-2-line"></i>
                            </button>
                            @can('make branchorder')
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                                data-bs-target="#showModal">
                                <i class="ri-add-line align-bottom me-1"></i> New Sell
                            </button>

                            @endcan

                            {{-- <button type="button" class="btn btn-info">
                                    <i class="ri-file-download-line align-bottom me-1"></i>
                                    Import
                                </button> --}}
                        </div>
                    </div>
                </div>
            </div>
            <form class="tablelist-form" method="post"
            action="{{ route('branch.sellingpostel.update',$outbox->out_id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body p-3">
                <div class="row">


                    <center><h4 class="modal-title" id="standard-modalLabel">CUSTOMER INFORMATION</h4></center>



                      <div class="col-12">

                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">Full Name</label>
                          <input name="snames"  type="text" class="form-control" id="validationCustom01" value="{{ $outbox->snames }}" autocomplete="off" >
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>

                      <div class="col-6">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">MOBILE PHONE </label>
                          <input  name="sphone"  required type="text" class="form-control"  value="{{ $outbox->sphone }}"  id="validationCustom01"   autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>


                      <div class="col-6">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">CUSTOMER ADDRESS</label>
                          <input name="saddress" type="text" class="form-control" id="validationCustom01" required   value="{{ $outbox->saddress }}"  autocomplete="off">
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
                                        $itemm_1 = App\Models\Item::with('category_info')->find($item['item_id']);
                                        $cate = $itemm_1->category_info->categoryname;
                                        //transform category to lower case
                                        $cate = strtolower($cate);
                                        if (trim($cate) != 'postel') {
                                            continue;
                                        }
                                      @endphp
                                  <option price="{{ $item['sellingprice'] }}" value="{{ $item['item_id'] }}" {{ ($outbox->item_id == $item['item_id']) ? "selected" : "" }}>{{ $item['name'] }}</option>
                                @endforeach
                              </select>
                          </div>

                      </div>
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">QUANTITY</label>
                          <input name="qty" type="text" class="form-control" id="qty"  required  autocomplete="off"  value="{{ $outbox->qty }}"  oninput="walk_on();">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>




                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="prrice">AMOUNT per unit</label>
                          <input type="number" class="form-control" name="postage" id="prrice" required autocomplete="off"  value="{{ $outbox->amount/$outbox->qty }}"  oninput="walk_on();">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="mb-3">
                          <label class="form-label" for="prrice">Total Amount To Pay</label>
                          <input type="number" class="form-control" name="amount" id="tot" required  value="{{ $outbox->amount }}"  autocomplete="off" readonly>
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>


                            <div class="col-6">
<div class="mb-3">
<label class="form-label" for="validationCustom01">PAYEMENT MODE</label>
<select name="ptype" class="form-control"  required >
                        <option value="cash" {{ ($outbox->ptype == "cash") ? "selected" : "" }}>Cash</option>
                        <option value="momo" {{ ($outbox->ptype == "momo") ? "selected" : "" }}>Momo</option>
                         <option value="pos" {{ ($outbox->pos == "cash") ? "selected" : "" }}>Pos</option>
</select>
</div>
</div>

                    </div>
            </div>
            <div class="card-footer">
                <div class="hstack gap-2 justify-content-end">
                    <a href="{{ url()->previous() }}" type="button" class="btn btn-light">Back</a>
                    <button type="submit" class="btn btn-primary" id="createBrandBtn" data-loading-text="Loading..." autocomplete="off">Save Changes</button>
                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                </div>
            </div>
        </form>

        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

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
      $(".sellect").chosen({ width:   '100%' });
    </script>
    <script>

    $('#amount').attr("readonly",true);
    $('#tax').attr("readonly",true);
    $('#prrice').attr("readonly",true);
    $(document).ready(function() {
      // When the user types something in the weight input field
      $("#weight,#rcountry").on("input", function() {
      // empty fields to store result before typing there
      $('#amount').val('').attr("readonly",true);
      $('#tax').val('').attr("readonly",true);
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
        var current_directory = window.location.href.substring(0, window.location.href.lastIndexOf("/")) + "/";

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
              $('#amount').val('').attr("readonly",false);
              $('#tax').val('').attr("readonly",false);
              // Update the amount and tax input fields with the calculated values
              $("#amount").val(amount.toFixed(2)).attr("readonly",true);
              $("#tax").val(tax.toFixed(2)).attr("readonly",true);
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
    $('#item_id').change(function(){

        $('#prrice').attr("readonly",false);
        $('#prrice').val(0);
        // var p = $(this).val();
        //alert(p);
        var b = $('#item_id');
        var get_op = b.find('option:selected');
        var sel_op = get_op.attr('price');
        // alert(sel_op);
        $("#prrice").val(sel_op).attr("readonly",true);
        tt_walk();


    });
    function walk_on() {
  var a = parseFloat($("#qty").val());
  var b = parseFloat($("#prrice").val());
  var c = parseFloat(a*b);
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
      var walk = price+amount;
      // now add price and amount and store in total price input field
      $("#total_amount_full").val(walk.toFixed(2));

    }

        </script>
        <script>
      $(document).ready(function () {

        // top bar active

        // manage brand table
        var rep_tbl = $("#manageBrandTable").DataTable({
    // 'processing': true,
    // 'serverSide': true,
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
    ],
    "drawCallback": function(settings) {
        var api = this.api();

        // get the column data
        var amountData = api.column(6, { search: 'applied' }).data();
        var taxData = api.column(7, { search: 'applied' }).data();
        var cartonData = api.column(8, { search: 'applied' }).data();
        var totalData = api.column(9, { search: 'applied' }).data();

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

        $("#amount_rep").html(amount_rep.toLocaleString('en-RW', { style: 'currency', currency: 'Frw' }));
        $("#tax_rep").html(tax_rep.toLocaleString('en-RW', { style: 'currency', currency: 'Frw' }));
        $("#carton_rep").html(carton_rep.toLocaleString('en-RW', { style: 'currency', currency: 'Frw' }));
        $("#total_rep").html(total_rep.toLocaleString('en-RW', { style: 'currency', currency: 'Frw' }));
    }
});

      });
    </script>
@endsection
