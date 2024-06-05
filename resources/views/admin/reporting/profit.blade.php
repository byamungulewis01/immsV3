@php
// Set the timezone to match your desired timezone
date_default_timezone_set('Africa/Kigali');
// Set the year for which you want to loop through the months

$year = date('Y');


$date = "{}";
if (isset($_GET['rep']) && !empty($_GET['rep'])) {
  $date = urldecode($_GET['rep']);
}
$chop = json_decode($date);
$start = date('Y-m-d');
$end = date('Y-m-d');
$date_vd = false;
if (isset($chop->from) && isset($chop->to) && !empty($chop->from) && !empty($chop->to)) {
  if ($chop->to > $chop->from || $chop->to == $chop->from) {
    $start = date_format(date_create($chop->from),"Y-m-d");
    $end = date_format(date_create($chop->to),"Y-m-d");
    $date_vd = true;
  }
}

$linker = json_encode(array("from"=>$start,"to"=>$end));
$link = "?rep=".urlencode($linker);

$month = 1;
$mx_y = 12;

if ($date_vd && (date('Y', strtotime($start)) == date('Y', strtotime($end)))) {
    $month = date('n', strtotime($start));
    $year = date('Y', strtotime($start));
    $mx_y = date('n', strtotime($end));
}
$starting_month = $month;
$monthNumber = $month;
// Create a DateTime object using the month number
$date = DateTime::createFromFormat('!m', $monthNumber);
// Format the DateTime object to display the month name
$monthName = $date->format('F');
$start_month = $monthName."-".$year;

$monthNumber = $mx_y;
// Create a DateTime object using the month number
$date = DateTime::createFromFormat('!m', $monthNumber);
// Format the DateTime object to display the month name
$monthName = $date->format('F');
$end_month = $monthName."-".$year;
@endphp
@extends('layouts.admin.app')
@section('page-name')MMONTHLY INCOME AND EXPENSE ACTIVITY REPORT FOR AGENCIES | From : {{ $start_month }} , To : {{ $end_month }} @endsection
@section('body')
@php
$startDate = new DateTime($start);
$endDate = new DateTime($end);
// var_dump($startDate);
// exit();
// Clone the start date to avoid modifying it directly
$currentDate = clone $startDate;

// while ($currentDate <= $endDate) {
//     echo $currentDate->format('Y-m-d') . "<br>";

    // Increment the current date by 1 day
//     $currentDate->modify('+1 day');
// }
// exit();
@endphp
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">MONTHLY INCOME AND EXPENSE ACTIVITY REPORT FOR AGENCIES</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS </a>
                    </li>
                    <li class="breadcrumb-item active">Mail</li>
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
                            <h5 class="card-title mb-0">MONTHLY INCOME AND EXPENSE ACTIVITY REPORT FOR AGENCIES | From : {{ $start_month }} , To : {{ $end_month }}</h5>
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
            <div class="card-body table-responsive">
                <table id="manageBrandTable" class="table nowrap table-bordered align-middle" style="width:100%">
                    <thead>
                        <tr>
                          <th>#</th>
                          <th>Date</th>
                            @php
                            $gen_tot = 0;
                            $exp_tot = 0;
                            $bal_tot = 0;
                            @endphp
                          <th>Income</th>
                          <th>Expense</th>
                          <th>Balance</th>
                          <th>Action</th>
                        </tr>
                      </thead>
                    <tbody>
                        @php
                            $z = 1;

                            // Loop through the months of the year
                        @endphp
                        @while ($month <= $mx_y)
                            <tr>
                                <td>
                                    @php
                                        echo $z++;
                                    @endphp
                                </td>
                                <td>
                                    @php
                                        $monthNumber = $month;
                                        // Create a DateTime object using the month number
                                        $date = DateTime::createFromFormat('!m', $monthNumber);
                                        // Format the DateTime object to display the month name
                                        $monthName = $date->format('F');
                                        echo $monthName." - ".$year; //
                                    @endphp
                                </td>
                                @php
                                    // Get the starting date of the current month
                                    $startDate = new DateTime("$year-$month-01");

                                    // Get the ending date of the current month
                                    $endDate = clone $startDate;
                                    $endDate->modify('last day of this month');

                                    // Format the dates as desired
                                    $start = $startDate->format('Y-m-d');
                                    $end = $endDate->format('Y-m-d');

                                if (isset($start) && !empty($start) && isset($end) && !empty($end)) {
                                  if ($start != $end) {
                                    $v = "AND DATE(b.created_at) BETWEEN '$start' AND '$end'";
                                  }else{
                                    $regdate = $start;
                                    $v = "AND DATE(b.created_at)='$regdate'";
                                  }
                                }else{
                                  $regdate = date('Y-m-d');
                                  $v = "AND DATE(b.created_at)='$regdate'";
                                }
                                $carton = 0;


                                  $sql = "SELECT max(a.name),SUM(IFNULL(b.weight,0)) AS weight, SUM(IFNULL(b.amount,0)) AS amount, SUM(IFNULL(b.tax,0)) AS tax, SUM(IFNULL(b.postage,0)) AS postage FROM branches a LEFT JOIN `outboxing` b ON(a.id=b.blanch $v) GROUP BY a.id";
                                  //echo $sql."<br>";
                                  $res = DB::select($sql);

                                    foreach ($res as $row) {
                                        $carton += $row->postage;
                                    }

                                  unset($sql);
                                  unset($res);
                                  unset($row);
                                  $sql = "SELECT max(a.name),SUM(IFNULL(b.weight,0)) AS weight, SUM(IFNULL(b.amount,0)) AS amount, SUM(IFNULL(b.tax,0)) AS tax, SUM(IFNULL(b.postage,0)) AS postage FROM branches a LEFT JOIN `poutboxing` b ON(a.id=b.blanch $v)  GROUP BY a.id";
                                  //echo $sql."<br>";
                                  $res = DB::select($sql);

                                    foreach ($res as $row) {
                                        $carton += $row->postage;
                                    }

                                  unset($sql);
                                  unset($res);
                                  unset($row);
                                    $sql = "SELECT max(a.name),SUM(IFNULL(b.weight,0)) AS weight, SUM(IFNULL(b.amount,0)) AS amount, SUM(IFNULL(b.tax,0)) AS tax, SUM(IFNULL(b.postage,0)) AS postage FROM branches a LEFT JOIN `registoutboxing` b ON(a.id=b.blanch $v) GROUP BY a.id";
                                  //echo $sql."<br>";
                                  $res = DB::select($sql);

                                    foreach ($res as $row) {
                                        $carton += $row->postage;
                                    }
                                    unset($sql);
                                    unset($res);
                                    unset($row);
                                    $sql = "SELECT max(a.name),SUM(IFNULL(b.qty,0)) AS weight, SUM(IFNULL(b.amount,0)) AS postage FROM branches a LEFT JOIN `posteloutboxing` b ON(a.id=b.blanch $v) GROUP BY a.id";
                                  //echo $sql."<br>";
                                  $res = DB::select($sql);

                                    foreach ($res as $row) {
                                        $carton += $row->postage;
                                    }
                                      unset($sql);
                                      unset($res);
                                      unset($row);
                                    $sql = "SELECT max(a.name),SUM(IFNULL(b.weight,0)) AS weight, SUM(IFNULL(b.temb_amount,0)) AS amount, SUM(IFNULL(b.tax,0)) AS tax, SUM(IFNULL(b.postage,0)) AS postage FROM branches a LEFT JOIN `tembleoutboxing` b ON(a.id=b.blanch $v) GROUP BY a.id";
                                  //echo $sql."<br>";
                                  $res = DB::select($sql);

                                    foreach ($res as $row) {
                                        $carton += $row->postage;
                                    }


                                    ////ended outboxing

                                    ///start other part
                                    // ems mail postage

                                    $sql = "SELECT MAX(a.name), SUM(IFNULL(b.weight, 0)) AS weight, SUM(IFNULL(b.amount, 0)) AS amount, SUM(IFNULL(b.postage, 0)) AS postage
                                    FROM branches a
                                    LEFT JOIN `outboxing` b ON (a.id = b.blanch $v)";
                                    $res = DB::select($sql);

                                    foreach ($res as $row) {
                                        $carton += $row->amount;
                                    }
                                    // end ems mail postage


                                    //percel mail postage
                                    $sql = "SELECT MAX(a.name), SUM(IFNULL(b.weight, 0)) AS weight, SUM(IFNULL(b.amount, 0)) AS amount, SUM(IFNULL(b.postage, 0)) AS postage
                                    FROM branches a
                                    LEFT JOIN `registoutboxing` b ON (a.id = b.blanch $v)";
                                    $res = DB::select($sql);

                                    foreach ($res as $row) {
                                        $carton += $row->amount;
                                    }
                                    // end percel mail postage

                                    //Registered Mail Postage
                                    $sql = "SELECT MAX(a.name), SUM(IFNULL(b.weight, 0)) AS weight, SUM(IFNULL(b.amount, 0)) AS amount, SUM(IFNULL(b.postage, 0)) AS postage
                                    FROM branches a
                                    LEFT JOIN `poutboxing` b ON (a.id = b.blanch $v)";
                                    $res = DB::select($sql);

                                    foreach ($res as $row) {
                                        $carton += $row->amount;
                                    }
                                    // end Registered Mail Postage

                                    //Post With Temble Postage
                                    $sql = "SELECT MAX(a.name), SUM(IFNULL(b.weight, 0)) AS weight, SUM(IFNULL(b.temb_amount, 0)) AS amount, SUM(IFNULL(b.postage, 0)) AS postage
                                    FROM branches a
                                    LEFT JOIN `tembleoutboxing` b ON (a.id = b.blanch $v)";
                                    $res = DB::select($sql);

                                    foreach ($res as $row) {
                                        $carton += $row->amount;
                                    }
                                    $sql = "SELECT SUM(IFNULL(b.amount, 0)) AS amount
                                    FROM branches a
                                    LEFT JOIN `pob_pays` b ON (a.id = b.bid $v)";
                                    $res = DB::select($sql);

                                    foreach ($res as $row) {
                                        $carton += $row->amount;
                                    }

                                    $sql = "SELECT SUM(IFNULL(b.amount, 0)) AS amount
                                    FROM branches a
                                    LEFT JOIN `courierpays` b ON (a.id = b.bid $v)";
                                    $res = DB::select($sql);

                                    foreach ($res as $row) {
                                        $carton += $row->amount;
                                    }
                                    //End POB pays Income

                                    //Other income services Income
                                    $sql = "SELECT SUM(IFNULL(b.e_amount, 0)) AS amount
                                    FROM branches a
                                    LEFT JOIN `income` b ON (a.id = b.branch_id AND b.e_status=1 $v)";
                                    $res = DB::select($sql);

                                    foreach ($res as $row) {
                                        $carton += $row->amount;
                                    }
                                    //End Incme Services
                                    //update general Total
                                    $gen_tot += $carton;
                                @endphp
                                <td>{{ number_format($carton,2)." Frw" }}</td>

                                @php
                                $expenses_m = 0;
                                    $sql = "SELECT SUM(IFNULL(b.e_amount, 0)) AS amount
                                  FROM branches a
                                  LEFT JOIN `expenses` b ON (a.id = b.branch_id AND b.e_status=1 $v)";
                                  $res = DB::select($sql);

                                  foreach ($res as $row) {
                                      $expenses_m += $row->amount;
                                  }
                                $exp_tot += $expenses_m;
                                @endphp
                                <td>{{ number_format($expenses_m,2)." Frw" }}</td>
                                @php
                                $bal = 0;
                                $bal = $carton-$expenses_m;
                                $bal_tot += $bal;
                                @endphp
                                <td>{{ number_format($bal,2)." Frw" }}</td>
                                @php
                                    //generate Link to report
                                    $linker = json_encode(array("from"=>$start,"to"=>$end));
                                    $link = "rep=".urlencode($linker);
                                @endphp
                                <td>
                                    <div class="dropdown">
                                        @php
                                         $m = rand();
                                        @endphp
                                        <button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenuButton{{ "-".$m }}" data-bs-toggle="dropdown" aria-expanded="false">
                                            View Details
                                        </button>
                                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton{{ "-".$m }}">
                                            <li>
                                                <a type="button" class="dropdown-item btn btn-primary btn-sm edit-item" href="{{ route('admin.reporting.index',$link) }}"
                                                ><span>View Income Detailed</span></a>
                                            </li>
                                            <li>
                                                <a type="button" class="dropdown-item btn btn-secondary btn-sm edit-item" href="{{ route('admin.reporting.expenses',$link) }}"
                                                ><span>View Expense Detailed</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </td>
                            </tr>
                            @php
                                // $currentDate->modify('+1 day');
                                $month++;
                            @endphp
                        @endwhile
                    </tbody>
                    <tfoot>
                        <th colspan="2">
                          Total
                        </th>
                        <th>{{ number_format($gen_tot,2)." Frw" }}</th>
                        <th>{{ number_format($exp_tot,2)." Frw" }}</th>
                        <th>{{ number_format($bal_tot,2)." Frw" }}</th>
                        @php
                            // Get the starting date of the current month
                            $startDate = new DateTime("$year-$starting_month-01");

                            // Get the ending date of the current month
                            $endDate = clone $startDate;
                            $endDate->modify('last day of this month');

                            // Format the dates as desired
                            $starting = $startDate->format('Y-m-d');
                            $ending = $endDate->format('Y-m-d');
                            //generate Link to report
                            $linker = json_encode(array("from"=>$ending,"to"=>$year."-"."12"."-"."31"));
                            $link = "rep=".urlencode($linker);
                        @endphp
                        <th>
                            <div class="dropdown">

                            </div>
                        </th>
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
                  <input type="month" name="from" id="from" class="form-control" placeholder="From" required="true" oninput="build_rep_link($(this).val(),$('#to').val(),'#get_report')" value="{{ $start }}">
                </div>
              </div>
              <div class="form-group">
                <label for="to">
                  To :
                </label>
                <div class="input-group mb-3">
                  <input type="month" name="to" id="to" class="form-control" placeholder="To" required="true" oninput="build_rep_link($('#from').val(),$(this).val(),'#get_report')" value="{{ $end }}">
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

<script src="https://code.jquery.com/jquery-3.6.0.min.js"
    integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

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
      $(document).ready(function () {

// manage brand table
var rep_tbl = $("#manageBrandTable").DataTable({
  //'ajax': 'php_action/emsreport.php?start=<?php echo $start;?>&end=<?php echo $end;?>',
  'paging' : false,
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
    </script>
@endsection
