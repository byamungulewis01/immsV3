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
                            @can('make branchorder')
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                                data-bs-target="#showModal">
                                <i class="ri-add-line align-bottom me-1"></i> New Posting With Temble
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
            <div class="card-body table-responsive">
                <table id="manageBrandTable" class="table nowrap table-bordered align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th class="sort" data-sort="tracking">Tracking</th>
                            <th class="sort" data-sort="sender">Sender</th>
                            <th class="sort" data-sort="receiver">Receiver</th>
                            <th class="sort" data-sort="country">Country</th>
                            <th class="sort" data-sort="weight">weight</th>
                            {{-- <th class="sort" data-sort="carton">Carton</th> --}}
                            <th class="sort" data-sort="total">Total</th>
                            {{-- <th class="sort" data-sort="temb_qty">Temb Qty</th> --}}
                            <th class="sort" data-sort="action">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($outboxings as $key => $outbox)
                        <tr>
                            <td scope="row">
                                {{ $key + 1 }}
                            </td>
                            <td class="tracking">{{ $outbox->tracking }}</td>
                            <td class="sender">{{ $outbox->snames }}</td>
                            <td class="receiver">{{ $outbox->rnames }}</td>
                            <td class="country">{{ $outbox->c_id }}</td>
                            <td class="weight">{{ $outbox->weight." ".$outbox->unit }}</td>
                            {{-- <td class="carton">{{ $outbox->postage }}</td> --}}
                            <td class="total" align="center">{{  $outbox->temb_amount }}</td>
                            {{-- <td class="carton">{{ $outbox->temb_qty }}</td> --}}

                            <td class="action">
                                @can('make outboxing')
                                <a href="{{ route('branch.tembleoutboxing.invoiceemstemble', $outbox->out_id) }}" class="btn btn-sm btn-info" target="_blank">PRINT</a>
                                @endcan

                                @can('make outboxing')
                                <a href="#deleteRecordModal" data-bs-toggle="modal" type="button" data-action="{{ route('branch.tembleoutboxing.destroy',$outbox->out_id) }}"
                                    class="btn btn-danger btn-sm delete-item"><span>Delete</span></a>
                                @endcan

                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th colspan="6">
                          Today's Income
                        </th>
                        <th id="total_rep"></th>
                        {{-- <th></th> --}}

                      </tfoot>
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
                          colors="primary:#f7b84b,secondary:#f06548" style="width: 100px; height: 100px"></lord-icon>
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
@can ('make outboxing')

<div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog  modal-xl">
        <div class="modal-content">
            <div class="modal-header p-3">
                <h5 class="modal-title" id="exampleModalLabel">Posting With Temble Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"
                    aria-label="Close" id="close-modal"></button>
            </div>
            <form class="tablelist-form" method="post"
                action="{{ route('branch.tembleoutboxing.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
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
                              <input name="tracking"  type="text" class="form-control" id="validationCustom01"  autocomplete="off" >
                              <div class="valid-feedback"> ok </div>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="mb-3">
                              <label class="form-label" for="validationCustom01">NAMES</label>
                              <input required  name="snames" type="text" class="form-control" id="validationCustom01"   autocomplete="off">
                              <div class="valid-feedback"> ok </div>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="mb-3">
                              <label class="form-label" for="validationCustom01">MOBILE PHONE </label>
                              <input  name="sphone"  required type="text" class="form-control" id="validationCustom01"   autocomplete="off">
                              <div class="valid-feedback"> ok </div>
                            </div>
                          </div>
                            <div class="col-4">
                            <div class="mb-3">
                              <label class="form-label" for="validationCustom01">EMAIL </label>
                              <input  name="semail"  type="email" class="form-control" id="validationCustom01"    autocomplete="off">
                              <div class="valid-feedback"> ok </div>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="mb-3">
                              <label class="form-label" for="validationCustom01">NID/PASSPORT </label>
                              <input name="snid" type="text" class="form-control" id="validationCustom01" required   autocomplete="off">
                              <div class="valid-feedback"> ok </div>
                            </div>
                          </div>

                            <div class="col-4">
                            <div class="mb-3">
                              <label class="form-label" for="validationCustom01">SENDER ADDRESS </label>
                              <input name="saddress" type="text" class="form-control" id="validationCustom01"  required  autocomplete="off">
                              <div class="valid-feedback"> ok </div>
                            </div>
                          </div>
                            <div class="col-4">
                                <div class="mb-3">
                                    <label class="form-label" for="rcountry">DESTINATION COUNTRY</label>
                                    <input type="text"  class="form-control" name="rcountry" type="text" placeholder="country" id="rcountry"  required>
                                  </div>
                          </div>
                              <label class="form-label" for="validationCustom01">RECEIVER INFORMATION</label>


                        <div class="col-4">
                            <div class="mb-3">
                              <label class="form-label" for="validationCustom01">NAMES</label>
                              <input required  name="rnames" type="text" class="form-control" id="validationCustom01"  required autocomplete="off">
                              <div class="valid-feedback"> ok </div>
                            </div>
                          </div>
                          <div class="col-4">
                            <div class="mb-3">
                              <label class="form-label" for="validationCustom01">MOBILE PHONE </label>
                              <input  name="rphone"  type="text" class="form-control" id="validationCustom01" required   autocomplete="off">
                              <div class="valid-feedback"> ok </div>
                            </div>
                          </div>
                            <div class="col-4">
                            <div class="mb-3">
                              <label class="form-label" for="validationCustom01">EMAIL </label>
                              <input  name="remail"  type="email" class="form-control" id="validationCustom01"    autocomplete="off">
                              <div class="valid-feedback"> ok </div>
                            </div>
                          </div>
                            <div class="col-12">
                            <div class="mb-3">
                              <label class="form-label" for="validationCustom01">RECEIVER ADDRESS </label>
                              <input  name="raddress"  type="text" class="form-control" id="validationCustom01" required   autocomplete="off">
                              <div class="valid-feedback"> ok </div>
                            </div>
                          </div>

                       <label class="form-label" for="validationCustom01"><b>POSTING INFORMATION </b></label>

                          <div class="col-4">
                            <div class="mb-3">
                              <label class="form-label" for="weight">WEIGHT</label>
                              <input type="text" class="form-control" id="weight" name="weight"  required autocomplete="off">
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
                              <input type="number" value="0" class="form-control" id="amount" name="amount" oninput="tax_walk();upd();" required autocomplete="off">
                              <i class="green-text">Requesting <span class="dot-1">.</span><span class="dot-2">.</span><span class="dot-3">.</span></i>
                            </div>
                          </div>
                          <div class="col-4"></div>
                            <div class="col-4">
                            <div class="mb-3">
                              <label class="form-label" for="tax">TAX/FRW</label>
                              <input type="number" class="form-control" id="tax" name="tax"  required autocomplete="off">
                              <!-- <span class="animated-text">Hello dear</span> -->
                              <i class="green-text">Requesting <span class="dot-1">.</span><span class="dot-2">.</span><span class="dot-3">.</span></i>

                            </div>
                          </div>
                          <div class="col-4"></div>

                            {{-- <div class="col-4">
                           <div class="mb-3">
                                  <label for="item_id" class="form-label">CARTON/ENVELOP/FRW</label>
                                  <select class="form-control sellect" id="item_id" name='item_id' required>

                                      <option selected value="" disabled>Select Product</option>
                                    @foreach ($items as $item)
                                      <option price="{{ $item['sellingprice'] }}" value="{{ $item['item_id'] }}">{{ $item['name'] }}</option>
                                    @endforeach
                                  </select>
                              </div>

                          </div> --}}
                          <div class="col-4" style="display: none;">
                            <div class="mb-3">
                <label for="item_id" class="form-label">SELECT TEMBLE </label>
                <select class="form-control sellect" id="item_id_2" name='item_id_2' >

                    <option selected value="" disabled>Select Temble</option>
                    @foreach ($items as $item)
                    <option price="{{ $item['sellingprice'] }}" value="{{ $item['item_id'] }}">{{ $item['name'] }}</option>
                  @endforeach
                </select>
            </div>

        </div>


        {{-- <div class="col-4">
          <div class="mb-3">
            <label class="form-label" for="prrice">CARTON AMOUNT/FRW</label>
            <input type="number" class="form-control" name="postage" id="prrice" required autocomplete="off">

          </div>
        </div> --}}
        <div class="col-4">
          <div class="mb-3">
            <label class="form-label" for="prrice">TEMBLE AMOUNT/FRW</label>
            <input type="number" class="form-control" name="postage_2" id="amt" autocomplete="off" oninput="temb_auth();" readonly>
            <div class="valid-feedback"> ok </div>
          </div>
        </div>
        <div class="col-4" style="display: none;">
          <div class="mb-3">
            <label class="form-label" for="prrice">TEMBLE Quantity</label>
            <input type="number" class="form-control" name="temb_qty" id="temb_qty" required autocomplete="off" readonly>
            <div class="valid-feedback"> ok </div>
          </div>
        </div>
        <div class="col-12">
          {{-- <button type="button" class="btn btn-primary btn-block" id="add-row"><i class="mdi mdi-plus-circle me-2"></i> Add new Product Row</button> --}}
          <table class="table table-bordered " id="my-table">
              <thead>
              <tr>
                  <th>
                      Temble
                  </th>
                  <th>
                      Quantity
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
                          @foreach ($items as $prod)
                          @php
                            $itemm_1 = App\Models\Item::with('category_info')->find($prod['item_id']);
                            $cate = $itemm_1->category_info->categoryname;
                            //transform category to lower case
                            $cate = strtolower($cate);
                            if (trim($cate) != 'temble') {
                                continue;
                            }
                          @endphp
                              <option price="{{ $prod['sellingprice'] }}" qty="{{ $prod['qty'] }}" value="{{ $prod['item_id'] }}">{{ $prod['name'] }}</option>
                          @endforeach
                      </select>
                  </td>
                  <td>
                      <input required name="quantity[]" type="text" class="form-control cv p_qty"
                             autocomplete="off" value="0" oninput="match_qty();upd();">
                  </td>
                  <td>
                      <button class="btn btn-danger remove-row" type="button"><i class="fa fa-times-circle"></i> X</button>
                  </td>
              </tr>
              </tbody>
              <tfoot>
              <tr>
                  <td colspan="3">
                      <button type="button" class="btn btn-primary btn-block" id="add-row"><i class="mdi mdi-plus-circle me-2"></i> Add Onother Temble</button>
                  </td>
              </tfoot>
          </table>
        </div>
        <div class="col-12">
          <div class="mb-3">
            <label class="form-label" for="prrice">Verification : </label>
            <div id="verification">
              {{-- Price/Temble : <span id="prrice_2">0</span> Frw<br> --}}
              Matching With Provided Price : <span class="text-danger" id="verif_result">No</span>
            </div>
          </div>
        </div>

        <div class="col-4" style="display: none;">
          <div class="mb-3">
            <label class="form-label" for="prrice">TOTAL AMOUNT PAY</label>
            <input type="number" class="form-control" name="all_amt" id="all_amt" autocomplete="off">
            <div class="valid-feedback"> ok </div>
          </div>
        </div>
                            <div class="col-6">
                                <div class="mb-3">
                                <label class="form-label" for="validationCustom01">PAYEMENT MODE</label>
                                <select name="ptype" class="form-control"  required >
                                <option value="cash" selected>Cash</option>
                                <option value="momo">Momo</option>
                                <option value="pos">Pos</option>
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
                <div class="modal-footer">
                    <div class="hstack gap-2 justify-content-end">
                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" disabled id="sbtn" data-loading-text="Loading..." autocomplete="off">Save Changes</button>
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
                      <option value="">Select Temble</option>
                      @foreach ($items as $prod)
                      @php
                        $itemm_1 = App\Models\Item::with('category_info')->find($prod['item_id']);
                        $cate = $itemm_1->category_info->categoryname;
                        //transform category to lower case
                        $cate = strtolower($cate);
                        if (trim($cate) != 'temble') {
                            continue;
                        }
                      @endphp
                          <option price="{{ $prod['sellingprice'] }}" qty="{{ $prod['qty'] }}" value="{{ $prod['item_id'] }}">{{ $prod['name'] }}</option>
                      @endforeach
                  </select>
              </td>
              <td>
                  <input required name="quantity[]" type="text" class="form-control cv p_qty"
                         autocomplete="off" value="0" oninput="match_qty();upd();">
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
    $("#verif_result").html("Double Check amount").attr("class","text-warning");
  }
  last_walk();
}

        </script>
        <script>
      $(document).ready(function () {
        $(document).on('click', '.delete-item', function () {
            // var itemid = $(this).data('itemid');
            var formaction = $(this).data('action');
            $('#deleteitem').attr('action', formaction);
            // $('#itemid').val(itemid);
        });
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
          // var cartonData = api.column(8, { search: 'applied' }).data();
          var totalData = api.column(6, { search: 'applied' }).data();


          // calculate the sum using reduce method


          // var carton_rep = cartonData.reduce(function(a, b) {
          //     return parseFloat(a) + parseFloat(b);
          // }, 0);

          var total_rep = totalData.reduce(function(a, b) {
              return parseFloat(a) + parseFloat(b);
          }, 0);



          $("#total_rep").html(total_rep.toLocaleString('en-RW', { style: 'currency', currency: 'Frw' }));
      }
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
    // $("#my-table tbody tr").find(".sellect").attr("readonly", true);

    $('#my-table select').each(function() {
      if ($(this).val()) {
        $(this).chosen('destroy');
        $(this).prop('readonly', true).trigger('chosen:updated');
      }
    });
        // Clone the first table row
        const newRow = $("#my-table2 tbody tr:first").clone();
        // Reset input values in the cloned row
        newRow.find("input").val("");
        newRow.find('input[name="quantity[]"]').val(0);
          newRow.find("select").val("");
        newRow.find("select").addClass("sellect");
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

    function match_qty() {
  var qts = [];
  var qt = 0;

  $('#my-table tbody tr').each(function() {
    $(this).find('option:selected').each(function() {
      qts.push(parseFloat($(this).attr('qty')));
    });

    $(this).find('input[name="quantity[]"]').each(function() {
      var qty_ = parseFloat($(this).val());
      var current_qt = qts[qt];
      console.log(qts);
      if (isNaN(qty_)) {
        // alert("Please enter a valid quantity.");
        $(this).val(0);
      } else if (current_qt < qty_) {
        alert("Quantity is greater than available stock.");
        $(this).val(current_qt);
      }

      qt++; // Increment the index
    });
  });

  return true;
}


    function upd() {
      var qts = [];
      var qt = 0;
      var sum = 0;

      $('#my-table tbody tr').each(function() {
        $(this).find('option:selected').each(function() {
          qts.push(parseFloat($(this).attr('price')));
        });

        $(this).find('input[name="quantity[]"]').each(function() {
          var qty_ = parseFloat($(this).val());
          var current_qt = qts[qt];
          console.log(qts);

          if (isNaN(qty_)) {
            // alert("Please enter a valid quantity.");
            $(this).val(0);
          } else {
            sum += (current_qt*qty_);
          }

          qt++; // Increment the index
        });
      });
      $('#amt').val(sum);
      var amount = $('#amount').val();



  $("#verif_result").html("No").attr("class","text-danger");
  $("#sbtn").attr("disabled",true);
      var ammt = parseFloat($('#amount').val());
      if (sum == ammt && sum > 0) {
        $("#verif_result").html("Amount Matching").attr("class","text-success");
        $("#sbtn").attr("disabled",false);
      }else{
        $("#verif_result").html("Temble amount must be equal to sending amount").attr("class","text-warning");
      }
      return true;
    }
    </script>
@endsection
