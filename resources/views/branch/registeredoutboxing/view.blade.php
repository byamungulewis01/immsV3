@extends('layouts.admin.app')
@section('page-name')Registered Small Packet Mail Outboxing @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Registered Small Packet Mail Outboxing</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS Mails</a>
                    </li>
                    <li class="breadcrumb-item active">Mails</li>
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
                            <h5 class="card-title mb-0">Registered Small Packet outboxing Edit</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                <i class="ri-delete-bin-2-line"></i>
                            </button>

                            {{-- <button type="button" class="btn btn-info">
                                    <i class="ri-file-download-line align-bottom me-1"></i>
                                    Import
                                </button> --}}
                        </div>
                    </div>
                </div>
            </div>
            <form class="tablelist-form" method="post"
                action="{{ route('branch.registeredoutboxing.update', $outbox->out_id) }}" enctype="multipart/form-data">
            <div class="card-body">
                <div class="row">

                    @csrf
                    @method('PUT')
                    <center><h4 class="modal-title" id="standard-modalLabel">SENDER INFORMATION </h4></center>
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


                      <div class="col-12">

                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">TRACKING NUMBER </label>
                          <input name="tracking"  type="text" class="form-control" id="validationCustom01" value="{{ $outbox->tracking }}" autocomplete="off" >
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">NAMES</label>
                          <input required  name="snames"  value="{{ $outbox->snames }}"  type="text" class="form-control" id="validationCustom01"   autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">MOBILE PHONE </label>
                          <input  name="sphone"  value="{{ $outbox->sphone }}"  required type="text" class="form-control" id="validationCustom01"   autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                        <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">EMAIL </label>
                          <input  name="semail"  value="{{ $outbox->semail }}"  type="email" class="form-control" id="validationCustom01"    autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">NID/PASSPORT </label>
                          <input name="snid"  value="{{ $outbox->snid }}"  type="text" class="form-control" id="validationCustom01" required   autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>

                        <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">SENDER ADDRESS </label>
                          <input name="saddress"  value="{{ $outbox->saddress }}"  type="text" class="form-control" id="validationCustom01"  required  autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                        <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="rcountry">DESTINATION COUNTRY</label>
                          <select class="form-control sellect" name="rcountry" type="text" class="" id="rcountry"  required>
                            <option value="" disabled selected>-Select Country-</option>
                            @php
                                //model of Country;
                                $countries = App\Models\Country::continent_tarif();
                            @endphp
                            @foreach ($countries as $country)
                              <option {{ ($outbox->c_id == $country['countsh']) ? "selected" : "" }} value="<?php echo $country['countsh'] ?>"><?php echo $country['countryname'] ?></option>
                            @endforeach
                          </select>
                        </div>
                      </div>
                          <label class="form-label" for="validationCustom01">RECEIVER INFORMATION</label>


                    <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">NAMES</label>
                          <input required  value="{{ $outbox->rnames }}"  name="rnames" type="text" class="form-control" id="validationCustom01"  required autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">MOBILE PHONE </label>
                          <input  name="rphone"  value="{{ $outbox->rphone }}"  type="text" class="form-control" id="validationCustom01" required   autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                        <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">EMAIL </label>
                          <input  name="remail"  value="{{ $outbox->remail }}"  type="email" class="form-control" id="validationCustom01"    autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                        <div class="col-12">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">RECEIVER ADDRESS </label>
                          <input  name="raddress"  value="{{ $outbox->raddress }}"  type="text" class="form-control" id="validationCustom01" required   autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>

                   <label class="form-label" for="validationCustom01"><b>POSTING INFORMATION </b></label>

                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label"   for="weight">WEIGHT</label>
                          <input type="number" value="{{ $outbox->weight }}" class="form-control" id="weight" name="weight"  required autocomplete="off">
                        </div>
                      </div>

                      <div class="col-4">
                        <div class="mb-3">
                          <label for="example-select" class="form-label">UNIT</label>
                          <select class="form-control" id="brandStatus"  name="unit" required readonly>
                             <option value="" selected disabled>Select  Weigth Unit</option>
                            <!-- <option  value="Kg" >Kg</option> -->
                            <option selected value="g">Gram</option>
                          </select>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="amount">POSTAGE AMOUNT/FRW</label>
                          <input type="number" value="{{ $outbox->amount }}" class="form-control" id="amount" name="amount"  required autocomplete="off">
                          <i class="green-text">Requesting <span class="dot-1">.</span><span class="dot-2">.</span><span class="dot-3">.</span></i>
                        </div>
                      </div>
                        <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="tax">TAX/FRW</label>
                          <input type="number" class="form-control" id="tax" name="tax" value="{{ $outbox->tax }}" required autocomplete="off">
                          <!-- <span class="animated-text">Hello dear</span> -->
                          <i class="green-text">Requesting <span class="dot-1">.</span><span class="dot-2">.</span><span class="dot-3">.</span></i>

                        </div>
                      </div>
                                    <div class="col-4">
                                          <div class="mb-3">
                              <label for="item_id" class="form-label">CARTON/ENVELOP/FRW</label>
                              <select class="form-control sellect" id="item_id" name='item_id' required>

                                  <option selected value="" disabled>Select Product</option>
                                @foreach ($items as $item)
                                @php
                                $itemm_1 = App\Models\Item::with('category_info')->find($item['item_id']);
                                $cate = $itemm_1->category_info->categoryname;
                                //transform category to lower case
                                $cate = strtolower($cate);
                                if (trim($cate) != 'carton') {
                                    continue;
                                }
                                @endphp
                                  <option {{ ($outbox->item_id == $item['item_id']) ? "selected" : "" }} price="{{ $item['sellingprice'] }}" value="{{ $item['item_id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                              </select>
                          </div>

                      </div>
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="prrice">CARTON AMOUNT/FRW</label>
                          <input type="number" value="{{ $outbox->postage }}" class="form-control" name="postage" id="prrice" required autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                      <div class="col-12">
                        <div class="mb-3">
                          <label class="form-label" for="total_amount_full">TOTAL AMOUNT PAY(Frw)</label>
                          <input type="text" class="form-control" id="total_amount_full"readonly>
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                        <div class="col-6">
                            <div class="mb-3">
                            <label class="form-label" for="validationCustom01">PAYEMENT MODE</label>
                            <select name="ptype" class="form-control"  required >
                            <option {{ ($outbox->ptype == "") ? "selected" : "cash" }} value="cash" selected>Cash</option>
                            <option {{ ($outbox->ptype == "") ? "selected" : "momo" }} value="momo">Momo</option>
                            <option {{ ($outbox->ptype == "") ? "selected" : "pos" }} value="pos">Pos</option>
                            </select>
                            </div>
                            </div>

                            {{-- <div class="col-6">
                            <div class="mb-3">
                                <label class="form-label" for="validationCustom01">PAYEMENT REFERENCE</label>
                                <input type="text" class="form-control" name="reference" autocomplete="off">
                                <div class="valid-feedback">
                                    Looks good!
                                </div>
                            </div>
                            </div> --}}
                    </div>
            </div>
            <div class="card-footer">
                <div class="hstack gap-2 justify-content-end">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" id="createBrandBtn" data-loading-text="Loading..." autocomplete="off">Save</button>
                    <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                </div>
            </div>
            </form>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

@can ('make outboxing')

<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="exampleModalLabel">Registered Small Packet Mail Outboxing Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close" id="close-modal"></button>
            </div>
        </div>
    </div>
</div>
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
        service: "get_continent_price",
        token: "INSIDER",
        country_code: country_code,
        servty_id: "2",
        weight_type: "g",
        qty: weight
        };

        // Get the current directory URL
        var current_directory = window.location.href.substring(0, window.location.href.lastIndexOf("/")) + "/";

        // Send the AJAX request to the API
        $.ajax({
          url: '{{ route('price.getContinentPrice') }}',
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
        tt_walk();
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
