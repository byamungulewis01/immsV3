@extends('layouts.admin.app')
@section('page-name')Approved Income @endsection
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
            <h4 class="mb-sm-0">Income</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS P.O B</a>
                    </li>
                    <li class="breadcrumb-item active">Approved Income</li>
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
                            <h5 class="card-title mb-0">Approved Income Report | From : {{ $start }} , To : {{ $end }}</h5>
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

                            <th class="sort" data-sort="name">Income Type</th>
                            <th class="sort" data-sort="name">Branch</th>
                            <th class="sort" data-sort="name">Title</th>
                            <th class="sort" data-sort="name">Descriprion</th>
                            <th class="sort" data-sort="name">Amount</th>
                            <th class="sort" data-sort="name">Attachment</th>
                            <th class="sort" data-sort="name">Status</th>
                            <th>Reg Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            //branch id
                            $branch_id = Auth::user()->branch;
                            // echo $branch_id;
                            //get all incomes from incomes model
                            if (auth()->user()->level == "branchManager") {
                                $incomes = App\Models\Incomes::
                                where('branch_id','=',$branch_id)
                                ->where('e_status','=','1')
                                ->whereBetween('created_at', [$start, $end])
                                ->get();
                            }else{
                                $incomes = App\Models\Incomes::
                                where('e_status','=','1')
                                ->whereBetween('created_at', [$start, $end])
                                ->get();
                            }
                            $total_amount = 0;
                        @endphp
                        @foreach ($incomes as $key => $income)
                            @php
                                $total_amount += $income->e_amount;
                            @endphp
                        <tr>
                            <td scope="row">
                                {{ $key + 1 }}
                            </td>
                            <td class="name">
                                @php
                                    //get income_type info from income_type model
                                    $income_type = App\Models\Income_Types::where('et_id', $income->et_id)->first();    
                                @endphp
                                {{ $income_type->et_name }}
                            </td>
                            <td class="name">
                                @php
                                    //get branch info from branch model
                                    $branch = App\Models\Branch::where('id', $income->branch_id)->first();
                                @endphp
                                {{ $branch->name }}
                            </td>
                            <td class="name">
                                {{ $income->e_name }}
                            </td>
                            <td class="name">
                                {{ $income->e_description }}
                            </td>
                            <td class="name">
                                {{ $income->e_amount }}
                            </td>
                            <td class="name">
                                {{-- link to the e_file and extension icon --}}
                                <a href="{{ asset('incomes_files/'.$income->e_file) }}" target="_blank">
                                    <i class="ri-file-text-line align-bottom me-1"></i>
                                    {{ $income->e_file }} 
                                </a>
                            </td>
                            <td class="name">
                                @php
                                // 1 = approved
                                // 2 = pending
                                // 3 = rejected
                                //with bootsrap colors display status
                                if($income->e_status == 1){
                                    echo '<span class="badge bg-success">Approved</span>';
                                }elseif($income->e_status == 2){
                                    echo '<span class="badge bg-warning">Pending</span>';
                                }elseif($income->e_status == 3){
                                    echo '<span class="badge bg-danger">Rejected</span>';
                                }
                                @endphp
                            </td>
                            {{-- reg date --}}
                            <td>
                                {{ $income->created_at->format('d/m/Y H:i:s') }}
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5" class="text-end">Total : </th>
                            <th>{{ $total_amount }}</th>
                            <th colspan="2"></th>
                        </tr>
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

@can('update income')
<!-- Modal -->
<div class="modal fade zoomIn" id="updatemodal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5>Edit Income</h5>
                <button type="button" class="btn-close" id="updatemodal-close" data-bs-dismiss="modal"
                    aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">
                <form method="post" id="itemupdate" action="#" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
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
                    
                    
                    {{-- income type from types model--}}
                    <div class="mb-3">
                        <label for="et_id" class="form-label">
                            Income Type
                            </label>
                        <select class="form-select" name="et_id" id="et_id">
                            <option selected>Select Income Type</option>
                            @foreach($income_types as $type)
                            <option value="{{ $type->et_id }}">{{ $type->et_name }}</option>
                            @endforeach
                        </select>
                        <div class="invalid-feedback">
                            Please Select Income Type.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="e_name" class="form-label">
                            Title
                            </label>
                        <input type="text" id="e_name" name="e_name"
                            class="form-control" placeholder="Title"
                            value="{{ old('e_name') }}" required />
                        <div class="invalid-feedback">
                            Please enter title.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="e_description" class="form-label">
                            Description
                            </label>
                        <input type="text" id="e_description" name="e_description"
                            class="form-control" placeholder="Description"
                            value="{{ old('e_description') }}" required />
                        <div class="invalid-feedback">
                            Please enter Descriprion.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="e_amount" class="form-label">
                            Amount
                            </label>
                        <input type="text" id="e_amount" name="e_amount"
                            class="form-control" placeholder="Amount"
                            value="{{ old('e_amount') }}" required />
                        <div class="invalid-feedback">
                            Please enter Descriprion.
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="e_file" class="form-label">
                            Attachment
                            </label>
                        <input type="file" id="e_file" name="e_file"
                            class="form-control" placeholder="Attachment"
                            value="{{ old('e_file') }}" />
                        <div class="invalid-feedback">
                            Please Select Attachment.
                        </div>
                    </div>
                
            </div>
            <div class="modal-footer">
                <div class="hstack gap-2 justify-content-end">
                    <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                        Close
                    </button>
                    <button type="submit" class="btn btn-success" id="add-btn">
                        Save Item Info
                    </button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>
<!--end modal -->

@endcan

<!-- Modal -->
<div class="modal fade zoomIn" id="approveRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" id="approveRecord-close" data-bs-dismiss="modal"
                    aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="approveitem" method="post" action="#">
                    @csrf
                    @method('PUT')
                    <div class="mt-2 text-center">
                        
                        <i class=" ri-checkbox-line ri-xl" style="height: 100px;width: 100px;"></i>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">
                                Are you sure you want to Approve this record ?
                            </p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn w-sm btn-success" id="approve-record">
                            Yes, Approve It!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!--end modal -->

<!-- Modal -->
<div class="modal fade zoomIn" id="rejectRecordModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="btn-close" id="rejectRecord-close" data-bs-dismiss="modal"
                    aria-label="Close" id="btn-close"></button>
            </div>
            <div class="modal-body">
                <form id="rejectitem" method="post" action="#">
                    @csrf
                    @method('PUT')
                    <div class="mt-2 text-center">
                        <i class=" ri-close-circle-line ri-xl" style="height: 100px;width: 100px;"></i>
                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                            <h4>Are you sure ?</h4>
                            <p class="text-muted mx-4 mb-0">
                                Are you sure you want to Reject this record ?
                            </p>
                        </div>
                    </div>
                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                        <button type="button" class="btn w-sm btn-light" data-bs-dismiss="modal">
                            Close
                        </button>
                        <button type="submit" class="btn w-sm btn-danger" id="reject-record">
                            Yes, Reject It!
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
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
<script>
    // check if data loaded fully
    $(document).ready(function () {
        
        // update item delete modal with clicked button data
        $(document).on('click', '.delete-item', function () {
            // var itemid = $(this).data('itemid');
            var formaction = $(this).data('action');
            $('#deleteitem').attr('action', formaction);
            // $('#itemid').val(itemid);
        });
        $(document).on('click', '.approve-item', function () {
            // var itemid = $(this).data('itemid');
            var formaction = $(this).data('action');
            $('#approveitem').attr('action', formaction);
            // $('#itemid').val(itemid);
        });
        $(document).on('click', '.reject-item', function () {
            // var itemid = $(this).data('itemid');
            var formaction = $(this).data('action');
            $('#rejectitem').attr('action', formaction);
            // $('#itemid').val(itemid);
        });
        
        // update updateitem modl with clicked button data
        $(document).on('click', '.edit-item', function () {
            var et_id = $(this).data('et_id');
            var e_name = $(this).data('e_name');
            var e_description = $(this).data('e_description');
            var e_amount = $(this).data('e_amount');
            var formaction = $(this).data('action');
            $('#itemupdate').attr('action', formaction);
            $('#itemupdate #et_id').val(et_id);
            $('#itemupdate #e_name').val(e_name);
            $('#itemupdate #e_description').val(e_description);
            $('#itemupdate #e_amount').val(e_amount);
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
