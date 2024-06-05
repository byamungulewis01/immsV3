@extends('layouts.admin.app')
@section('page-name')DISPATCH RECEIVING @endsection
@section('body')
@php
    use App\Models\Eric\Transferdetailsout;
    use App\Models\Outboxing;
    use App\Models\Eric\Transferout;

@endphp

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"> DISPATCH OUTBOXING RECEIVING</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS</a>
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
        <div class="card" id="customerList">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">

                        <h5 class="card-title mb-0">DISPATCH OUTBOXING RECEIVING</h5>

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
            <div class="card-body">
                <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col" style="width: 80px">
                                        #
                                    </th>
                                    <th class="sort" data-sort="FROM">
                                        DISPATCH CODE
                                    </th>
                                    <th class="sort" data-sort="FROM">
                                        FROM
                                    </th>

                                    <th class="sort" data-sort="BRANCH">TO BRANCH</th>
                                    <th class="sort" data-sort="PHONE">MAIL NUMBER</th>
                                    <th class="sort" data-sort="PHONE">MAIL TYPE</th>
                                    <th class="sort" data-sort="DATE">DATE</th>
                                    <th class="sort" data-sort="action">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                    @foreach ($results as $key => $result)
                                    <tr>
                                        <th scope="row">
                                          {{ $key + 1 }}
                            </th>
                            <td class="MAIL CODE"> <a target="_blank"  href="print/mailtransfer.php"> <button  class="btn btn-dark waves-effect waves-light">DSP {{ $result->id }}</button>
                          </td>
                            <td class="MAIL CODE"><a
                                    href="{{ route('admin.mails.update',$result->id) }}">{{ $result->emplo->name }}</a>
                            </td>



                            <td class="NAME">{{ $result->branches->name }}</td>

                            <td class="PHONE">{{ $result->mnumber }}</td>

                            <td class="PHONE">{{strtoupper( $result->mailtype )}}</td>

                                <td class="date"> {{ $result->created_at->format('d M, Y') }}</td>

                            <td>
                                @if ($result->status==0)
                                <a href="#standard-modal{{ $result->id }}" data-bs-toggle="modal" type="button"
                                class="btn btn-primary btn-sm"><span>D.RECEIVING</span></a>
                                @else
                                <span class="badge bg-success">Received</span>
                                @endif

                            <!-- Modal -->
                            <div id="standard-modal{{ $result->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">

                                          <form method="post" action="{{ route('admin.outttem.update',$result->id) }}">
                                            @csrf
                                            @method('PUT')
                                        <div class="modal-header">
                                            <h4 class="modal-title" id="standard-modalLabel">DISPATCH  RECEIVING (DSP{{ $result->id }}) </h4>

                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                                        </div>
                                        <div class="modal-body">




                                            <table class="table table-centered mb-0">
                                                <tr >
                                                        <th >#</th>
                                                         <th >TRACKING NUMBER</th>
                                                        <th >NAMES</th>
                                                        <th >PHONE</th>

                                                            </tr>
                                                            @php

                                                            $data = DB::table('tembleoutboxing')
        ->join('transferdetailsouts', 'tembleoutboxing.out_id', '=', 'transferdetailsouts.out_id')
        ->where('transferdetailsouts.trid', $result->id)
        ->get();
                                                             @endphp

                                                  @foreach($data as $key => $item)
                                                            <tr>

                                                                <th scope="row">
                                                                    {{ $key + 1 }}
                                                    </th>
                                                    <input type="hidden" value="{{ $item->out_id }}" name="out_id[]">
                                                            <td >{{ $item->tracking }} </td>
                                                           <td >{{ $item->snames }} </td>
                                                          <td >{{ $item->sphone }}</td>

                                                          @endforeach
                                                    </tr>




                                                               <tr>

                                               <td colspan="3"><b>TOTAL  NUMBER OF MAIL {{ $result->mnumber }} </b>  </td>
                                               <td> <b> </b>
                                                   <br>


                                                           </td>



                                               </tr>


                                                </table>


                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">D Receiving</button>

                                             <input name='number' value="" type='hidden'>
                                        </div>

                                        </form>
                                    </div><!-- /.modal-content -->
                                </div><!-- /.modal-dialog -->
                            </div><!-- /.modal -->
                            <!--end modal -->


                                <!--end modal -->
                            </td>
                            </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>





            </div>
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
