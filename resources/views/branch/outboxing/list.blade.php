@extends('layouts.admin.app')
@section('page-name')
    List Outboxing
@endsection
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">List Mail Outboxing</h4>

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
                                <h5 class="card-title mb-0">List outboxing List</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">

                                @can('make branchorder')
                                    <a href="{{ route('branch.outboxing.create') }}" class="btn btn-success" id="create-btn">
                                        <i class="ri-add-line align-bottom me-1"></i>Create New
                                    </a>
                                @endcan
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-body table-responsive">
                    <table id="datatable" class="table nowrap table-bordered align-middle" style="width:100%">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th class="sort" data-sort="tracking">Tracking</th>
                                <th class="sort" data-sort="tracking">Type</th>
                                <th class="sort" data-sort="sender">Sender Name</th>
                                <th class="sort" data-sort="sender">Sender Phone</th>
                                <th class="sort" data-sort="receiver">Receiver Name</th>
                                <th class="sort" data-sort="receiver">Receiver Phone</th>
                                <th class="sort" data-sort="country">Country</th>

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
                                    <td class="sender">
                                        @if ($outbox->type == 'ems')
                                            EMS
                                        @elseif ($outbox->type == 'p')
                                            Parcel
                                        @elseif ($outbox->type == 'r')
                                            Registered
                                        @else
                                            Stamps
                                        @endif
                                    <td class="sender">{{ $outbox->snames }}</td>
                                    <td class="sender">{{ $outbox->sphone }}</td>
                                    <td class="receiver">{{ $outbox->rnames }}</td>
                                    <td class="receiver">{{ $outbox->rphone }}</td>
                                    <td class="country">{{ Str::words($outbox->destiny->countryname, 2, ' ...') }}</td>

                                    <td class="action">
                                        @can('make outboxing')
                                            <a href="{{ route('branch.outboxing.print_out', $outbox->id) }}"
                                                class="btn btn-sm btn-info" target="_blank">PRINT</a>
                                                
                                            <a type="button" class="btn btn-primary btn-sm"
                                                href="{{ route('branch.outboxing.edit', $outbox->id) }}"><span>Edit</span></a>

                                            <a href="#deleteRecordModal" data-bs-toggle="modal" type="button"
                                                data-action="{{ route('branch.outboxing.destroy2', $outbox->id) }}"
                                                class="btn btn-danger btn-sm delete-item"><span>Delete</span></a>
                                        @endcan

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                        {{-- <tfoot>
                            <th colspan="4">
                                Today's Income
                            </th>
                            <th id="amount_rep"></th>
                            <th id="carton_rep"></th>
                            <th id="total_rep"></th>
                        </tfoot> --}}
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
@endsection

@section('css')
    <!--datatable css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <!--datatable responsive css-->
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />

    {{-- <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css"> --}}
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

    <script>
        $(document).ready(function() {
            // update item delete modal with clicked button data
            $(document).on('click', '.delete-item', function() {
                // var itemid = $(this).data('itemid');
                var formaction = $(this).data('action');
                $('#deleteitem').attr('action', formaction);
                // $('#itemid').val(itemid);
            });
        });
    </script>

    <!--datatable js-->


    <!--datatable js-->
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#datatable').DataTable();
        });
    </script>
@endsection
