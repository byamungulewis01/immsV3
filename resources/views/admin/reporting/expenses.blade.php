@extends('layouts.admin.app')
@section('page-name')ACTIVITY REPORT FOR AGENCIES EXPENSE @endsection
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
            <h4 class="mb-sm-0">ACTIVITY REPORT FOR AGENCIES EXPENSES</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS</a>
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
                            <h5 class="card-title mb-0">ACTIVITY REPORT FOR AGENCIES EXPENSES | From : {{ $start }} , To : {{ $end }}</h5>
                        </div>
                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                <i class="ri-delete-bin-2-line"></i>
                            </button>

                            <a from="{{ $start }}" to="{{ $end }}" id="report_mask" onclick="window.location.href=$(this).attr('href');" style='display: none;'>.</a>
                            <button class="btn btn-primary ftb" data-bs-toggle="modal" data-bs-target=".modal-report"><i class="ri-calendar-2-fill"></i> Filter report by date</button>&nbsp;

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
                          <th>Activities</th>
                          @php
                                $gen_tot = array();
                            @endphp
                            @foreach ($branches as $branch)
                              @php
                              $gen_tot[$branch->id] = 0;
                              @endphp
                            <th>{{ ucfirst($branch->name) }}</th>
                            @endforeach
                          <th>TOTAL</th>
                        </tr>
                      </thead>
                    <tbody>
                        @foreach ($expensetypes as $expense)
                        <tr>
                          <td>
                            Expense -
                              {{ $expense->et_name }}
                          </td>
                          @php
                          $row_tot = 0;
                          @endphp
                          @foreach ($branches as $br)
                            @php

                            //$gen_tot[$br['bid']] = 0;
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
                              $bid = $br->id;
                              $et = $expense->et_id;
                              $carton = 0;

                                  $sql = "SELECT SUM(IFNULL(b.e_amount, 0)) AS amount
                                  FROM branches a
                                  LEFT JOIN `expenses` b ON (a.id = b.branch_id AND b.et_id = '".$expense->et_id."' AND b.e_status=1 $v) WHERE a.id = '$bid'";
                                  $res = DB::select($sql);

                                  foreach ($res as $row) {
                                      $carton += $row->amount;
                                  }

                              $row_tot +=$carton;
                              $gen_tot[$br->id] += $carton;
                            @endphp
                            <td>
                               {{ number_format($carton,2) }} Frw
                            </td>
                          @endforeach
                          <td>
                            {{ number_format($row_tot,2) }} Frw
                          </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <th colspan="">
                          Total
                        </th>
                          @php
                            unset($branch);$tt=0;
                         @endphp
                            @foreach ($branches as $branch)
                            @php
                            $tt +=$gen_tot[$branch->id];
                            @endphp
                            <th>{{ number_format($gen_tot[$branch->id],2)." Frw" }}</th>
                            @endforeach
                            <th>{{ number_format($tt,2)." Frw" }}</th>
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
            footer: true
        },
        {
            extend: 'csv',
            footer: true
        },
        {
            extend: 'excel',
            footer: true
        },
        {
            extend: 'pdf',
            footer: true
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
