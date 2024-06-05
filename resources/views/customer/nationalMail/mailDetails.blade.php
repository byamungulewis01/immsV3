@extends('layouts.customer.app')
@section('page') Details Mail @endsection

@section('content')

<div class="row">
    <div class="col-lg-12">
        <div class="card" id="customerList">
            <div class="card-header border-bottom-dashed">
                <div class="row g-4 align-items-center">
                    <div class="col-sm">
                        <div class="align-items-center d-flex">
                            <h5 class="card-title mb-0 flex-grow-1">Dispatcher <span
                                    class="text-danger">{{ $dispatche->dispatchNumber }} </span></h5>
                            <div class="flex-shrink-0">
                                @unless ($dispatche->status != 0)
                                <button type="button" href="#sentModel{{ $dispatche->id }}" data-bs-toggle="modal"
                                    class="btn btn-soft-primary btn-sm">
                                    <i class="ri-send-plane-line align-bottom me-1"></i> Dispatch sent
                                </button>
                                <div class="modal fade" id="sentModel{{ $dispatche->id }}" aria-hidden="true"
                                    aria-labelledby="..." tabindex="-1">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-body text-center p-5">
                                                <form action="{{ route('customer.mails.sendMail',$dispatche->id) }}"
                                                    method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json"
                                                        trigger="loop" colors="primary:#f7b84b,secondary:#405189"
                                                        style="width:130px;height:130px">
                                                    </lord-icon>
                                                    <div class="mt-4 pt-4">
                                                        <h4>Sure , you want to send this mail?</h4>
                                                        <p class="text-muted"> This action cannot be undone. This will
                                                            permanently sent this mail. to the post agent.

                                                        </p>
                                                        <!-- Toogle to second dialog -->
                                                        <button class="btn btn-warning">
                                                            Yes , send
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button type="button" data-bs-toggle="modal" data-bs-target="#showModal"
                                    class="btn btn-soft-danger btn-sm">
                                    <i class="ri-add-line align-bottom me-1"></i> Item
                                </button>
                                <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light p-3">
                                                <h5 class="modal-title" id="exampleModalLabel">Registration</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close" id="close-modal"></button>
                                            </div>
                                            <form class="tablelist-form" method="post"
                                                action="{{ route('customer.mails.add',$dispatche->id) }}">
                                                @csrf
                                                <div class="modal-body">

                                                    @if($errors->any())
                                                    <div class="mb-3">
                                                        <div class="alert alert-danger">
                                                            <p><strong>Opps Something went wrong</strong></p>
                                                            <ul>
                                                                @foreach ($errors->all() as $error)
                                                                <li>* {{ $error }}</li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                    </div>
                                                    @endif
                                                    <input type="hidden" name="dispatchNumber"
                                                        value="{{ $dispatche->dispatchNumber }}">
                                                    <table class="table table-bordered" id="item_table">
                                                        <tr>
                                                            <th>N<sup>o</sup> </th>
                                                            <th>Select Recepient</th>
                                                            <th></th>
                                                        </tr>
                                                        <tr>
                                                            <td><span id="sr_no">1</span></td>
                                                            <td>
                                                                <select name="recepient[]" class="form-select">
                                                                    <option value="" selected disabled>Select Recepient
                                                                    </option>
                                                                    @foreach($favorites as $favorite)
                                                                    <option value="{{ $favorite->id }}">
                                                                        {{ $favorite->name }} ({{ $favorite->address }})
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><button type="button" name="add"
                                                                    class="btn btn-success btn-sm add">Add</button></td>
                                                        </tr>
                                                    </table>

                                                </div>
                                                <div class="modal-footer">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light"
                                                            data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn btn-success" id="add-btn">
                                                            New Item
                                                        </button>
                                                        <!-- <button type="button" class="btn btn-success" id="edit-btn">Update</button> -->
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                                @endunless
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <div class="card-body">

                <form action="{{ route('customer.mails.remove') }}" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="table-responsive table-card mb-1">
                        <table class="table align-middle" id="customerTable">
                            <thead class="table-light text-muted">
                                <tr>
                                    @unless ($dispatche->status != 0)
                                    <th scope="col" style="width: 25px;">
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" id="checkAll"
                                                value="option">
                                        </div>
                                    </th>
                                    @endunless
                                    <th scope="col" style="width: 60px">
                                        #
                                    </th>
                                    <th class="sort" style="width: 160px" data-sort="names">
                                        DATE</th>

                                    <th class="sort" style="width: 120px" data-sort="date">
                                        Ref Number </th>

                                    <th class="sort" style="width: 120px" data-sort="names">Destination</th>

                                    <th class="sort" data-sort="amount">
                                        Owner Name</th>

                                    <th class="sort" data-sort="postAgent">
                                        Owner Phone</th>

                                    <th class="sort" data-sort="trank">
                                        Tranking </th>
                                </tr>
                            </thead>
                            <tbody class="list form-check-all">
                                @foreach ($dispatches as $myMail)

                                <tr>
                                    @unless ($dispatche->status != 0)
                                    <th scope="row">
                                        <div class="form-check">
                                            <input type="hidden" name="dispatche" value="{{ $dispatche->id }}">
                                            <input class="form-check-input" type="checkbox" name="checkAll[]"
                                                value="{{ $myMail->id }}">
                                        </div>
                                    </th>
                                    @endunless
                                    <td>
                                        {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                    </td>


                                    <td>{{ \Carbon\Carbon::parse($myMail->dispatchDate)->locale('fr')->format('F j, Y') }}
                                    </td>
                                    <td>
                                        <input type="text" class="form-control form-control-sm apikey-value" readonly
                                            value="{{ $myMail->refNumber }}">
                                    </td>
                                    <td>
                                        {{ $myMail->destination->address }}
                                    </td>

                                    <td> {{ $myMail->destination->name }} </td>

                                    <td>
                                        {{ $myMail->destination->phone }}
                                    </td>

                                    <td>

                                        <!-- Default Modals -->
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal"
                                            data-bs-target="#trankingModel{{ $myMail->id }}">VIEW</button>
                                        <div id="trankingModel{{ $myMail->id }}" class="modal fade" tabindex="-1"
                                            aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="myModalLabel">Mail Status</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"> </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="profile-timeline">
                                                            <div class="accordion accordion-flush"
                                                                id="accordionFlushExample">
                                                                <div class="accordion-item border-0">
                                                                    <div class="accordion-header" id="headingOne">
                                                                        <a class="accordion-button p-2 shadow-none collapsed"
                                                                            data-bs-toggle="collapse"
                                                                            href="#collapseOne" aria-expanded="false"
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
                                                                                        Mail Registerd - <span
                                                                                            class="fw-normal">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $myMail->created_at)->format('D, d M Y') }}</span>
                                                                                    </h6>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>

                                                                </div>
                                                                <div class="accordion-item border-0">
                                                                    <div class="accordion-header" id="headingTwo">
                                                                        <a class="accordion-button p-2 shadow-none"
                                                                            data-bs-toggle="collapse"
                                                                            href="#collapseTwo" aria-expanded="true"
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
                                                                                        Picked Up - <span
                                                                                            class="fw-normal">
                                                                                            @if ($myMail->pickUpDate ==
                                                                                            null)
                                                                                            <em>Not Yet</em>
                                                                                            @else
                                                                                            {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $myMail->pickUpDate)->format('D, d M Y') }}
                                                                                            @endif
                                                                                        </span></h6>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                    @if ($myMail->pickUpDate != null)
                                                                    <div id="collapseTwo"
                                                                        class="accordion-collapse collapse show"
                                                                        aria-labelledby="headingTwo"
                                                                        data-bs-parent="#accordionExample" style="">
                                                                        <div class="accordion-body ms-2 ps-5 pt-0">
                                                                            <h6 class="mb-1">Your Item has been picked
                                                                                up by IPOSITA driver</h6>
                                                                            <p class="text-muted mb-0">
                                                                                {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $myMail->pickUpDate)->format('D, d M Y h:i:s') }}
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                    @endif
                                                                </div>
                                                                <div class="accordion-item border-0">
                                                                    <div class="accordion-header" id="headingThree">
                                                                        <a class="accordion-button p-2 shadow-none collapsed"
                                                                            data-bs-toggle="collapse"
                                                                            href="#collapseThree" aria-expanded="false"
                                                                            aria-controls="collapseThree">
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="flex-shrink-0 avatar-xs">
                                                                                    <div
                                                                                        class="avatar-title bg-success rounded-circle">
                                                                                        <i class="ri-truck-line"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="flex-grow-1 ms-3">
                                                                                    <h6 class="fs-15 mb-1 fw-semibold">
                                                                                        Logistic Processed - <span
                                                                                            class="fw-normal">
                                                                                            @if ($myMail->logisticDate
                                                                                            == null)
                                                                                            <em>Not Yet</em>
                                                                                            @else
                                                                                            {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $myMail->logisticDate)->format('D, d M Y') }}
                                                                                            @endif
                                                                                        </span></h6>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                    <div id="collapseThree"
                                                                        class="accordion-collapse collapse"
                                                                        aria-labelledby="headingThree"
                                                                        data-bs-parent="#accordionExample" style="">
                                                                        <div class="accordion-body ms-2 ps-5 pt-0">
                                                                            <h6 class="mb-1">Your item sent in Branch.
                                                                            </h6>
                                                                            <p class="text-muted mb-0">
                                                                                @if ($myMail->emsDate == null)
                                                                                <em>Not Yet</em>
                                                                                @else
                                                                                {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $myMail->emsDate)->format('D, d M Y') }}
                                                                                @endif
                                                                            </p>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="accordion-item border-0">
                                                                    <div class="accordion-header" id="headingFour">
                                                                        <a class="accordion-button p-2 shadow-none"
                                                                            data-bs-toggle="collapse"
                                                                            href="#collapseFour" aria-expanded="false">
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="flex-shrink-0 avatar-xs">
                                                                                    <div
                                                                                        class="avatar-title bg-light text-success rounded-circle">
                                                                                        <i class="ri-takeaway-fill"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="flex-grow-1 ms-3">
                                                                                    <h6 class="fs-14 mb-0 fw-semibold">
                                                                                        Branch Manager -
                                                                                        <span class="fw-normal">
                                                                                            @if($myMail->branchManagerDate== null)
                                                                                            <em>Not Yet</em>
                                                                                            @else
                                                                                            {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $myMail->branchManagerDate)->format('D, d M Y') }}
                                                                                            @endif
                                                                                        </span>
                                                                                    </h6>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                                <div class="accordion-item border-0">
                                                                    <div class="accordion-header" id="headingFive">
                                                                        <a class="accordion-button p-2 shadow-none"
                                                                            data-bs-toggle="collapse"
                                                                            href="#collapseFile" aria-expanded="false">
                                                                            <div class="d-flex align-items-center">
                                                                                <div class="flex-shrink-0 avatar-xs">
                                                                                    <div
                                                                                        class="avatar-title bg-light text-success rounded-circle">
                                                                                        <i
                                                                                            class="mdi mdi-package-variant"></i>
                                                                                    </div>
                                                                                </div>
                                                                                <div class="flex-grow-1 ms-3">
                                                                                    <h6 class="fs-14 mb-0 fw-semibold">
                                                                                        Delivered

                                                                                        <span class="fw-normal">
                                                                                            @if ($myMail->deliveredDate
                                                                                            != null)
                                                                                            -
                                                                                            {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $myMail->deliveredDate)->format('D, d M Y') }}

                                                                                            @endif
                                                                                        </span>
                                                                                    </h6>
                                                                                </div>
                                                                            </div>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <!--end accordion-->
                                                        </div>
                                                    </div>
                                                </div><!-- /.modal-content -->
                                            </div><!-- /.modal-dialog -->
                                        </div><!-- /.modal -->
                                    </td>




                                    {{--
                                <td>
                                    @if ($myMail->observation == null)
                                    <i>No Observation </i>

                                    @else
                                    {{ $myMail->observation }}
                                    @endif

                                    </td> --}}

                                </tr>

                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <!--end table-responsive-->
                    <button class="btn btn-sm btn-soft-danger" style="display: none;" id="deleteBtn"
                    >Delete
                </button>


                </form>
            </div>
        </div>
    </div>
    <!--end col-->
</div>


@endsection


@section('script')
<script>
    $(document).ready(function () {

        $(document).on('click', '.add', function () {
            var html = '';
            var number_of_rows = $('#item_table tr').length;
            html += '<tr>';
            //   icrementing the number of rows
            html += '<td><span id="sr_no">' + number_of_rows + '</span></td>';
            html +=
                '<td><select name="recepient[]" class="form-select"><option value="" selected disabled>Select Recepient</option>@foreach($favorites as $favorite)<option value="{{ $favorite->id }}">{{ $favorite->name }} - ({{ $favorite->address }})</option>@endforeach</select></td>';
            html +=
                '<td><button type="button" name="remove" class="btn btn-danger btn-sm remove">Remove</button></td></tr>';
            $('#item_table').append(html);
        });

        $(document).on('click', '.remove', function () {
            $(this).closest('tr').remove();
        });

    });

</script>
<script>
    var checkAll = document.getElementById("checkAll");
    var checkboxes = document.querySelectorAll("tbody input[type=checkbox]");
    var deleteBtn = document.getElementById("deleteBtn");

    checkAll.addEventListener("change", function (e) {
        var t = e.target.checked;
        checkboxes.forEach(function (e) {
            e.checked = t;
        });
        toggleDeleteBtn();
    });

    checkboxes.forEach(function (e) {
        e.addEventListener("change", function (e) {
            checkAll.checked = Array.from(checkboxes).every(function (e) {
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

<script src="{{ asset('assets/js/pages/invoicecreate.init.js') }}"></script>

@endsection
