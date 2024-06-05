@extends('layouts.customer.app')
@section('page') International Mails @endsection
@section('content')


<div class="col-xxl-6">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="nav nav-pills flex-column nav-pills-tab custom-verti-nav-pills text-start"
                        role="tablist" aria-orientation="vertical">

                        @foreach ($boxes as $key => $item)
                        <a class="nav-link {{ \Request::route()->getName() == 'customer.mail.index' && $key == 0 ? 'active' :
                            (\Request::route()->getName() == 'customer.mail.show' && $id ==  $item->id ? 'active' : '') }}" id="custom-v-pills-messages-tab"
                            href="{{ route('customer.mail.show',encrypt($item->id)) }}">
                            <i class="ri-mail-line d-block fs-20 mb-1"></i>
                            <span
                                class="position-absolute top-0  start-100 translate-middle badge rounded-pill bg-success">
                                {{ App\Models\Eric\Inboxing::where('customer_id',$item->customer_id)->where('pob',$item->pob)->where('pob_bid',$item->branch_id)->where('instatus', '3')->count() }}
                            </span>
                            P.O B
                            @if ($item->serviceType == 'PBox')
                            {{ $item->pob }}
                            @else
                            +250{{ $item->pob }}
                            @endif
                            <em>{{ $item->branch->name }}</em>
                        </a>
                        @endforeach
                    </div>
                </div> <!-- end col-->
                <div class="col-lg-9">
                    <div class="tab-content text-muted mt-3 mt-lg-0">

                        <div class="card">
                            <div class="card-header align-items-center d-flex">
                                <h4 class="card-title mb-0 flex-grow-1">All Ingoing Courier</h4>
                                <div class="flex-shrink-0">
                                    {{-- count all courier --}}
                                    Mails <span class="badge rounded-pill bg-success">{{ $couriers->count() }}</span>
                                </div>
                            </div><!-- end card header -->

                            <div class="card-body">
                                <div class="table-responsive table-card">
                                    <table class="table table-hover table-centered align-middle table-nowrap mb-0">

                                        <thead>
                                            <tr>
                                                <th scope="col">#</th>
                                                <th scope="col">Tracking No</th>
                                                <th scope="col">Courier No </th>
                                                <th scope="col">Orgin</th>
                                                <th scope="col">Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($couriers as $courier)
                                            <tr>
                                                <th scope="row">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                                </th>
                                                <td>{{ $courier->intracking }}</td>
                                                <td>{{ $courier->innumber }}</td>
                                                <td>{{ $courier->orgcountry }}</td>
                                                <td>{{ Carbon\Carbon::parse($courier->created_at)->format('d-m-Y') }}
                                                </td>
                                                {{-- delivering --}}
                                                <td>
                                                    <!-- Static Backdrop -->
                                                    <button type="button" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#Order{{ $courier->id }}">
                                                        Order
                                                    </button>
                                                    <!-- Order Modal -->
                                                    <div class="modal fade" id="Order{{ $courier->id }}"
                                                        data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
                                                        role="dialog" aria-labelledby="staticBackdropLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-body p-5">
                                                                 <form action="{{ route('customer.mail.deliveryOrder',$courier->id) }}" method="post">
                                                                    @csrf
                                                                    <div class="mt-4">
                                                                        <div class="row g-4 mb-3">
                                                                            <div class="col-lg-6">
                                                                                <div class="form-check card-radio">
                                                                                    <input id="address01{{ $courier->id }}"
                                                                                        name="address"
                                                                                        type="radio"
                                                                                        class="form-check-input"
                                                                                        value="home" checked>
                                                                                    <label class="form-check-label"for="address01{{ $courier->id }}">
                                                                                        <span class="mb-2 fw-semibold d-block text-muted text-uppercase">Home Address</span>

                                                                                        {{-- <span class="fs-14 mb-2 d-block">Marcus Alfaro</span>
                                                                                        <span class="text-muted fw-normal text-wrap mb-1 d-block">4739 Bubby Drive Austin, TX 78729</span>
                                                                                        <span class="text-muted fw-normal d-block">Mo. 012-345-6789</span> --}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-lg-6">
                                                                                <div class="form-check card-radio">
                                                                                    <input id="address02{{ $courier->id }}"
                                                                                        name="address"
                                                                                        type="radio"
                                                                                        class="form-check-input"
                                                                                        value="office">
                                                                                    <label class="form-check-label" for="address02{{ $courier->id }}">
                                                                                            <span class="mb-2 fw-semibold d-block text-muted text-uppercase">Office Address</span>

                                                                                            {{-- <span class="fs-14 mb-2 d-block">Marcus Alfaro</span>
                                                                                            <span class="text-muted fw-normal text-wrap mb-1 d-block">4739 Bubby Drive Austin, TX 78729</span>
                                                                                            <span class="text-muted fw-normal d-block">Mo. 012-345-6789</span> --}}
                                                                                    </label>
                                                                                </div>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row">
                                                                                <div class="mb-3">
                                                                                    <label for="name" class="form-label">Expected Date</label>
                                                                                    <input type="date" class="form-control" id="name" name="expectedDate" required>
                                                                                </div>
                                                                        </div>

                                                                        <div class="my-3">
                                                                            <div class="form-check form-check-inline">
                                                                                <input id="credit" name="paymentMethod" type="radio" class="form-check-input" checked="" required="">
                                                                                <label class="form-check-label" for="credit">Credit card</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input id="debit" name="paymentMethod" type="radio" class="form-check-input" required="">
                                                                                <label class="form-check-label" for="debit">Debit card</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input id="paypal" name="paymentMethod" type="radio" class="form-check-input" required="">
                                                                                <label class="form-check-label" for="paypal">PayPal</label>
                                                                            </div>
                                                                            <div class="form-check form-check-inline">
                                                                                <input id="momo" name="paymentMethod" type="radio" class="form-check-input" required="">
                                                                                <label class="form-check-label" for="momo">Mobile Money</label>
                                                                            </div>
                                                                        </div>
                                                                        <div class="col-md-12 mb-3">
                                                                            <input type="text" class="form-control" disabled value="3000">


                                                                        </div>


                                                                        <div class="hstack gap-2 justify-content-center">
                                                                            <a href="javascript:void(0);" class="btn btn-link link-success fw-medium" data-bs-dismiss="modal"><i class="ri-close-line me-1 align-middle"></i> Close</a>
                                                                            <button class="btn btn-success">Submit</button>
                                                                        </div>
                                                                    </div>
                                                                  </form>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>

                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6" class="text-center">No Data Found</td>
                                            </tr>
                                            @endforelse


                                    </table>
                                </div>

                            </div>
                        </div>

                    </div>
                </div> <!-- end col-->
            </div> <!-- end row-->
        </div><!-- end card-body -->
    </div>
    <!--end card-->
</div>

@endsection
@section('script')

@endsection
