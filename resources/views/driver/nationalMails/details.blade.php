@extends('layouts.admin.app')
@section('page-name')Received Mails Details @endsection
@section('body')
@php
    use App\Models\Box;
@endphp

<!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0">Received Mails Details</h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item">
                        <a href="javascript: void(0);">IMMS </a>
                    </li>
                    <li class="breadcrumb-item active">Received Mails Details</li>
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
                            <h5 class="card-title mb-0">Dispatcher <span class="text-danger">{{ $dispatche->dispatchNumber }}</span></h5>
                        </div>
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
                <div class="table-responsive table-card mb-1">
                    <table class="table align-middle" id="customerTable">
                        <thead class="table-light text-muted">
                            <tr>
                                <th scope="col">
                                    #
                                </th>

                                <th class="sort" style="width: 110px;" data-sort="date">
                                    Ref Number </th>

                                <th class="sort"  data-sort="names">Receiver name</th>

                                <th class="sort" style="width: 90px" data-sort="names">Address</th>

                                <th class="sort" data-sort="amount">
                                    Weight</th>

                                <th class="sort" data-sort="postAgent">
                                    Price</th>

                                <th class="sort" data-sort="status">
                                    Status</th>


                                <th class="sort" data-sort="HOME">
                                    Observation </th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody class="list form-check-all">
                            @foreach ($dispatches as $myMail)

                            <tr>
                                <td>
                                    {{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                </td>
                                <td>
                                    <input type="text" class="form-control form-control-sm apikey-value" readonly
                                        value="{{ $myMail->refNumber }}">
                                </td>

                                <td>
                                    {{ $myMail->destination->name }}
                                </td>
                                <td>
                                    {{ $myMail->destination->address }}
                                </td>

                                <td> {{ $myMail->weight }} </td>

                                <td>
                                    {{ $myMail->price }}
                                </td>

                                <td>
                                    @if ($myMail->status == 0)
                                    <span class="badge bg-soft-warning text-warning">Pending</span>
                                    @elseif($myMail->status == 1)
                                    <span class="badge bg-soft-success text-success">Delivered</span>
                                    @elseif($myMail->status == 2)
                                    <span class="badge bg-soft-secondary text-info">Received</span>
                                    @endif
                                </td>
                                <td>
                                    @if ($myMail->observation == null)
                                    <i>No Observation </i>

                                    @else
                                    <i>{{ $myMail->observation }}</i>
                                    @endif

                                </td>
                                <td>
                                    @if (Request::routeIs('driver.nationalMails.details'))
                                    <button class="btn btn-soft-danger btn-sm" data-bs-toggle="modal" data-bs-target="#topmodal{{ $myMail->id }}">
                                        <i class="ri-pen-nib-line align-bottom me-0"></i> Fill up
                                    </button>
                                    @endif
                                    <!--  Small modal example -->
                                    <div class="modal fade" id="topmodal{{ $myMail->id }}" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" aria-hidden="true">
                                        <div class="modal-dialog modal-sm">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="mySmallModalLabel">Fill up</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                                    </button>
                                                </div>
                                            <form action="{{ route('driver.nationalMails.fillUp',$myMail->id) }}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="row mb-3">
                                                        <div class="col-md-4">
                                                                <label for="weight" class="form-label">Weight</label>
                                                                <input type="text" name="weight" class="form-control numbers" id="weight" placeholder="weight" required>
                                                        </div>
                                                        <div class="col-md-8">
                                                                <label for="price" class="form-label">Price</label>
                                                                <input type="text" name="price" class="form-control numbers" id="price" placeholder="Enter price" required>
                                                        </div>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label for="observation" class="form-label">Observation</label>
                                                        <textarea name="observation" class="form-control" id="observation" rows="3" placeholder="Enter your observation"></textarea>
                                                    </div>
                                                </div>
                                                <div class="modal-footer">
                                                    <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                                                    <button type="submit" class="btn btn-primary ">Save changes</button>
                                                </div>
                                            </form>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->
                                </td>

                            </tr>

                            @endforeach
                        </tbody>
                    </table>
                </div>
                <!--end table-responsive-->
                <div class="hstack gap-2 justify-content-end d-print-none">

                    <a href="{{ route('driver.nationalMails.pod',$id) }}" class="btn btn-primary btn-sm"><i class="ri-download-2-line align-bottom me-1"></i> Download POD</a>

                                        <!-- Toggle Between Modals -->
                        @if (Request::routeIs('driver.nationalMails.details'))
                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#firstmodal">Submit Dispatcher</button>
                        @endif
                        <!-- First modal dialog -->
                        <div class="modal fade" id="firstmodal" aria-hidden="true" aria-labelledby="..." tabindex="-1">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body text-center p-5">
                                        <form action="{{ route('driver.nationalMails.submit',$dispatche->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <lord-icon
                                            src="https://cdn.lordicon.com/tdrtiskw.json"
                                            trigger="loop"
                                            colors="primary:#f7b84b,secondary:#405189"
                                            style="width:130px;height:130px">
                                        </lord-icon>
                                        <div class="mt-0 pt-4">
                                            <h4>Are you sure you want to submit this dispatch?</h4>
                                            <p class="text-muted"> You won't be able to revert this! </p>
                                            <!-- Toogle to second dialog -->
                                            <button class="btn btn-warning">
                                                Continue
                                            </button>
                                        </div>
                                    </form>
                                    </div>
                                </div>
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

@endsection

@section('script')
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
    //    #price\
</script>


<!--datatable js-->


<script src="{{ asset('assets/js/pages/datatables.init.js') }}"></script>

@endsection
