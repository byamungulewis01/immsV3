@extends('layouts.admin.app')
@section('page-name')EMS Mail Outboxing Report @endsection
@section('body')
@php
$date = "{}";
if (isset($_GET['rep']) && !empty($_GET['rep'])) {
  $date = urldecode($_GET['rep']);
}
$chop = json_decode($date);
$start = date('Y-m-d');
$end = date('Y-m-d');

if (isset($chop->from) && isset($chop->to) && !empty($chop->from) && !empty($chop->to)) {
  if ($chop->to > $chop->from || $chop->to == $chop->from) {
    $start = date_format(date_create($chop->from),"Y-m-d");
    $end = date_format(date_create($chop->to),"Y-m-d");
  }
}

$linker = json_encode(array("from"=>$start,"to"=>$end));
$link = "?rep=".urlencode($linker)."/date";
@endphp
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">EMS Mail Outboxing Report</h4>

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
                            <h5 class="card-title mb-0">EMS outboxing History  | From : {{ $start }} , To : {{ $end }}</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                <i class="ri-delete-bin-2-line"></i>
                            </button>

                            <a from="{{ $start }}" to="{{ $end }}" id="report_mask" onclick="window.location.href=$(this).attr('href');" style='display: none;'>.</a>
                            <button class="btn btn-primary ftb" data-bs-toggle="modal" data-bs-target=".modal-report"><i class="ri-calendar-2-fill"></i> Filter report by date</button>&nbsp;
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <table id="manageBrandTable" class="table nowrap table-bordered align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th class="sort" data-sort="tracking">Tracking</th>
                            <th class="sort" data-sort="sender">Sender</th>
                            <th class="sort" data-sort="receiver">Receiver</th>
                            <th class="sort" data-sort="country">Country</th>
                            <th class="sort" data-sort="weight">weight</th>
                            <th class="sort" data-sort="amount">Amount</th>
                            <th class="sort" data-sort="carton">Carton</th>
                            <th class="sort" data-sort="total">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $outboxings = App\Models\Outboxing::byrange($start, $end);
                            $tot = 0;
                        @endphp
                        @foreach ($outboxings as $key => $outbox)
                        <tr>
                            <td scope="row">
                                {{ $key + 1 }}
                            </td>
                            <td class="tracking">{{ $outbox->tracking }}</td>
                            <td class="sender">{{ $outbox->snames }}</td>
                            <td class="receiver">{{ $outbox->rnames }}</td>
                            @php
                            $country_ = App\Models\Country::country_tarif($outbox->c_id,"data");
                            @endphp
                            <td class="country">{{ $country_['countryname'] }}</td>
                            <td class="weight">{{ $outbox->weight." ".$outbox->unit }}</td>
                            <td class="amount">{{ $outbox->amount }}</td>

                            <td class="carton">{{ $outbox->postage }}</td>
                            <td class="total" align="center">{{ $outbox->amount + $outbox->postage }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                      <th colspan="6">
                        Total Income
                      </th>
                      <th id="amount_rep"></th>
                      <th id="carton_rep"></th>
                      <th id="total_rep"></th>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
    <!--end col-->
</div>
<!--end row-->

<div class="modal fade modal-report">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Filter Report By date</h4>
          <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
           <div class="card">
            <div class="card-body register-card-body table-responsive p-3">

              <form method="post" id="report_date">
              <div class="form-group">
                <label for="from">
                  From :
                </label>
                <div class="input-group mb-3">
                  <input type="date" name="from" id="from" class="form-control" placeholder="From" required="true" oninput="build_rep_link($(this).val(),$('#to').val(),'#get_report')" value="{{ $start }}">
                </div>
              </div>
              <div class="form-group">
                <label for="to">
                  To :
                </label>
                <div class="input-group mb-3">
                  <input type="date" name="to" id="to" class="form-control" placeholder="To" required="true" oninput="build_rep_link($('#from').val(),$(this).val(),'#get_report')" value="{{ $end }}">
                </div>
              </div>
              <div class="wait" align="center"></div>
              <input type="hidden" name="mod_close" value="#reg_close">
              </form>
            </div>
            <!-- /.form-box -->
          </div><!-- /.card -->
        </div>
        <div class="modal-footer justify-content-between">
          <button type="button" class="btn btn-outline-danger" data-bs-dismiss="modal" id="reg_close"><span class="fa fa-times"></span> Close</button>
          <!-- <button onclick="$('').attr('href');">
            Get Filtered report
          </button> -->
          <a data-bs-dismiss="modal" class="btn btn-primary" id="get_report" href="{{ $link }}" onclick="window.location.href=$(this).attr('href');">Get Filtered report</a>
        </div>
      </div>
      <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
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

    $('#amount').val('').attr("readonly",true);
    $('#tax').val('').attr("readonly",true);
    $('#prrice').val('').attr("readonly",true);
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
                footer: true
            },
            {
                extend: 'csv',
                footer: true
            },
            {
                extend: 'excel',
                footer: true,
            },
            {
                extend: 'pdf',
                footer: true
            }
        ],
    "drawCallback": function(settings) {
        var api = this.api();

        // get the column data
        var amountData = api.column(6, { search: 'applied' }).data();
        var cartonData = api.column(7, { search: 'applied' }).data();
        var totalData = api.column(8, { search: 'applied' }).data();

        // calculate the sum using reduce method
        var amount_rep = amountData.reduce(function(a, b) {
            return parseFloat(a) + parseFloat(b);
        }, 0);


        var carton_rep = cartonData.reduce(function(a, b) {
            return parseFloat(a) + parseFloat(b);
        }, 0);

        var total_rep = totalData.reduce(function(a, b) {
            return parseFloat(a) + parseFloat(b);
        }, 0);

        $("#amount_rep").html(amount_rep.toLocaleString('en-RW', { style: 'currency', currency: 'Frw' }));
        $("#carton_rep").html(carton_rep.toLocaleString('en-RW', { style: 'currency', currency: 'Frw' }));
        $("#total_rep").html(total_rep.toLocaleString('en-RW', { style: 'currency', currency: 'Frw' }));
    }
});

      });




function build_rep_link(from='',to='',target_btn='') {
    var returr = '{"from":"'+from+'","to":"'+to+'"}';
    var gen_ret = encodeURIComponent(returr);
    var gen_lnk = '?rep='+gen_ret;
    $(target_btn).attr('href',gen_lnk);
  }

  function get_rep_link(memb='',target_btn='#report_mask') {
    var fromm = $(target_btn).attr('from');
    var too = $(target_btn).attr('to');

    var returr = '{"a_id":"'+memb+'","from":"'+fromm+'","to":"'+too+'"}';
    var gen_ret = encodeURIComponent(returr);
    var gen_lnk = '?rep='+gen_ret;
    // alert(gen_lnk);
    $(target_btn).attr('href',gen_lnk);
    $(target_btn).click();
  }
setInterval(class_y, 1000);
function class_y() {
  //$(".btn-default").addClass("btn-primary");
}
    </script>
@endsection
