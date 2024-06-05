@extends('layouts.admin.app')
@section('page-name')
    Income
@endsection
@section('body')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">Income</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS Mails</a>
                        </li>
                        <li class="breadcrumb-item active">Other Service Income</li>
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
                                <h5 class="card-title mb-0">Other Service Income List</h5>
                            </div>
                        </div>
                        <div class="col-sm-auto">
                            <div class="d-flex flex-wrap align-items-start gap-2">
                                <button class="btn btn-soft-danger" id="remove-actions" onClick="deleteMultiple()">
                                    <i class="ri-delete-bin-2-line"></i>
                                </button>
                                @can('create income')
                                    <button type="button" class="btn btn-success add-btn" data-bs-toggle="modal"
                                        id="create-btn" data-bs-target="#showModal">
                                        <i class="ri-add-line align-bottom me-1"></i> New Other Service
                                        Income
                                    </button>
                                    <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog model-lg">
                                            <div class="modal-content">
                                                <div class="modal-header p-3">
                                                    <h5 class="modal-title" id="exampleModalLabel">New Other Service Income
                                                        Registration</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                        aria-label="Close" id="close-modal"></button>
                                                </div>
                                                <form class="tablelist-form" method="post"
                                                    action="{{ route('admin.income.store') }}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            @if ($errors->any())
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
                                                        {{-- income type from types model --}}
                                                        <div class="mb-3">
                                                            <label for="et_id" class="form-label">
                                                                Income Type
                                                            </label>
                                                            <select class="form-select" name="et_id" id="et_id">
                                                                <option selected>Select Income Type</option>
                                                                @foreach ($income_types as $type)
                                                                    <option value="{{ $type->et_id }}">{{ $type->et_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            <div class="invalid-feedback">
                                                                Please Select Income Type.
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

                                                    </div>
                                                    <div class="modal-footer">
                                                        <div class="hstack gap-2 justify-content-end">
                                                            <button type="button" class="btn btn-light"
                                                                data-bs-dismiss="modal">
                                                                Close
                                                            </button>
                                                            <button type="submit" class="btn btn-success" id="add-btn">
                                                                Save Income
                                                            </button>
                                                            <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                @endcan

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
                        <thead>
                            <tr>
                                <th scope="col">
                                    #
                                </th>
                                <th>Reg Date</th>
                                <th class="sort" data-sort="name">Income Type</th>
                                <th class="sort" data-sort="name">Branch</th>
                                <th class="sort" data-sort="name">Amount</th>
                                <th class="sort" data-sort="name">Status</th>
                                <th class="sort" data-sort="action">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($incomes as $key => $income)
                                <tr>
                                    <td scope="row">
                                        {{ $key + 1 }}
                                    </td>
                                    <td>
                                        {{ $income->created_at->format('d/m/Y H:i:s') }}
                                    </td>
                                    <td class="name">

                                        {{ $income->income_type->et_name }}
                                    </td>
                                    <td class="name">

                                        {{ $income->branch->name }}
                                    </td>

                                    <td class="name">
                                        {{ $income->e_amount }}
                                    </td>
                                    <td class="name">
                                        @if ($income->e_status == 1)
                                            <span class="badge bg-success">Aprroved</span>
                                        @elseif($income->e_status == 2)
                                            <span class="badge bg-warning">Pending</span>
                                        @else
                                            <span class="badge bg-danger">Rejected</span>
                                        @endif
                                    </td>
                                    {{-- reg date --}}

                                    <td>
                                        @if ($income->e_status == 2)
                                            @can('update income')
                                                <a type="button" class="btn btn-primary btn-sm edit-item"
                                                    data-et_id="{{ $income->et_id }}"
                                                    data-branch_id="{{ $income->branch_id }}"
                                                    data-e_amount="{{ $income->e_amount }}"
                                                    data-e_status="{{ $income->e_status }}"
                                                    data-action="{{ route('admin.income.update', $income->e_id) }}"
                                                    data-bs-toggle="modal" data-bs-target="#updatemodal"><span>Edit</span></a>
                                            @endcan

                                            @can('delete income')
                                                <a href="#deleteRecordModal" data-bs-toggle="modal" type="button"
                                                    data-action="{{ route('admin.income.destroy', $income->e_id) }}"
                                                    class="btn btn-danger btn-sm delete-item"><span>Delete</span></a>
                                            @endcan

                                            @can('approve income')
                                                <a href="#approveRecordModal" data-bs-toggle="modal" type="button"
                                                    data-e_amount="{{ $income->e_amount }}"
                                                    data-action="{{ route('admin.income.approve', $income->e_id) }}"
                                                    class="btn btn-success btn-sm approve-item"><span>Approve</span></a>
                                            @endcan

                                            @can('reject income')
                                                <a href="#rejectRecordModal" data-bs-toggle="modal" type="button"
                                                    data-action="{{ route('admin.income.reject', $income->e_id) }}"
                                                    class="btn btn-danger btn-sm reject-item"><span>Reject</span></a>
                                            @endcan
                                        @endif

                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
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
                                colors="primary:#f7b84b,secondary:#f06548"
                                style="width: 100px; height: 100px"></lord-icon>
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
                                @if ($errors->any())
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


                            {{-- income type from types model --}}
                            <div class="mb-3">
                                <label for="et_id" class="form-label">
                                    Income Type
                                </label>
                                <select class="form-select" name="et_id" id="et_id">
                                    <option selected>Select Income Type</option>
                                    @foreach ($income_types as $type)
                                        <option value="{{ $type->et_id }}">{{ $type->et_name }}</option>
                                    @endforeach
                                </select>
                                <div class="invalid-feedback">
                                    Please Select Income Type.
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="e_amount" class="form-label">
                                    Amount
                                </label>
                                <input type="text" id="e_amount" name="e_amount" class="form-control"
                                    placeholder="Amount" value="{{ old('e_amount') }}" required />
                                <div class="invalid-feedback">
                                    Please enter Descriprion.
                                </div>
                            </div>


                    </div>
                    <div class="modal-footer">
                        <div class="hstack gap-2 justify-content-end">
                            <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                Close
                            </button>
                            <button type="submit" class="btn btn-success" id="add-btn">
                                Save Income
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
                        <div class="mb-3">
                            <label for="e_amount" class="form-label">
                                Amount To Approve
                            </label>
                            <input type="text" id="e_amount_approve" name="e_amount" class="form-control"
                                placeholder="Amount" value="{{ old('e_amount') }}" required />
                            <div class="invalid-feedback">
                                Please enter Descriprion.
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

    <script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>
    <script>
        // check if data loaded fully
        $(document).ready(function() {
            // update item delete modal with clicked button data
            $(document).on('click', '.delete-item', function() {
                // var itemid = $(this).data('itemid');
                var formaction = $(this).data('action');
                $('#deleteitem').attr('action', formaction);
                // $('#itemid').val(itemid);
            });
            $(document).on('click', '.approve-item', function() {
                // var itemid = $(this).data('itemid');
                var amtt = $(this).data('e_amount');
                var formaction = $(this).data('action');
                $('#approveitem').attr('action', formaction);
                $('#e_amount_approve').val(amtt);
                // $('#itemid').val(itemid);
            });
            $(document).on('click', '.reject-item', function() {
                var formaction = $(this).data('action');
                $('#rejectitem').attr('action', formaction);
            });

            // update updateitem modl with clicked button data
            $(document).on('click', '.edit-item', function() {
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
    </script>
@endsection
