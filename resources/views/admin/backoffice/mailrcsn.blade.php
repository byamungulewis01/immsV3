@extends('layouts.admin.app')
@section('page-name')
    DISPATCH RECEIVING
@endsection
@section('body')
    @php
        use App\Models\Eric\Transferdatails;
        use App\Models\Eric\Inboxing;

    @endphp

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"> RCS & Notification</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS Mail Receiving</a>
                        </li>
                        <li class="breadcrumb-item active"> RCS & Notification</li>
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

                            <h5 class="card-title mb-0">MAIL RECEIVING/CHECKING/SHELF/NOTIFICATION</h5>

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
                                    S.DATE
                                </th>

                                <th class="sort" data-sort="BRANCH">R.DATE</th>
                                <th class="sort" data-sort="PHONE">TOTAL/ RCSN MAIL NUMBER</th>

                                <th class="sort" data-sort="action">RCSN ACTION</th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach ($results as $key => $result)
                                <tr>
                                    <th scope="row">
                                        {{ $key + 1 }}
                                    </th>
                                    <td class="MAIL CODE"> DSP {{ $result->id }}</button>
                                    </td>

                                    <td class="NAME">{{ $result->created_at }}</td>


                                    <td class="NAME">{{ $result->rvdate }}</td>

                                    <td class="PHONE">{{ $result->mnumber }}
                                        /{{ $rc1 = DB::table('inboxings')->join('transferdatails', 'inboxings.id', '=', 'transferdatails.inid')->where('transferdatails.trid', $result->id)->where('inboxings.instatus', '3')->count() }}
                                    </td>


                                    <td>
                                        @php
                                            $tumaze = $rc1 + 1;
                                            if ($tumaze == $result->mnumber) {
                                                $closes = 1;
                                            } else {
                                                $closes = 0;
                                            }
                                        @endphp

                                        @if ($rc1 == $result->mnumber)
                                            <!-- Modal -->
                                            <a href="#deleteRecordModal{{ $result->id }}" data-bs-toggle="modal"
                                                type="button" class="btn btn-danger btn-sm"><span>DSP.CLOSE</span></a>

                                            <!-- Modal -->
                                            <div class="modal fade zoomIn" id="deleteRecordModal{{ $result->id }}"
                                                tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <button type="button" class="btn-close" id="deleteRecord-close"
                                                                data-bs-dismiss="modal" aria-label="Close"
                                                                id="btn-close"></button>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form method="post"
                                                                action="{{ route('admin.mrcsn.update', $result->id) }}">
                                                                @csrf
                                                                @method('PUT')

                                                                <div class="mt-2 text-center">

                                                                    <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                                        <h4>Are you sure ?</h4>
                                                                        <p class="text-muted mx-4 mb-0">
                                                                            Are you sure you want to Close this Dispatch
                                                                            <b><u>DSP{{ $result->id }}</u> </b> ?
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                                <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                                    <button type="button" class="btn w-sm btn-light"
                                                                        data-bs-dismiss="modal">
                                                                        Close
                                                                    </button>
                                                                    <button type="submit" class="btn w-sm btn-danger"
                                                                        id="delete-record">
                                                                        Yes, Close It!
                                                                    </button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--end modal -->
                                        @else
                                            <a
                                                href="{{ route('admin.mrcsn.rcsnotification', ['id' => encrypt($result->id)]) }}"><button
                                                    type="button" class="btn btn-secondary">
                                                    MAIL RCSN</button></a>
                                        @endif








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
    @if ($errors->any())
        <script>
            var myModal = new bootstrap.Modal(document.getElementById('showModal'), {
                keyboard: false
            })
            myModal.show()
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $(".phoneNumber").on("input", function() {
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

    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
@endsection
