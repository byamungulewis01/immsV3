@extends('layouts.admin.app')
@section('page-name')
    Dispatch Receive
@endsection
@section('body')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">DISPATCH RECEIVING</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS</a>
                        </li>
                        <li class="breadcrumb-item active">Dispatch Receive</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <form action="{{ route('admin.cntp.update') }}" method="post">
            @csrf
            @method('PUT')
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">DISPATCH LIST</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">

                                    <a class="btn btn-soft-primary" style="display: none;" id="deleteBtn"
                                        href="#deleteRecordModal" data-bs-toggle="modal">
                                        Approve Receiving
                                    </a>

                                    <!-- Modal -->
                                    <div class="modal fade zoomIn" id="deleteRecordModal" tabindex="-1" aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <button type="button" class="btn-close" id="deleteRecord-close"
                                                        data-bs-dismiss="modal" aria-label="Close" id="btn-close"></button>
                                                </div>
                                                <div class="modal-body">

                                                    <div class="mt-2 text-center">

                                                        <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                            <h4>Are you sure to Approve Dispatch Receiving ?</h4>
                                                            <p class="text-muted mx-4 mb-0">

                                                            </p>
                                                        </div>
                                                    </div>
                                                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                        <button type="button" class="btn w-sm btn-light"
                                                            data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn w-sm btn-primary"
                                                            id="delete-record">
                                                            Yes, Approve It!
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--end modal -->






                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">

                        <table id="scroll-horizontal" class="table nowrap align-middle" style="width:100%">
                            <thead>
                                <tr>
                                    <th>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll" value="option">
                                        </div>
                                    </th>
                                    <th scope="col">
                                        #
                                    </th>

                                    <th class="sort" data-sort="name">
                                        Dispatch Code
                                    </th>

                                    <th class="sort" data-sort="phone">Gross Weight</th>
                                    <th class="sort" data-sort="branch">Dispatch Type</th>
                                    <th class="sort" data-sort="branch">Number of Item</th>
                                    <th class="sort" data-sort="date">Dispatch Date</th>
                                    <th class="sort" data-sort="status">Status</th>
                                    <th class="sort" data-sort="status">Transfered By</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inboxings as $key => $inboxing)
                                    <tr>
                                        <td scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="dispatchid[]"
                                                    value="{{ $inboxing->id }}">
                                            </div>
                                        </td>
                                        <td scope="row">
                                            {{ $key + 1 }}
                                        </td>
                                        <td class="name">{{ $inboxing->dispatchNumber }}
                                        </td>
                                        <td class="email">{{ $inboxing->grossweight }}</td>

                                        <td class="phone">{{ ($inboxing->dispachetype == 'PERCEL' ? 'Parcel' : $inboxing->dispachetype) }}</td>
                                        <td class="item">{{ $inboxing->numberitem }}</td>



                                        <td class="date"> {{ $inboxing->created_at->format('d M, Y') }}</td>

                                        <td>
                                            @if ($inboxing->status == 0)
                                                <span class="badge bg-warning">Pending</span>
                                            @elseif($inboxing->status == 1)
                                                <span class="badge bg-primary">Transfered</span>
                                            @elseif($inboxing->status == 2)
                                                <span class="badge bg-success">CNTP Approved</span>
                                            @elseif($inboxing->status == 3)
                                                <span class="badge bgp-info">Dispatch Opened</span>
                                            @endif
                                        </td>
                                        <td>{{ $inboxing->ctnp->name }}</td>

                                    </tr>
                                @endforeach
                            </tbody>
                        </table>


                    </div>
                </div>
            </div>
        </form>

        <!--end col-->
    </div>
    <!--end row-->




    <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-light p-3">
                    <h5 class="modal-title" id="exampleModalLabel">Mail Inboxing</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                        id="close-modal"></button>
                </div>
                <form method="post" action="{{ route('admin.inbox.store') }}">
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
                        <div class="mb-3">
                            <label for="customername-field" class="form-label">Dispach Number
                            </label>
                            <input type="text" id="customername-field" name="dispatchNumber" class="form-control"
                                placeholder="Enter Dispach Number" value="{{ old('orgincountry') }}" required />
                            <div class="invalid-feedback">
                                Please enter Orgin Country .
                            </div>

                        </div>



                        <div class="row">
                            <div class="col-md-6 mb-3">

                                <label for="name-field" class="form-label">Gross Weight(kg)</label>
                                <input type="text" id="email-field" class="form-control" name="grossweight"
                                    placeholder="Enter Gross Weight" required value="{{ old('grossweight') }}" />
                                <div class="invalid-feedback">
                                    Please enter grossweight.
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customername-field" class="form-label">Mail Weight(kg)
                                </label>
                                <input type="text" id="customername-field" name="mailweight" class="form-control"
                                    placeholder=" Mail Weight" value="{{ old('mailweight') }}" />
                                <div class="invalid-feedback">
                                    Please enter Mail Weight
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="customername-field" class="form-label">Number of Item
                                </label>
                                <input type="text" id="customername-field" name="numberitem" class="form-control"
                                    placeholder="Enter Number of Item" value="{{ old('numberitem') }}" required />
                                <div class="invalid-feedback">
                                    Please enter numberitem
                                </div>

                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="customername-field" class="form-label">Current Weight
                                </label>
                                <input type="text" id="customername-field" name="currentweight" class="form-control"
                                    placeholder="Current Weight" value="{{ old('currentweighty') }}" />
                                <div class="invalid-feedback">
                                    Please enter current weight
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="status-field" class="form-label">Dispatch Type</label>
                                <select class="form-control" data-choices data-choices-search-false name="dispachetype"
                                    id="status-field" required>
                                    <option value="" disabled selected>Dispatch Type</option>
                                    <option value="EMS">EMS</option>
                                    <option value="PERCEL">PERCEL</option>
                                    <option value="Mails">Mails</option>


                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="name-field" class="form-label">Orgin Country</label>
                                <input type="text" id="email-field" class="form-control" name="orgincountry"
                                    placeholder="Enter Orgin Country" required value="{{ old('orgincountry') }}" />
                                <div class="invalid-feedback">
                                    Please enter orgincountry
                                </div>
                            </div>
                        </div>



                        <div class="mb-3">
                            <label for="VertimeassageInput" class="form-label">Comment</label>
                            <textarea class="form-control" id="VertimeassageInput" name="comment" rows="3"
                                placeholder="Enter your comment"></textarea>

                        </div>

                    </div>
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
        var checkAll = document.getElementById("checkAll");
        var checkboxes = document.querySelectorAll("tbody input[type=checkbox]");
        var deleteBtn = document.getElementById("deleteBtn");

        checkAll.addEventListener("change", function(e) {
            var t = e.target.checked;
            checkboxes.forEach(function(e) {
                e.checked = t;
            });
            toggleDeleteBtn();
        });

        checkboxes.forEach(function(e) {
            e.addEventListener("change", function(e) {
                checkAll.checked = Array.from(checkboxes).every(function(e) {
                    return e.checked;
                });
                toggleDeleteBtn();
            });
        });

        function toggleDeleteBtn() {
            var checkedBoxes = document.querySelectorAll("tbody input[type=checkbox]:checked");
            if (checkedBoxes.length > 0) {
                deleteBtn.style.display = "block";
            } else {
                deleteBtn.style.display = "none";
            }
        }
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
@endsection
