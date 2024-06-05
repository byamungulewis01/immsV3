@php
    use Illuminate\Support\Facades\DB;
    use App\Models\Eric\AirportDispach;

    $pendingdispatch = AirportDispach::where('cntp_id', auth()->user()->id)
        ->where('status', '0')
        ->count();
    $assigneddispatch = AirportDispach::where('cntp_id', auth()->user()->id)
        ->where('status', '1')
        ->count();
    $approveddispatchcntp = AirportDispach::where('cntp_id', auth()->user()->id)
        ->where('status', '2')
        ->count();
    $approveddispatchopen = AirportDispach::where('cntp_id', auth()->user()->id)
        ->where('status', '3')
        ->count();
@endphp
<div class="row">
    <div class="col-xl-4 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Pending Dispatch</p>
                    </div>

                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                data-target="{{ $pendingdispatch }}">{{ $pendingdispatch }}</span></h4>
                        <a href="{{ route('admin.cntp.CntpDispach') }}" class="text-decoration-underline">View
                            pending</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-primary rounded fs-2">
                            <i class="bx bx-envelope text-primary"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xl-4 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Dispatch Approved</p>
                    </div>

                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                data-target="{{ $approveddispatchcntp }}">{{ $approveddispatchcntp }}</span></h4>
                        <a href="{{ route('admin.cntp.CntpMailOpening') }}" class="text-decoration-underline">View
                            Approved</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-success rounded fs-2">
                            <i class="bx bx-envelope text-success"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
    <div class="col-xl-4 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Dispatch Opened</p>
                    </div>

                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value"
                                data-target="{{ $approveddispatchopen }}">{{ $approveddispatchopen }}</span></h4>
                        <a href="{{ route('admin.cntp.CntpMailOpening') }}" class="text-decoration-underline">View
                            Opened</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-info rounded fs-2">
                            <i class="bx bx-envelope text-info"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
</div> <!-- end row-->
