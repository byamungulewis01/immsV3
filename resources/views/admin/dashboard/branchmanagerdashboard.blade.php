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

    $income = DB::table('daily_transactions')
        ->where('branch', auth()->user()->branch)
        ->select(DB::raw('SUM(total_amount) as amount'))
        ->first();

    $expense = DB::table('expenses')
        ->where('branch_id', auth()->user()->branch)
        ->select(DB::raw('SUM(e_amount) as amount'))
        ->first();
    $balance = $income->amount - $expense->amount;
@endphp
<div class="row">
    <div class="col-xxl-3">
        <div class="card card-height-100">
            <div class="card-header border-0 align-items-center d-flex">
                <h4 class="card-title mb-0 flex-grow-1">Dispacher Status</h4>
            </div><!-- end cardheader -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-borderless table-sm table-centered align-middle table-nowrap mb-0">
                        <tbody class="border-0">
                            <tr>
                                <td>
                                    <h4 class="text-truncate fs-14 fs-medium mb-0"><i
                                            class="ri-stop-fill align-middle fs-18 text-primary me-2"></i>Pending
                                        Dispatch
                                    </h4>
                                </td>

                                <td class="text-end">
                                    <p class="text-primary fw-medium fs-12 mb-0"><i
                                            class="ri-arrow-up-s-fill fs-5 align-middle"></i>{{ $pendingdispatch }} </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4 class="text-truncate fs-14 fs-medium mb-0"><i
                                            class="ri-stop-fill align-middle fs-18 text-warning me-2"></i>Dispatch
                                        Received
                                    </h4>
                                </td>

                                <td class="text-end">
                                    <p class="text-warning fw-medium fs-12 mb-0"><i
                                            class="ri-arrow-down-s-fill fs-5 align-middle"></i>{{ $assigneddispatch }}
                                    </p>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <h4 class="text-truncate fs-14 fs-medium mb-0"><i
                                            class="ri-stop-fill align-middle fs-18 text-info me-2"></i>Delivered Mails
                                    </h4>
                                </td>

                                <td class="text-end">
                                    <p class="text-info fw-medium fs-12 mb-0"><i
                                            class="ri-arrow-down-s-fill fs-5 align-middle"></i>{{ $approveddispatchcntp }}
                                    </p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

    <div class="col-xxl-9 order-xxl-0 order-first">
        <div class="d-flex flex-column h-100">
            <div class="row h-100">

                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i class="ri-arrow-up-circle-fill align-middle"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1"> Total Income</p>
                                    <h4 class=" mb-0"><span class="counter-value"
                                            data-target="{{ $income->amount }}">{{ $income->amount }}</span></h4>
                                </div>
                                <div class="flex-shrink-0 align-self-end">
                                    <span class="badge bg-primary-subtle text-primary">Frw<span>
                                        </span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i class="ri-arrow-down-circle-fill align-middle"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1">Total Expenses</p>
                                    <h4 class=" mb-0"><span class="counter-value"
                                            data-target="{{ $expense->amount }}">{{ $expense->amount }}</span></h4>
                                </div>
                                <div class="flex-shrink-0 align-self-end">

                                    <span class="badge bg-primary-subtle text-primary">Frw<span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
                <div class="col-lg-4 col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="avatar-sm flex-shrink-0">
                                    <span class="avatar-title bg-light text-primary rounded-circle fs-3">
                                        <i class="ri-money-dollar-circle-fill align-middle"></i>
                                    </span>
                                </div>
                                <div class="flex-grow-1 ms-3">
                                    <p class="text-uppercase fw-semibold fs-12 text-muted mb-1"> Balance</p>
                                    <h4 class=" mb-0"><span class="counter-value"
                                            data-target="{{ $balance }}">{{ $balance }}</span></h4>
                                </div>
                                <div class="flex-shrink-0 align-self-end">
                                    <span class="badge bg-primary-subtle text-primary">Frw<span>
                                </div>
                            </div>
                        </div><!-- end card body -->
                    </div><!-- end card -->
                </div><!-- end col -->
            </div><!-- end row -->

        </div>
    </div><!-- end col -->
</div>
