@extends('layouts.customer.app')
@section('page') National Mails @endsection
@section('content')


<div class="col-xxl-6">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-lg-3">
                    <div class="nav nav-pills flex-column nav-pills-tab custom-verti-nav-pills text-start"
                        role="tablist" aria-orientation="vertical">

                        @foreach ($boxes as $key => $item)
                        <a class="nav-link {{ \Request::route()->getName() == 'customer.mail.national' && $key == 0 ? 'active' :
                            (\Request::route()->getName() == 'customer.mail.nationalShow' && $id ==  $item->id ? 'active' : '') }}" id="custom-v-pills-messages-tab"
                            href="{{ route('customer.mail.nationalShow',encrypt($item->id)) }}">
                            <i class="ri-mail-line d-block fs-20 mb-1"></i>
                            <span
                                class="position-absolute top-0  start-100 translate-middle badge rounded-pill bg-success">
                                {{ App\Models\Customer\CustomerDispatchDetails::where('pob', $item->pob)->where('customer_id',auth()->guard('customer')->user()->id)->where('status',4)->count() }}
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
                                                <th scope="col">Reference</th>
                                                <th scope="col">Weight</th>
                                                <th scope="col">Orgin</th>
                                                <th scope="col">Date</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @forelse($couriers as $courier)
                                            <tr>
                                                <th scope="row">{{ str_pad($loop->iteration, 2, '0', STR_PAD_LEFT) }}
                                                </th>
                                                <td>{{ $courier->refNumber }}</td>
                                                <td>{{ $courier->weight }}</td>
                                                <td>{{ $courier->dispatch->senderName }}</td>
                                                <td>{{ Carbon\Carbon::parse($courier->created_at)->format('d-m-Y') }}
                                                </td>

                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No Data Found</td>
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
