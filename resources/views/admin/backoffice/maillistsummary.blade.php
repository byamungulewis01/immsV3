@extends('layouts.admin.app')
@section('page-name')MAIL LIST @endsection
@section('body')
@php
    use Carbon\Carbon;

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
$link = "?rep=".urlencode($linker)."";
// inboxing set up

$start = Carbon::parse($start);
$end = Carbon::parse($end);
// $inboxings = $inboxings->where('created_at', '>=', $start)
// ->where('created_at', '<=', $end)
// ->orderBy('id', 'desc')->get();
$registered = $registered->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end)->count();
$transfered = $transfered->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end)->count();
$notified = $notified->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end)->count();
$available = $available->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end)->count();
$delived = $delived->where('created_at', '>=', $start)
                ->where('created_at', '<=', $end)->count();

$start = date_format(date_create($start),"Y-m-d");
$end = date_format(date_create($end),"Y-m-d");

@endphp
<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">INBOXING List</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS</a>
                    </li>
                    <li class="breadcrumb-item active">MAIL LIST</li>
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
                            <h5 class="card-title mb-0"></h5>
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
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div>
                            <h5 class="card-title mb-0">INBOXING MAILs List | From : {{ $start }} , To : {{ $end }}</h5>
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
                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                    <thead>
                        <tr>
                            <th scope="col">
                                #
                            </th>
                            <th class="sort" data-sort="type">Mail type</th>
                            <th class="sort" data-sort="count">Count</th>
                            <th class="sort" data-sort="action">Action</th>
                        </tr>
                    </thead>
                    <tbody class="list form-check-all">
                        <tr>
                            <th scope="row">
                                1
                            </th>
                            <th class="type">Registered Mails</th>
                            <td class="count">{{ $registered }}</td>
                            <td class="action">
                                <a href="{{ route('admin.list.detail', 0) }}{{ $link }}&title={{ base64_encode("Registered Mails") }}" class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                2
                            </th>
                            <th class="type">Transfered Mails</th>
                            <td class="count">{{ $transfered }}</td>
                            <td class="action">
                                <a href="{{ route('admin.list.detail', 1) }}{{ $link }}&title={{ base64_encode("Transfered Mails") }}" class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                3
                            </th>
                            <th class="type">Notified Mails</th>
                            <td class="count">{{ $notified }}</td>
                            <td class="action">
                                <a href="{{ route('admin.list.detail', 2) }}{{ $link }}&title={{ base64_encode("Notified Mails") }}" class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                3
                            </th>
                            <th class="type">RCNS/Available Mails</th>
                            <td class="count">{{ $available }}</td>
                            <td class="action">
                                <a href="{{ route('admin.list.detail', 2) }}{{ $link }}&title={{ base64_encode("RCNS/Available Mails") }}" class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                        <tr>
                            <th scope="row">
                                4
                            </th>
                            <th class="type">Delived Mails</th>
                            <td class="count">{{ $available }}</td>
                            <td class="action">
                                <a href="{{ route('admin.list.detail', 3) }}{{ $link }}&title={{ base64_encode("Delived Mails") }}" class="btn btn-primary btn-sm">View</a>
                            </td>
                        </tr>
                    </tbody>
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

<!-- Modal -->

<!--end modal -->

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


<!--open editUser model js-->
<script>
    var office = document.querySelector('.office');
    var level = document.querySelector('.level');
    var driverDiv = document.querySelector('.driverDiv');
    level.addEventListener("change", function () {
        if (level.value == 'register') {
            office.disabled = false;
            office.required = true;
            driverDiv.style.display = 'none';
        } else if (level.value == 'driver') {
            office.disabled = true;
            office.required = false;
            driverDiv.style.display = 'block';
        } else {
            office.disabled = true;
            office.required = false;
            driverDiv.style.display = 'none';
        }
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

<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

@endsection
