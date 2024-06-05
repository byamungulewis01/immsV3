@extends('layouts.admin.app')
@section('page-name')Mail Transfer @endsection
@section('body')

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Posting With Temble Mail Transfer</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS Mail Transfer</a>
                    </li>
                    <li class="breadcrumb-item active">Posting With Temble  Mail Tranfer</li>
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
                        @foreach ($bras as $key => $bra)
                        <h5 class="card-title mb-0"Posting With Temble  MAIL TRANSFER LIST IN  {{ $bra->name }} BRANCH</h5>

                    </div>
                    <div class="col-sm-auto">
                        <div class="d-flex flex-wrap align-items-start gap-2">
                            <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                <i class="ri-delete-bin-2-line"></i>
                           </button>
                            <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal" id="create-btn"
                                data-bs-target="#showModal">
                                <i class="ri-add-line align-bottom me-1"></i>Posting With Temble  Transfer
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
                <div>

                        <table id="datatableAjax" class="table table-centered table-hover align-middle table-nowrap mb-0"
                            style="width: 100%;">
                            <thead class="table-light text-muted">
                                <tr>
                                    <th scope="col" style="width: 80px">
                                        #
                                    </th>

                                    <th class="sort" data-sort="FROM">
                                        FROM
                                    </th>

                                    <th class="sort" data-sort="BRANCH">TO BRANCH</th>
                                    <th class="sort" data-sort="PHONE">MAIL NUMBER</th>
                                    <th class="sort" data-sort="DATE">DATE</th>
                                    <th class="sort" data-sort="action">status</th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                    @foreach ($results as $key => $result)
                                    <tr>
                                        <th scope="row">
                                            {{ $key + 1 }}
                            </th>
                            <td class="MAIL CODE"><a
                                    href="{{ route('admin.mails.update',$result->id) }}">{{ $result->emplo->name }}</a>
                            </td>
                            <td class="NAME">{{ $result->branches->name }}</td>
                            <td class="PHONE">{{ $result->mnumber }}</td>
                            <td class="date"> {{ $result->created_at->format('d M, Y') }}</td>
                            <td>
                                @if ($result->status == 0)
                                    <span class="badge bg-warning">Waiting CNTP Approve</span>
                                @elseif($result->status == 1)
                                    <span class="badge bg-info">Approved By CNTP</span>
                                      @endif
                            </td>

                            </tr>
                            @endforeach


                            </tbody>
                        </table>
                    </div>
                <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-lg">
                        <div class="modal-content">
                            <div class="modal-header bg-light p-3">
                                <h5 class="modal-title" id="exampleModalLabel">ARE YOU SURE TO TRANSFER PERCEL  IN KIGALI BRANCH </h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                    id="close-modal"></button>
                            </div>
                            @endforeach
                            <form method="post" action="{{ route('admin.outtte.store') }}">

                                @csrf


                                <table class="table table-centered mb-0">
                                    <tr>

                                        <td colspan="2"> NUMBER OF MAILS FORM </td>
                                        <td>{{ $count }}
                                            <br>


                                        </td>

                                    </tr>
                                    <tr>
                                        <th>#</th>
                                        <th>NAMES</th>
                                        <th>PHONE</th>

                                        @foreach ($inboxings as $key => $inboxing)
                                    </tr>

                                    <tr>
                                        <input type="hidden" value="{{ $inboxing->out_id }}" name="out_id[]">
                                        <input type="hidden" value="{{ $inboxing->weight }}" name="weight[]">


                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $inboxing->snames }}</td>
                                        <td>{{ $inboxing->sphone }}</td>
                                    </tr>

                                    @endforeach

                                    <tr>





                                    </tr>

                                </table>
                                <div class="modal-footer">
                                    <div class="hstack gap-2 justify-content-end">
                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                            Close
                                        </button>
                                        <button type="submit" class="btn btn-success" id="add-btn">
                                            Save
                                        </button>
                                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
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
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/dataTables.buttons.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.2.2/js/buttons.html5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script>
    $(document).ready(function() {
        $('#datatableAjax').DataTable({
            processing: true,


        });
    });
</script>
@endsection
