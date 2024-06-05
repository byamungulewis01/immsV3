@extends('layouts.customer.app')
@section('page') International Mails @endsection
@section('content')
<div class="row">
    <div class="col-xl-12 col-lg-12 col-md-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">International Mails</h4>
                <p class="card-title-desc text-muted">List of all international mails</p>
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Tracking Number</th>
                                <th>Courier No</th>
                                <th>Origin</th>
                                <th>Expected Delivery Date</th>
                                <th>Amount Paid</th>
                                <th>Status</th>
                                <th>Tranking</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($deliveries as $delivery)
                            <tr>
                                <td>{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}</td>
                                <td>{{ $delivery->curier->intracking }}</td>
                                <td>{{ $delivery->curier->innumber }}</td>
                                <td>{{ $delivery->curier->orgcountry }}</td>
                                <td>{{ $delivery->expectedDateOfDelivery }}</td>
                                <td>{{ $delivery->amount }}</td>
                                <td>
                                    @if($delivery->status == 0)
                                    <span class="badge bg-primary">Pending</span>
                                    @elseif($delivery->status == 1)
                                    <span class="badge bg-info">In Transit</span>
                                    @elseif($delivery->status == 2)
                                    <span class="badge bg-success">Delivered</span>
                                    @endif
                                </td>
                                <td>
                                    <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#trankingModel{{ $delivery->id }}">VIEW</button>
                                    <div id="trankingModel{{ $delivery->id }}" class="modal fade" tabindex="-1" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="myModalLabel">Mail Status</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"> </button>
                                                </div>
                                                <div class="modal-body">
                                                    <div class="profile-timeline">
                                                        <div class="accordion accordion-flush" id="accordionFlushExample">
                                                            <div class="accordion-item border-0">
                                                                <div class="accordion-header" id="headingOne">
                                                                    <a class="accordion-button p-2 shadow-none collapsed" data-bs-toggle="collapse" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-shrink-0 avatar-xs">
                                                                                <div class="avatar-title bg-success rounded-circle">
                                                                                    <i class="ri-shopping-bag-line"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="flex-grow-1 ms-3">
                                                                                <h6 class="fs-15 mb-0 fw-semibold">Make Order - <span class="fw-normal">{{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $delivery->created_at)->format('D, d M Y') }}</span></h6>
                                                                            </div>
                                                                        </div>
                                                                    </a>
                                                                </div>

                                                            </div>

                                                            <div class="accordion-item border-0">
                                                                <div class="accordion-header" id="headingFive">
                                                                    <a class="accordion-button p-2 shadow-none" data-bs-toggle="collapse" href="#collapseFile" aria-expanded="false">
                                                                        <div class="d-flex align-items-center">
                                                                            <div class="flex-shrink-0 avatar-xs">
                                                                                <div class="avatar-title bg-light text-success rounded-circle">
                                                                                    <i class="mdi mdi-package-variant"></i>
                                                                                </div>
                                                                            </div>
                                                                            <div class="flex-grow-1 ms-3">
                                                                                <h6 class="fs-14 mb-0 fw-semibold">Delivered

                                                                                    <span class="fw-normal">
                                                                                        @if ($delivery->deliveryDate != null)
                                                                                        -
                                                                                        {{ Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $delivery->deliveryDate)->format('D, d M Y') }}
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
                            </tr>

                            @empty
                            <tr>
                                <td colspan="8" class="text-center">No data available</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('script')

@endsection
