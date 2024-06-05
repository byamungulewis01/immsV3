@extends('layouts.customer.app')
@section('page') Create Mail @endsection

@section('content')
@php
    $pobox = \App\Models\Box::where('customer_id',auth()->guard('customer')->user()->id)->count();
@endphp

@if ($pobox == 0)
<div class="row">
    <div class="col-lg-12">

        <div class="alert alert-danger alert-dismissible alert-additional fade show mb-xl-0" role="alert">
            <div class="alert-body">
                  <div class="d-flex">
                    <div class="flex-shrink-0 me-3">
                        <i class="ri-alert-line fs-24 align-middle"></i>
                    </div>
                    <div class="flex-grow-1">
                        <h5 class="alert-heading">You don't have a P.O BOX</h5>
                        <p class="mb-0">It seems you have not applied for a <strong>P.O BOX</strong> yet ,
                            You can apply for a P.O BOX by clicking the button below.  <a href="{{ route('customer.application.index') }}">Apply Now</a>



                        </p>
                    </div>
                </div>
            </div>

        </div>



    </div>
</div>

@else
        @php
            // pobox which has ems national contract
            $pobox = \App\Models\Box::where('customer_id',auth()->guard('customer')->user()->id)->where('EMSNationalContract','yes')->count();
        @endphp

        @if ($pobox == 0)
        <div class="row">
            <div class="col-lg-12">

                <div class="alert alert-danger alert-dismissible alert-additional fade show mb-xl-0" role="alert">
                    <div class="alert-body">
                        <div class="d-flex">
                            <div class="flex-shrink-0 me-3">
                                <i class="ri-alert-line fs-24 align-middle"></i>
                            </div>
                            <div class="flex-grow-1">
                                <h5 class="alert-heading">You don't have a EMS National Contract</h5>
                                <p class="mb-0">It seems you have not applied for a <strong>EMS National Contract</strong> yet ,
                                    Please contact the post office to sign the contract.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @else
        <div class="row">
            <div class="col-lg-12">
                <div class="card" id="customerList">
                    <div class="card-header border-bottom-dashed">
                        <div class="row g-4 align-items-center">
                            <div class="col-sm">
                                <div>
                                    <h5 class="card-title mb-0">My Mails</h5>
                                </div>
                            </div>
                            <div class="col-sm-auto">
                                <div class="d-flex flex-wrap align-items-start gap-2">
                                    <button data-bs-toggle="modal" data-bs-target="#showModal" class="btn btn-success"><i
                                        class="ri-add-fill align-bottom me-1"></i>Dispatcher</button>
                                <div class="modal fade" id="showModal" tabindex="-1" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header bg-light p-3">
                                                <h5 class="modal-title" id="exampleModalLabel">Registration</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"
                                                    id="close-modal"></button>
                                            </div>
                                            <form class="tablelist-form" method="post" action="{{ route('customer.mails.store') }}">
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
                                                                    <option value="" selected disabled>Select Recepient</option>
                                                                    @foreach($favorites as $favorite)
                                                                    <option value="{{ $favorite->id }}">{{ $favorite->name }} - ({{ $favorite->address }})
                                                                    </option>
                                                                    @endforeach
                                                                </select>
                                                            </td>
                                                            <td><button type="button" name="add"
                                                                    class="btn btn-success btn-sm add">Add</button></td>
                                                        </tr>
                                                    </table>

                                                    {{-- checkbox --}}
                                                    <!-- Custom Outline Checkboxes -->
                                                    <div class="form-check form-check-outline form-check-primary mb-3">
                                                        <input class="form-check-input" name="status" type="checkbox"
                                                            id="formCheck13" value="on">
                                                        <label class="form-check-label" for="formCheck13">
                                                            Check to ask for mail pickup service
                                                        </label>
                                                    </div>

                                                </div>
                                                <div class="modal-footer">
                                                    <div class="hstack gap-2 justify-content-end">
                                                        <button type="button" class="btn btn-light" data-bs-dismiss="modal">
                                                            Close
                                                        </button>
                                                        <button type="submit" class="btn btn-success" id="add-btn">
                                                            Add New
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
                    </div>
                    <div class="card-body">


                        <div class="table-responsive table-card mb-1">
                            <table class="table align-middle" id="customerTable">
                                <thead class="table-light text-muted">
                                    <tr>
                                        <th scope="col" style="width: 60px">
                                            #
                                        </th>
                                        <th class="sort" style="width: 160px" data-sort="names">
                                            DISPATCH NUMBER</th>

                                        <th class="sort" data-sort="date">
                                            DATE </th>

                                        <th class="sort" style="width: 120px" data-sort="names">
                                            MAILS NUMBER</th>

                                        {{-- <th class="sort" data-sort="amount">
                                            AMOUNT</th> --}}

                                        <th class="sort" data-sort="postAgent">
                                            POST AGENT</th>

                                        <th class="sort" data-sort="status">
                                            STATUS </th>

                                        <th class="sort"></th>
                                    </tr>
                                </thead>
                                <tbody class="list form-check-all">
                                    @forelse($myMails as $myMail)

                                    <tr>

                                        <td>
                                            {{ $loop->iteration }}
                                        </td>

                                        <td>
                                            <a href="{{ route('customer.mails.details',encrypt($myMail->id)) }}">{{ $myMail->dispatchNumber }}
                                            </a>

                                        </td>
                                        <td>{{ \Carbon\Carbon::parse($myMail->created_at)->locale('fr')->format('F j, Y') }}
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm apikey-value" readonly
                                                value="{{ $myMail->mailsNumber }}">
                                        </td>

                                        {{-- <td> {{ $myMail->price }} </td> --}}

                                        <td>
                                            @if($myMail->postAgent != NULL)
                                            {{ $myMail->agent->name }}
                                            @else
                                            <i>Agent not yet set</i>
                                            @endif
                                        </td>


                                        <td>
                                            @if($myMail->status == 0)
                                            <span class="badge bg-warning">Not sent</span>
                                            @elseif($myMail->status == 1)
                                            <span class="badge bg-secondary">Sent request</span>
                                            @elseif($myMail->status == 2)
                                            <span class="badge bg-primary">Inprogress</span>

                                            @elseif($myMail->status == 3)
                                            <span class="badge bg-success">Picked up</span>
                                            @elseif($myMail->status == 4)
                                            <span class="badge bg-info">Recieved</span>
                                            @endif

                                        </td>

                                        <td>
                                            <ul class="list-inline hstack gap-2 mb-0">
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-placement="top" title="View">
                                                    <a href="{{ route('customer.mails.details',encrypt($myMail->id)) }}"
                                                        class="text-primary d-inline-block">
                                                        <i class="ri-eye-fill fs-16"></i>
                                                    </a>
                                                </li>
                                                @unless ($myMail->status == 0)

                                                @if($myMail->status == 2)
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-placement="top" title="Secure code">
                                                    <a href="" class="text-primary d-inline-block" data-bs-toggle="modal" data-bs-target="#topmodal{{ $myMail->id }}">
                                                        <i class="ri-key-line fs-16"></i>
                                                    </a>

                                                    <div id="topmodal{{ $myMail->id }}" class="modal fade" tabindex="-1" aria-hidden="true" style="display: none;">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center p-5">

                                                                        <div class="text-muted text-center mx-lg-3">
                                                                            <h4 class="">Verify Your Mail</h4>
                                                                            <p>Please enter the 5 digit code from post Agent </p>
                                                                        </div>
                                                                        @if (session('InvalidSecurity'))
                                                                        <div class="alert alert-danger alert-dismissible alert-label-icon label-arrow fade show mb-xl-0" role="alert">
                                                                            <i class="ri-close-line label-icon"></i><strong>Invalid Security</strong>
                                                                            {{ session('InvalidSecurity') }}
                                                                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                                                                        </div>
                                                                        @endif

                                                                        <div class="mt-4">
                                                                            <form action="{{ route('customer.mails.verify',$myMail->id) }}" method="POST">
                                                                                @csrf
                                                                                <div class="row">
                                                                                    <div class="col">
                                                                                        <div class="mb-3">
                                                                                            <label for="digit1-input" class="visually-hidden">Digit 1</label>
                                                                                            <input type="text" name="digit1" placeholder="0" class="form-control form-control-lg bg-light border-light text-center numbers digit1-input" onkeyup="moveToNext(1, event)" maxLength="1" id="digit1-input">
                                                                                        </div>
                                                                                    </div><!-- end col -->

                                                                                    <div class="col">
                                                                                        <div class="mb-3">
                                                                                            <label for="digit2-input" class="visually-hidden">Digit 2</label>
                                                                                            <input type="text" name="digit2" placeholder="0" class="form-control form-control-lg bg-light border-light text-center numbers digit1-input" onkeyup="moveToNext(2, event)" maxLength="1" id="digit2-input">
                                                                                        </div>
                                                                                    </div><!-- end col -->

                                                                                    <div class="col">
                                                                                        <div class="mb-3">
                                                                                            <label for="digit3-input" class="visually-hidden">Digit 3</label>
                                                                                            <input type="text" name="digit3" placeholder="0" class="form-control form-control-lg bg-light border-light text-center numbers digit1-input" onkeyup="moveToNext(3, event)" maxLength="1" id="digit3-input">
                                                                                        </div>
                                                                                    </div><!-- end col -->

                                                                                    <div class="col">
                                                                                        <div class="mb-3">
                                                                                            <label for="digit4-input" class="visually-hidden">Digit 4</label>
                                                                                            <input type="text" name="digit4" placeholder="0" class="form-control form-control-lg bg-light border-light text-center numbers digit1-input" onkeyup="moveToNext(4, event)" maxLength="1" id="digit4-input">
                                                                                        </div>
                                                                                    </div><!-- end col -->

                                                                                    <div class="col">
                                                                                        <div class="mb-3">
                                                                                            <label for="digit5-input" class="visually-hidden">Digit 5</label>
                                                                                            <input type="text" name="digit5" placeholder="0" class="form-control form-control-lg bg-light border-light text-center numbers digit1-input" onkeyup="moveToNext(5, event)" maxLength="1" id="digit5-input">
                                                                                        </div>
                                                                                    </div><!-- end col -->

                                                                                </div>

                                                                                <div class="mt-3">
                                                                                    <button type="submit" class="btn btn-success w-100">Confirm</button>
                                                                                </div>

                                                                            </form>

                                                                        </div>

                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->
                                                @endif


                                                </li>
                                                @endunless

                                                @if ($myMail->status == 0)
                                                <li class="list-inline-item edit" data-bs-toggle="tooltip"
                                                    data-bs-trigger="hover" data-bs-placement="top" title="Sent dispatch">
                                                    <a href="#sentModel{{ $myMail->id }}" data-bs-toggle="modal"
                                                        class="text-primary d-inline-block edit-item-btn">
                                                        <i class="ri-send-plane-line fs-16"></i>
                                                    </a>

                                                    <!-- First modal dialog -->
                                                    <div class="modal fade" id="sentModel{{ $myMail->id }}"
                                                        aria-hidden="true" aria-labelledby="..." tabindex="-1">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-body text-center p-5">
                                                                    <form
                                                                        action="{{ route('customer.mails.sendMail',$myMail->id) }}"
                                                                        method="post">
                                                                        @csrf
                                                                        @method('PUT')
                                                                        <lord-icon src="https://cdn.lordicon.com/tdrtiskw.json"
                                                                            trigger="loop"
                                                                            colors="primary:#f7b84b,secondary:#405189"
                                                                            style="width:130px;height:130px">
                                                                        </lord-icon>
                                                                        <div class="mt-4 pt-4">
                                                                            <h4>Sure , you want to send this mail?</h4>
                                                                            <p class="text-muted"> This action cannot be undone.
                                                                                This will permanently sent this mail. to the
                                                                                post agent.

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

                                                </li>
                                                <li class="list-inline-item" data-bs-toggle="tooltip" data-bs-trigger="hover"
                                                    data-bs-placement="top" title="Remove">
                                                    <a class="text-danger d-inline-block remove-item-btn" data-bs-toggle="modal"
                                                        href="#deleteOrder{{ $myMail->id }}">
                                                        <i class="ri-delete-bin-5-fill fs-16"></i>
                                                    </a>

                                                    <!-- Modal -->
                                                    <div class="modal fade zoomIn" id="deleteOrder{{ $myMail->id }}"
                                                        tabindex="-1" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <button type="button" class="btn-close"
                                                                        id="deleteRecord-close" data-bs-dismiss="modal"
                                                                        aria-label="Close" id="btn-close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <form method="post"
                                                                        action="{{ route('customer.mails.destroy', $myMail->id) }}">
                                                                        @csrf
                                                                        @method('DELETE')
                                                                        <div class="mt-2 text-center">
                                                                            <lord-icon
                                                                                src="https://cdn.lordicon.com/gsqxdxog.json"
                                                                                trigger="loop"
                                                                                colors="primary:#f7b84b,secondary:#f06548"
                                                                                style="width: 100px; height: 100px"></lord-icon>
                                                                            <div class="mt-4 pt-2 fs-15 mx-4 mx-sm-5">
                                                                                <h4>You are about to delete a order ?</h4>
                                                                                <p class="text-muted fs-15 mb-4">Deleting your
                                                                                    order will remove all of your information
                                                                                    from our database.</p>
                                                                            </div>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                                                            <button type="button" class="btn w-sm btn-light"
                                                                                data-bs-dismiss="modal">
                                                                                Close
                                                                            </button>
                                                                            <button type="submit" class="btn w-sm btn-danger"
                                                                                id="delete-record">
                                                                                Yes, Delete It!
                                                                            </button>
                                                                        </div>
                                                                    </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <!--end modal -->
                                                </li>
                                                @endif
                                            </ul>
                                        </td>

                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7" class="text-center">No Mails Found</td>
                                    </tr>

                                    @endforelse

                                </tbody>
                            </table>
                        </div>



                    </div>
                </div>
            </div>
            <!--end col-->
        </div>
        <!--end row-->
        @endif

@endif

@endsection

@section('script')
{{-- @if(session('InvalidSecurity'))
<script>
    var myModal = new bootstrap.Modal(document.getElementById('topmodal'), {
        keyboard: false
    })
    myModal.show()

</script>
@endif --}}
<script>
     $(document).ready(function () {
     $(".numbers").keydown(function (e) {
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190, 188]) !== -1 ||
            (e.keyCode == 65 && (e.ctrlKey === true || e.metaKey === true)) ||
            (e.keyCode >= 35 && e.keyCode <= 40) || (e.keyCode >= 96 && e.keyCode <= 105)) {
                return;
            }
            if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) &&
                (e.keyCode < 96 || e.keyCode > 105) && (e.keyCode < 190 || e.keyCode > 188)) {
                    e.preventDefault();
                }
            });
        });
</script>
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

 <!-- two-step-verification js -->
 <script src="{{ asset('assets/js/pages/two-step-verification.init.js') }}"></script>

@endsection
