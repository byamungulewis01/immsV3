@extends('layouts.admin.app')
@section('page-name')
    Dispatch Sorting
@endsection
@section('body')
    <!-- start page title -->
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0">DISPATCH SORTING</h4>

                <div class="page-title-right">
                    <ol class="breadcrumb m-0">
                        <li class="breadcrumb-item">
                            <a href="javascript: void(0);">IMMS</a>
                        </li>
                        <li class="breadcrumb-item active">Dispatch Sortings</li>
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
                                <h5 class="card-title mb-0">DISPATCH LIST</h5>
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
                                <th class="sort" data-sort="name">
                                    Dispatch Code
                                </th>
                                <th class="sort" data-sort="phone">Gross Weight</th>
                                <th class="sort" data-sort="date">Current Weight</th>
                                <th class="sort" data-sort="date">Date Received</th>
                                <th class="sort" data-sort="status">Status</th>
                                <th class="sort" data-sort="date">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($inboxings as $key => $inboxing)
                                <tr>
                                    <td scope="row">
                                        {{ $key + 1 }}
                                    </td>
                                    <td class="name">{{ $inboxing->dispatchNumber }}
                                    </td>
                                    <td class="email">{{ $inboxing->grossweight }}</td>

                                    <td class="phone">{{ $inboxing->currentweight }}</td>
                                    <td class="date"> {{ $inboxing->opened_date }}</td>
                                    <td>
                                        @if ($inboxing->status == 2)
                                            <span class="badge bg-primary">Dispatch Opened</span>
                                        @elseif ($inboxing->status == 3)
                                            <span class="badge bg-info">Dispatch Sort Completed</span>
                                        @endif
                                    </td>
                                    <td>
                                        @if ($inboxing->status == 2)
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#staticBackdrop">View</button>
                                            <a href="{{ route('admin.cntpsort.sortingallmailsview', ['id' => encrypt($inboxing->id)]) }}"
                                                type="button" class="btn btn-primary btn-sm"><span>Dispatch Sort</span></a>
                                        @elseif ($inboxing->status == 3)
                                            <button type="button" class="btn btn-success btn-sm" data-bs-toggle="modal"
                                                data-bs-target="#staticBackdrop">View</button>
                                        @endif
                                        <div class="modal fade" id="staticBackdrop" data-bs-backdrop="static"
                                            data-bs-keyboard="false" tabindex="-1" role="dialog"
                                            aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-body p-5">

                                                        <div class="mt-4">
                                                            <h3 class="mb-3 text-center">Dispacher Status</h3>

                                                            <div class="profile-timeline">
                                                                <div class="accordion accordion-flush"
                                                                    id="accordionFlushExample">
                                                                    <div class="accordion-item border-0">
                                                                        <div class="accordion-header" id="headingOne">
                                                                            <a class="accordion-button p-2 shadow-none"
                                                                                data-bs-toggle="collapse"
                                                                                href="#collapseOne" aria-expanded="true"
                                                                                aria-controls="collapseOne">
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="flex-shrink-0 avatar-xs">
                                                                                        <div
                                                                                            class="avatar-title bg-success rounded-circle">
                                                                                            <i
                                                                                                class="ri-shopping-bag-line"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-3">
                                                                                        <h6 class="fs-15 mb-0 fw-semibold">
                                                                                            Dispached By- <span
                                                                                                class="fw-normal">{{ $inboxing->ctnp->name }}</span>
                                                                                        </h6>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <div id="collapseOne"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="headingOne"
                                                                            data-bs-parent="#accordionExample"
                                                                            style="">
                                                                            <div class="accordion-body ms-2 ps-5 pt-0">
                                                                                <h6 class="mb-1">Dispacher Registered Date
                                                                                </h6>
                                                                                <p class="text-muted mb-0">
                                                                                    {{ $inboxing->created_at->format('l, d M Y - H:m') }}
                                                                                </p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="accordion-item border-0">
                                                                        <div class="accordion-header" id="headingTwo">
                                                                            <a class="accordion-button p-2 shadow-none"
                                                                                data-bs-toggle="collapse"
                                                                                href="#collapseTwo" aria-expanded="false"
                                                                                aria-controls="collapseTwo">
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="flex-shrink-0 avatar-xs">
                                                                                        <div
                                                                                            class="avatar-title bg-success rounded-circle">
                                                                                            <i
                                                                                                class="mdi mdi-gift-outline"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-3">
                                                                                        <h6 class="fs-15 mb-1 fw-semibold">
                                                                                            Transfered By - <span
                                                                                                class="fw-normal">{{ $inboxing->ctnp->name }}</span>
                                                                                        </h6>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <div id="collapseTwo"
                                                                            class="accordion-collapse collapse"
                                                                            aria-labelledby="headingTwo"
                                                                            data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body ms-2 ps-5 pt-0">
                                                                                <h6 class="mb-1">Dispacher Transfered
                                                                                    Date</h6>
                                                                                <p class="text-muted mb-0">
                                                                                    {{ $inboxing->transfer_date }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="accordion-item border-0">
                                                                        <div class="accordion-header" id="headingThree">
                                                                            <a class="accordion-button p-2 shadow-none"
                                                                                data-bs-toggle="collapse"
                                                                                href="#collapseThree"
                                                                                aria-expanded="false"
                                                                                aria-controls="collapseThree">
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="flex-shrink-0 avatar-xs">
                                                                                        <div
                                                                                            class="avatar-title bg-success rounded-circle">
                                                                                            <i
                                                                                                class="ri-shopping-bag-line"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-3">
                                                                                        <h6 class="fs-15 mb-1 fw-semibold">
                                                                                            Dispacher Received BY - <span
                                                                                                class="fw-normal">{{ $inboxing->receiver->name }}</span>
                                                                                        </h6>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <div id="collapseThree"
                                                                            class="accordion-collapse collapse show"
                                                                            aria-labelledby="headingThree"
                                                                            data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body ms-2 ps-5 pt-0">
                                                                                <h6 class="mb-1">Dispacher Received Date
                                                                                </h6>
                                                                                <p class="text-muted mb-0">
                                                                                    {{ $inboxing->cntppickupdate }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="accordion-item border-0">
                                                                        <div class="accordion-header" id="headingFour">
                                                                            <a class="accordion-button p-2 shadow-none"
                                                                                data-bs-toggle="collapse"
                                                                                href="#collapseFour" aria-expanded="false"
                                                                                aria-controls="collapseFour">
                                                                                <div class="d-flex align-items-center">
                                                                                    <div class="flex-shrink-0 avatar-xs">
                                                                                        <div
                                                                                            class="avatar-title bg-success rounded-circle">
                                                                                            <i
                                                                                                class="ri-shopping-bag-line"></i>
                                                                                        </div>
                                                                                    </div>
                                                                                    <div class="flex-grow-1 ms-3">
                                                                                        <h6 class="fs-15 mb-1 fw-semibold">
                                                                                            Dispacher Opened BY - <span
                                                                                                class="fw-normal">{{ $inboxing->opener->name }}</span>
                                                                                        </h6>
                                                                                    </div>
                                                                                </div>
                                                                            </a>
                                                                        </div>
                                                                        <div id="collapseFour"
                                                                            class="accordion-collapse collapse show"
                                                                            aria-labelledby="headingFour"
                                                                            data-bs-parent="#accordionExample">
                                                                            <div class="accordion-body ms-2 ps-5 pt-0">
                                                                                <h6 class="mb-1">Dispacher Opening Date
                                                                                </h6>
                                                                                <p class="text-muted mb-0">
                                                                                    {{ $inboxing->opened_date }}</p>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    @if ($inboxing->status == 3)
                                                                        <div class="accordion-item border-0">
                                                                            <div class="accordion-header"
                                                                                id="headingFive">
                                                                                <a class="accordion-button p-2 shadow-none"
                                                                                    data-bs-toggle="collapse"
                                                                                    href="#collapseFive"
                                                                                    aria-expanded="false"
                                                                                    aria-controls="collapseFive">
                                                                                    <div class="d-flex align-items-center">
                                                                                        <div
                                                                                            class="flex-shrink-0 avatar-xs">
                                                                                            <div
                                                                                                class="avatar-title bg-success rounded-circle">
                                                                                                <i
                                                                                                    class="ri-shopping-bag-line"></i>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div class="flex-grow-1 ms-3">
                                                                                            <h6
                                                                                                class="fs-15 mb-1 fw-semibold">
                                                                                                Dispacher Sorted BY - <span
                                                                                                    class="fw-normal">{{ $inboxing->sorter->name }}</span>
                                                                                            </h6>
                                                                                        </div>
                                                                                    </div>
                                                                                </a>
                                                                            </div>
                                                                            <div id="collapseFive"
                                                                                class="accordion-collapse collapse show"
                                                                                aria-labelledby="headingFive"
                                                                                data-bs-parent="#accordionExample">
                                                                                <div class="accordion-body ms-2 ps-5 pt-0">
                                                                                    <h6 class="mb-1">Dispacher Sorting
                                                                                        Date
                                                                                    </h6>
                                                                                    <p class="text-muted mb-0">
                                                                                        {{ $inboxing->sorting_date }}</p>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                            <div class="hstack gap-2  mt-4 justify-content-center">
                                                                <a href="javascript:void(0);"
                                                                    class="btn btn-success fw-medium"
                                                                    data-bs-dismiss="modal"><i
                                                                        class="ri-close-line me-1 align-middle"></i>
                                                                    Close</a>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
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
