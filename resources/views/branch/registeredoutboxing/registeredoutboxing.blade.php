@extends('layouts.admin.app')
@section('page-name')
REGISTERED SMALL PACKET Transfer
@endsection
@section('css')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.2.9/css/responsive.bootstrap.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.2.2/css/buttons.dataTables.min.css">
@endsection
@section('body')

    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            @foreach ($bra as $key => $bras)
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">

                <h4 class="mb-sm-0">TOTAL REGISTERED SMALL PACKET IN {{ $bras->name }}  BRANCH NOT TRANSFERED {{ $count }}</h4>
              @endforeach
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
        <form class="tablelist-form" id="myForm" method="post" action="{{ route('branch.registeredoutboxing.updatetrareg') }}">
            @csrf
            @method('PUT')

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">

                                <div>
                                    <h5 class="card-title mb-0">REGISTERED SMALL PACKET Transfer List</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <button class="btn btn-soft-danger" style="display: none;" id="deleteBtn"
                                        data-bs-toggle="modal" data-bs-target="#showModals">

                                        Transfer To CNTP
                                    </button>





                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <table id="datatableAjax" class="table table-centered table-hover align-middle table-nowrap mb-0"
                            style="width: 100%;">
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

                                    <th class="sort" data-sort="tracking">Tracking</th>
                                    <th class="sort" data-sort="sender">Sender</th>
                                    <th class="sort" data-sort="receiver">Receiver</th>
                                    <th class="sort" data-sort="country">Country</th>
                                    <th class="sort" data-sort="weight">weight</th>
                                    <th class="sort" data-sort="amount">Amount</th>
                                    <th class="sort" data-sort="status">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($inboxings as $key => $inboxing)
                                    <tr>
                                        @if ($inboxing->status ==1)
                                        <td scope="row">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" name="out_id[]"
                                                    value="{{ $inboxing->out_id }}">
                                            </div>
                                        </td>
                                        @else
                                        <td scope="row">
                                            <div class="form-check">
                                                <span class="badge bg-info">Completed Transfer</span>
                                            </div>
                                        </td>
                                    @endif


                                        <td scope="row">
                                            {{ $key + 1 }}
                                        </td>
                                        <td class="tracking">{{ $inboxing->tracking }}</td>
                                        <td class="sender">{{ $inboxing->snames }}</td>
                                        <td class="receiver">{{ $inboxing->rnames }}</td>
                                        <td class="country">{{ $inboxing->c_id}}</td>
                                        <td class="weight">{{ $inboxing->weight." ".$inboxing->unit }}</td>
                                        <td class="amount">{{ number_format($inboxing->amount + $inboxing->postage) }}</td>
                                        <td>
                                            @if ($inboxing->status == 1)
                                                <span class="badge bg-warning">Not Sending</span>
                                            @elseif($inboxing->status == 2)
                                                <span class="badge bg-success">Waiting CNTP Approve</span>
                                            @elseif($inboxing->status == 3)
                                                <span class="badge bg-primary">Approved By CNTP</span>
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
</form>

    <!-- Modal -->




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
