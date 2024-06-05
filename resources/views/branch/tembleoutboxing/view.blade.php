@extends('layouts.admin.app')
@section('page-name')Posting With Temble @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Posting With Temble</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS Mails</a>
                    </li>
                    <li class="breadcrumb-item active">Posting With Temble</li>
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
                            <h5 class="card-title mb-0">POSTING WITH TEMBLE List</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                <i class="ri-delete-bin-2-line"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <form class="tablelist-form" method="post"
            action="{{ route('branch.tembleoutboxing.update',$outbox->out_id) }}" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
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

                    <center><h4 class="modal-title" id="standard-modalLabel">SENDER INFORMATION </h4></center>



                      <div class="col-12">

                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">TRACKING NUMBER </label>
                          <input name="tracking" value="{{ $outbox->tracking }}" type="text" class="form-control" id="validationCustom01"  autocomplete="off" >
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">NAMES</label>
                          <input required value="{{ $outbox->snames }}" name="snames" type="text" class="form-control" id="validationCustom01"   autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">MOBILE PHONE </label>
                          <input  name="sphone" value="{{ $outbox->sphone }}" required type="text" class="form-control" id="validationCustom01"   autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                        <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">EMAIL </label>
                          <input  name="semail" value="{{ $outbox->semail }}" type="email" class="form-control" id="validationCustom01"    autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">NID/PASSPORT </label>
                          <input name="snid" value="{{ $outbox->snid }}" type="text" class="form-control" id="validationCustom01" required   autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>

                        <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">SENDER ADDRESS </label>
                          <input name="saddress" value="{{ $outbox->saddress }}" type="text" class="form-control" id="validationCustom01"  required  autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                        <div class="col-4">
                            <div class="mb-3">
                                <label class="form-label" for="rcountry">DESTINATION COUNTRY</label>
                                <input type="text" value="{{ $outbox->c_id }}" class="form-control" name="rcountry" type="text" placeholder="country" id="rcountry"  required>
                              </div>
                      </div>
                          <label class="form-label" for="validationCustom01">RECEIVER INFORMATION</label>


                    <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">NAMES</label>
                          <input required  name="rnames" type="text" class="form-control" value="{{ $outbox->rnames }}" id="validationCustom01"  required autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">MOBILE PHONE </label>
                          <input  name="rphone" value="{{ $outbox->rphone }}" type="text" class="form-control" id="validationCustom01" required   autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                        <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">EMAIL </label>
                          <input  name="remail" value="{{ $outbox->remail }}" type="email" class="form-control" id="validationCustom01"    autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>
                        <div class="col-12">
                        <div class="mb-3">
                          <label class="form-label" for="validationCustom01">RECEIVER ADDRESS </label>
                          <input  name="raddress" value="{{ $outbox->raddress }}" type="text" class="form-control" id="validationCustom01" required   autocomplete="off">
                          <div class="valid-feedback"> ok </div>
                        </div>
                      </div>

                   <label class="form-label" for="validationCustom01"><b>POSTING INFORMATION </b></label>

                      <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="weight">WEIGHT</label>
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
                          <input type="number" value="{{ $outbox->amount }}" class="form-control" id="amount" name="amount" oninput="tax_walk();" required autocomplete="off">
                          <i class="green-text">Requesting <span class="dot-1">.</span><span class="dot-2">.</span><span class="dot-3">.</span></i>
                        </div>
                      </div>
                        <div class="col-4">
                        <div class="mb-3">
                          <label class="form-label" for="tax">TAX/FRW</label>
                          <input type="number" value="{{ $outbox->tax }}" class="form-control" id="tax" name="tax"  required autocomplete="off">
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
                                  <option {{ ($outbox->item_id == $item['item_id']) ? "selected" : "" }} price="{{ $item['sellingprice'] }}" value="{{ $item['item_id'] }}">{{ $item['name'] }}</option>
                                @endforeach
                              </select>
                          </div>

                      </div>
                      <div class="col-4">
                        <div class="mb-3">
            <label for="item_id" class="form-label">SELECT TEMBLE</label>
            <select class="form-control sellect" id="item_id_2" name='item_id_2' required>

                <option selected value="" disabled>Select Product</option>
                @foreach ($items as $item)
                <option {{ ($outbox->item_id_2 == $item['item_id']) ? "selected" : "" }} price="{{ $item['sellingprice'] }}" value="{{ $item['item_id'] }}">{{ $item['name'] }}</option>
              @endforeach
            </select>
        </div>

    </div>


    <div class="col-4">
      <div class="mb-3">
        <label class="form-label" for="prrice">CARTON AMOUNT/FRW</label>
        <input type="number" value="{{ $outbox->postage }}" class="form-control" name="postage" id="prrice" required autocomplete="off">

      </div>
    </div>
    <div class="col-4">
      <div class="mb-3">
        <label class="form-label" for="prrice">TEMBLE AMOUNT/FRW</label>
        <input type="number" class="form-control" name="postage_2" id="amt" required autocomplete="off" value="{{ $outbox->temb_amount }}" oninput="temb_auth();">
        <div class="valid-feedback"> ok </div>
      </div>
    </div>
    <div class="col-4">
      <div class="mb-3">
        <label class="form-label" for="prrice">TEMBLE Quantity</label>
        <input type="number" class="form-control" value="{{ $outbox->temb_qty }}" name="temb_qty" id="temb_qty" required autocomplete="off" readonly>
        <div class="valid-feedback"> ok </div>
      </div>
    </div>
    <div class="col-12">
      <div class="mb-3">
        <label class="form-label" for="prrice">Verification : </label>
        <div id="verification">
          Price/Temble : <span id="prrice_2">{{ $outbox->temb_amount/$outbox->temb_qty }}</span> Frw<br>
          Matching With Provided Price : <span class="text-danger" id="verif_result">No</span>
        </div>
      </div>
    </div>

    <div class="col-4">
      <div class="mb-3">
        <label class="form-label" for="prrice">TOTAL AMOUNT PAY</label>
        <input type="number" class="form-control" name="all_amt" id="all_amt" required autocomplete="off">
        <div class="valid-feedback"> ok </div>
      </div>
    </div>
                        <div class="col-6">
                            <div class="mb-3">
                            <label class="form-label" for="validationCustom01">PAYEMENT MODE</label>
                            <select name="ptype" class="form-control"  required >
                            <option {{ ($outbox->ptype == "cash") ? "selected" : "" }} value="cash" selected>Cash</option>
                            <option {{ ($outbox->ptype == "momo") ? "selected" : "" }} value="momo">Momo</option>
                            <option {{ ($outbox->ptype == "pos") ? "selected" : "" }} value="pos">Pos</option>
                            </select>
                            </div>
                            </div>
                    </div>
            </div>
            <div class="card-footer">
                <div class="hstack gap-2 justify-content-end">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary" disabled id="sbtn" data-loading-text="Loading..." autocomplete="off">Save Changes</button>
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

// $('#amount').val('').attr("readonly",true);
$('#tax').val(0).attr("readonly",true);
// $('#prrice').val('').attr("readonly",true);
function tax_walk() {

  //$('#amount').val($("#prrice").val()).attr("readonly",true);
  var amt = parseFloat($('#amount').val());
  var tm = parseFloat($('#prrice').val());
  $('#tax').val(amt*0.18).attr("readonly",true);
  temb_auth();


}
function last_walk(){
  $("#all_amt").val(0).attr("readonly",true);
  var a = parseFloat($('#amount').val());
  var b = parseFloat($('#tax ').val());
  var c = parseFloat($('#amt').val());
  $("#all_amt").val(a+b+c).attr("readonly",true);
}
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


});
$('#item_id_2').change(function(){

    $('#prrice_2').html(0);
    // var p = $(this).val();
    //alert(p);
    var b = $('#item_id_2');
    var get_op = b.find('option:selected');
    var sel_op = get_op.attr('price');
    // alert(sel_op);
    $("#prrice_2").html(sel_op);
    temb_auth();


});



function temb_auth() {
  $("#verif_result").html("No").attr("class","text-danger");
  $("#sbtn").attr("disabled",true);
  $("#temb_qty").val(0);
  var tot_amount = parseFloat($("#amt").val());
  var tem_price = parseFloat($("#prrice_2").html());
  var qty_raw = 0;
  if (tot_amount > 0 && tem_price > 0) {
      qty_raw = Math.floor(tot_amount/tem_price);
      $("#temb_qty").val(qty_raw);
  }
  var comp_price = qty_raw*tem_price;
  if (comp_price == tot_amount && tot_amount > 0) {
      var ammt = parseFloat($('#amount').val());
      if (comp_price == ammt) {
        $("#verif_result").html("Amount Matching").attr("class","text-success");
        $("#sbtn").attr("disabled",false);
      }else{
        $("#verif_result").html("Temble amount must be equal to sending amount").attr("class","text-warning");
      }
  }else{
    $("#verif_result").html("Double Check amount ").attr("class","text-warning");
  }
  last_walk();
}

        </script>
        <script>
      $(document).ready(function () {
        tax_walk();
        // top bar active

        // manage brand table
    // manage brand table
    var rep_tbl = $("#manageBrandTable").DataTable({
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
          var tembData = api.column(11, { search: 'applied' }).data();

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
          var temb_rep = tembData.reduce(function(a, b) {
              return parseFloat(a) + parseFloat(b);
          }, 0);

          $("#amount_rep").html(amount_rep.toLocaleString('en-RW', { style: 'currency', currency: 'Frw' }));
          $("#tax_rep").html(tax_rep.toLocaleString('en-RW', { style: 'currency', currency: 'Frw' }));
          $("#carton_rep").html(carton_rep.toLocaleString('en-RW', { style: 'currency', currency: 'Frw' }));
          $("#total_rep").html(total_rep.toLocaleString('en-RW', { style: 'currency', currency: 'Frw' }));
          $("#temb_rep").html(temb_rep.toLocaleString('en-RW', { style: 'currency', currency: 'Frw' }));
      }
    });
});

    </script>
@endsection
