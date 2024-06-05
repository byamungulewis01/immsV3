@extends('layouts.customer.app')
@section('page') Dashboard @endsection
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
<div class="row">
    <div class="col-xl-12">
        <div class="card crm-widget">
            <div class="card-body p-0">
                <div class="row row-cols-xxl-5 row-cols-md-3 row-cols-1 g-0">
                    <div class="col">
                        <div class="py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Physical P.O Box <a href="{{ route('customer.physicalPob') }}" class="float-end">view all</a></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-archive-line display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    @php
                                        $physical = \App\Models\Box::where('customer_id',auth()->guard('customer')->user()->id)->where('serviceType','PBox')->count();
                                    @endphp
                                    <h2 class="mb-0"><span class="counter-value" data-target="{{ $physical }}">{{ $physical }}</span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col">
                        <div class="mt-3 mt-md-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Virtual P.O Box <a href="{{ route('customer.virtualPob') }}" class="float-end">view all</a></h5>
                            </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-layout-3-line display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    @php
                                        $virtual = \App\Models\Box::where('customer_id',auth()->guard('customer')->user()->id)->where('serviceType','VBox')->count();
                                    @endphp
                                    <h2 class="mb-0"><span class="counter-value" data-target="{{ $virtual }}">{{ $virtual }}</span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col">
                        <div class="mt-3 mt-md-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Total Mails </h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-pulse-line display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    @php
                                       $national = \App\Models\Customer\CustomerDispatchDetails::where('customer_id',auth()->guard('customer')->user()->id)->where('status','4')->count();
                                       $international = \App\Models\Eric\Inboxing::where('customer_id',auth()->guard('customer')->user()->id)->where('instatus','3')->count();
                                       $total = $national + $international;
                                    @endphp
                                    <h2 class="mb-0"><span class="counter-value" data-target="{{ $total }}">{{ $total }}</span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col">
                        <div class="mt-3 mt-lg-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">National Mail <a href="{{ route('customer.mail.national') }}" class="float-end">view all</a></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-mail-send-line display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    @php
                                        $national = \App\Models\Customer\CustomerDispatchDetails::where('customer_id',auth()->guard('customer')->user()->id)->where('status','4')->count();
                                    @endphp
                                    <h2 class="mb-0"><span class="counter-value" data-target="{{ $national }}">{{ $national }}</span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                    <div class="col">
                        <div class="mt-3 mt-lg-0 py-4 px-3">
                            <h5 class="text-muted text-uppercase fs-13">Internation Mail <a href="{{ route('customer.mail.index') }}" class="float-end">view all</a></h5>
                            <div class="d-flex align-items-center">
                                <div class="flex-shrink-0">
                                    <i class="ri-mail-send-line display-6 text-muted"></i>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    @php
                                       $international = \App\Models\Eric\Inboxing::where('customer_id',auth()->guard('customer')->user()->id)->where('instatus','3')->count();
                                    @endphp
                                    <h2 class="mb-0"><span class="counter-value" data-target="{{ $international }}">{{ $international }}</span></h2>
                                </div>
                            </div>
                        </div>
                    </div><!-- end col -->
                </div><!-- end row -->
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div>
 @endif
@endsection
