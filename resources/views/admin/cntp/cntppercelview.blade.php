@extends('layouts.admin.app')
@section('page-name')DISPATCH RECEIVING @endsection
@section('body')
@php
    use App\Models\Eric\Transferdetailsout;
    use App\Models\registoutboxing;
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
                                    <th class="sort" data-sort="DATE">DATE</th>
                                    <th class="sort" data-sort="STATUS">STATUS</th>
                                    <th class="sort" data-sort="action">Action</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                    @foreach ($results as $key => $result)
                                    <tr>
                                        <th scope="row">
                                          {{ $key + 1 }}
                            </th>
                            <td class="MAIL CODE">DSP {{ $result->id }}</td>
                            <td class="MAIL CODE">
                                    {{ $result->emplo->name }}</a>
                            </td>



                            <td class="NAME">{{ $result->branches->name }}</td>
                            <td class="PHONE">{{ $result->mnumber }}</td>


                                <td class="date"> {{ $result->created_at->format('d M, Y') }}</td>
                                <td class="status">
                                    @if ($result->status == 0)
                                        <span class="badge bg-warning">Not recieved</span>
                                    @elseif($result->status == 1)
                                        <span class="badge bg-info">Received</span>
                                    @else
                                        <span class="badge bg-success">Opened & verify</span>
                                    @endif
                                </td>
                            <td>
                                @if ($result->status==0)
                                <a href="#standard-modal{{ $result->id }}" data-bs-toggle="modal" type="button"
                                class="btn btn-primary btn-sm"><span>D.RECEIVING</span></a>
                                @elseif($result->status == 1)
                                <button data-bs-toggle="modal"
                                    data-bs-target="#verify{{ $result->id }}"class="btn btn-sm btn-success">Open
                                    & Verify</button>

                                <div class="modal fade" id="verify{{ $result->id }}" tabindex="-1"
                                    aria-hidden="true">
                                    <div class="modal-dialog model-lg">
                                        <div class="modal-content">
                                            <div class="modal-header p-3">
                                                <h5 class="modal-title" id="exampleModalLabel">Opening &
                                                    verify</h5>
                                                <button type="button" class="btn-close"
                                                    data-bs-dismiss="modal" aria-label="Close"
                                                    id="close-modal"></button>
                                            </div>
                                            <form class="tablelist-form row" method="post"
                                                action="{{ route('admin.outtems.verify', $result->id) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-6">
                                                            <label for="weight"
                                                                class="form-label">Weight</label>
                                                            <input type="number" step="0.1"
                                                                id="weight" name="recieced_weight"
                                                                class="form-control" placeholder="0.0"
                                                                value="{{ old('recieced_weight') }}"
                                                                required />

                                                        </div>
                                                        <div class="col-md-6">
                                                            <label for="comment"
                                                                class="form-label">Comment</label>
                                                            <input type="text" id="comment"
                                                                name="cntp_comment" class="form-control"
                                                                placeholder="cntp comment"
                                                                value="{{ old('cntp_comment') }}" />

                                                        </div>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn btn-success">
                                                            Submit
                                                        </button>
                                                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @else
                            @endif

                            <!-- Modal -->
                            <div id="standard-modal{{ $result->id }}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="standard-modalLabel" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">

                                          <form method="post" action="{{ route('admin.outtperc.update',$result->id) }}">
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
                                                            $data = Transferdetailsout::where(
                                                                'trid',
                                                                $result->id,
                                                            )->get();
                                                        @endphp

                                                        @foreach ($data as $key => $item)
                                                            <tr>

                                                                <th scope="row">
                                                                    {{ $key + 1 }}
                                                                </th>
                                                                <input type="hidden" value="{{ $item->out_id }}"
                                                                    name="out_id[]">
                                                                <td>{{ $item->outbox->tracking }} </td>
                                                                <td>{{ $item->outbox->snames }} </td>
                                                                <td>{{ $item->outbox->sphone }}</td>
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
