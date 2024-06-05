@php
    use Carbon\Carbon;
    use App\Models\User;
    use App\Models\PobPay;
    use App\Models\Incomes;
    use App\Models\Vehicle;
    use App\Models\Expenses;
    use App\Models\Outboxing;
    use App\Models\poutboxing;
    use App\Models\Eric\Inboxing;
    use App\Models\Eric\Transfer;
    use App\Models\Eric\Courierpay;
    use App\Models\posteloutboxing;
    use App\Models\registoutboxing;
    use App\Models\tembleoutboxing;
    use App\Models\Eric\TotalAllMails;
    use Illuminate\Support\Facades\DB;
    use App\Models\Eric\AirportDispach;
    use App\Http\Controllers\Controller;


    //register user dashboard
    $pendinginboxre = TotalAllMails::sum('rmt');
    $transferinboxre = Inboxing::where('mailtype', 'r')->where('instatus', '1')->count();
    $approvedinboxre = Inboxing::where('mailtype', 'r')->where('instatus', '0')->count();
    $pendinginboxo = TotalAllMails::sum('omt');
    $transferinboxo = Inboxing::where('mailtype', 'o')->where('instatus', '1')->count();
    $approvedinboxo = Inboxing::where('mailtype', 'o')->where('instatus', '0')->count();
    $pendinginboxp = TotalAllMails::sum('pmt');
    $transferinboxp = Inboxing::where('mailtype', 'p')->where('instatus', '1')->count();
    $approvedinboxp = Inboxing::where('mailtype', 'p')->where('instatus', '0')->count();
    $pendinginboxems = TotalAllMails::sum('emst');
    $transferinboxems = Inboxing::where('mailtype', 'ems')->where('instatus', '1')->count();
    $approvedinboxems = Inboxing::where('mailtype', 'ems')->where('instatus', '0')->count();

    $pendinginboxol = TotalAllMails::sum('olt');
    $transferinboxol = Inboxing::where('mailtype', 'ol')->where('instatus', '1')->count();
    $approvedinboxol = Inboxing::where('mailtype', 'ol')->where('instatus', '0')->count();

    $pendinginboxrl = TotalAllMails::sum('rlt');
    $transferinboxrl = Inboxing::where('mailtype', 'rl')->where('instatus', '1')->count();
    $approvedinboxrl = Inboxing::where('mailtype', 'rl')->where('instatus', '0')->count();

    $dispatchmailpending = Transfer::where('status', '0')
        ->where('touserid', auth()->user()->branch)
        ->count();
    $dispatchmailnotify = Transfer::where('status', '1')
        ->where('touserid', auth()->user()->branch)
        ->count();
    $dispatchmailtransfer = Inboxing::where('paystatus', '1')
        ->where('bid', auth()->user()->branch)
        ->count();

    $totaldriver = User::where('level', 'driver')->where('driverRole', 'driver')->count();
    $totalvehicle = Vehicle::all()->count();
    $totalassigned = User::where('level', 'driver')->where('driverRole', 'driver')->whereNotNull('vehicle_id')->count();
    $totalunassigned = User::where('level', 'driver')->where('driverRole', 'driver')->whereNull('vehicle_id')->count();
@endphp
@if (auth()->user()->office=='r')
    <div class="row">
        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Pending </p>
                        </div>

                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $pendinginboxre }}">{{ $pendinginboxre }}</span></h4>
                            <a href="{{ route('admin.mailsr.RegisteredMail') }}" class="text-decoration-underline">View pending</a>
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
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Registered</p>
                        </div>

                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $approvedinboxre }}">{{ $approvedinboxre }}</span></h4>

                            <a href="{{ route('admin.mailsr.RegisteredMail') }}" class="text-decoration-underline">View Registered</a>
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
        <div class="col-xl-4 col-md-6">
            <!-- card -->
            <div class="card card-animate">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-grow-1 overflow-hidden">
                            <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Transfered</p>
                        </div>

                    </div>
                    <div class="d-flex align-items-end justify-content-between mt-4">
                        <div>
                            <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$transferinboxre }}">{{ $transferinboxre }}</span></h4>

                            <a href="{{ route('admin.transferr.RegisteredMailTransfer') }}" class="text-decoration-underline">View Transfered</a>
                        </div>
                        <div class="avatar-sm flex-shrink-0">
                            <span class="avatar-title bg-soft-danger rounded fs-2">
                                <i class="bx bx-envelope text-danger"></i>
                            </span>
                        </div>
                    </div>
                </div><!-- end card body -->
            </div><!-- end card -->
        </div><!-- end col -->


</div> <!-- end row-->
@endif

 @if (auth()->user()->office=='o')
 <div class="row">
    <div class="col-xl-4 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Pending</p>
                    </div>

                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $pendinginboxo }}">{{ $pendinginboxo }}</span></h4>
                        <a href="{{ route('admin.mails.OrdinaryMail') }}" class="text-decoration-underline">View pending</a>
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
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Registered</p>
                    </div>

                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $approvedinboxo }}">{{ $approvedinboxo }}</span></h4>

                        <a href="{{ route('admin.mails.OrdinaryMail') }}" class="text-decoration-underline">View Registered</a>
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
    <div class="col-xl-4 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Transfered</p>
                    </div>

                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $transferinboxo }}">{{ $transferinboxo }}</span></h4>

                        <a href="{{ route('admin.transfero.OrdinaryMailTransfer') }}" class="text-decoration-underline">View Transfered</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-danger rounded fs-2">
                            <i class="bx bx-envelope text-danger"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->

 </div> <!-- end row-->
 @endif




 @if (auth()->user()->office=='p')
 <div class="row">
    <div class="col-xl-4 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Pending</p>
                    </div>

                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $pendinginboxp }}">{{ $pendinginboxp }}</span></h4>
                        <a href="{{ route('admin.mailsp.PercelMail') }}" class="text-decoration-underline">View pending</a>
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
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Registered</p>
                    </div>

                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{$approvedinboxp }}">{{ $approvedinboxo }}</span></h4>

                        <a href="{{ route('admin.mailsp.PercelMail') }}" class="text-decoration-underline">View Registered</a>
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
    <div class="col-xl-4 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Transfered</p>
                    </div>

                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $transferinboxp }}">{{ $transferinboxp }}</span></h4>

                        <a href="{{ route('admin.transferp.PercelMailTransfer') }}" class="text-decoration-underline">View Transfered</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-danger rounded fs-2">
                            <i class="bx bx-envelope text-danger"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->
 </div> <!-- end row-->
 @endif


@if (auth()->user()->office=='ems')

<div class="row">
    <div class="col-xl-4 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Pending</p>
                    </div>

                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $pendinginboxems }}">{{ $pendinginboxems }}</span></h4>
                        <a href="{{ route('admin.mailsem.EmsMail') }}" class="text-decoration-underline">View pending</a>
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
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Registered</p>
                    </div>

                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $approvedinboxems }}">{{ $approvedinboxems }}</span></h4>

                        <a href="{{ route('admin.mailsem.EmsMail') }}" class="text-decoration-underline">View Registered</a>
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
    <div class="col-xl-4 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Transfered</p>
                    </div>

                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $transferinboxems }}">{{ $transferinboxems }}</span></h4>

                        <a href="{{ route('admin.transferem.EmsMailTransfer') }}" class="text-decoration-underline">View Transfered</a>
                    </div>
                    <div class="avatar-sm flex-shrink-0">
                        <span class="avatar-title bg-soft-danger rounded fs-2">
                            <i class="bx bx-envelope text-danger"></i>
                        </span>
                    </div>
                </div>
            </div><!-- end card body -->
        </div><!-- end card -->
    </div><!-- end col -->


</div> <!-- end row-->
@endif



@if (auth()->user()->office=='letter')
<div class="row">
    <div class="col-xl-4 col-md-6">
        <!-- card -->
        <div class="card card-animate">
            <div class="card-body">
                <div class="d-flex align-items-center">
                    <div class="flex-grow-1 overflow-hidden">
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Pending OL</p>
                    </div>

                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $pendinginboxol }}">{{ $pendinginboxol }}</span></h4>

                        <a href="{{ route('admin.mailsol.OrdinaryLetter') }}" class="text-decoration-underline">View pending</a>
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
                        <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Registered OL</p>
                    </div>

                </div>
                <div class="d-flex align-items-end justify-content-between mt-4">
                    <div>
                        <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $approvedinboxol }}">{{ $approvedinboxol }}</span></h4>

                        <a href="{{ route('admin.mailsol.OrdinaryLetter') }}" class="text-decoration-underline">View Registered</a>
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

<div class="col-xl-4 col-md-6">
    <!-- card -->
    <div class="card card-animate">
        <div class="card-body">
            <div class="d-flex align-items-center">
                <div class="flex-grow-1 overflow-hidden">
                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Transfered OL</p>
                </div>

            </div>
            <div class="d-flex align-items-end justify-content-between mt-4">
                <div>
                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $transferinboxol }}">{{ $transferinboxol }}</span></h4>

                    <a href="{{ route('admin.transferol.OrdinaryLetterTransfer') }}" class="text-decoration-underline">View Transfered</a>
                </div>
                <div class="avatar-sm flex-shrink-0">
                    <span class="avatar-title bg-soft-danger rounded fs-2">
                        <i class="bx bx-envelope text-danger"></i>
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
                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Pending RL</p>
                </div>

            </div>
            <div class="d-flex align-items-end justify-content-between mt-4">
                <div>

                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $pendinginboxrl }}">{{ $pendinginboxrl }}</span></h4>
                    <a href="{{ route('admin.mailsrl.RegisteredLetter') }}" class="text-decoration-underline">View Pending</a>
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
                    <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Registered RL</p>
                </div>

            </div>
            <div class="d-flex align-items-end justify-content-between mt-4">
                <div>
                    <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $approvedinboxrl }}">{{ $approvedinboxrl }}</span></h4>

                    <a href="{{ route('admin.mailsrl.RegisteredLetter') }}" class="text-decoration-underline">View Registered</a>
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
<div class="col-xl-4 col-md-6">
<!-- card -->
<div class="card card-animate">
    <div class="card-body">
        <div class="d-flex align-items-center">
            <div class="flex-grow-1 overflow-hidden">
                <p class="text-uppercase fw-medium text-muted text-truncate mb-0">Transfered RL</p>
            </div>

        </div>
        <div class="d-flex align-items-end justify-content-between mt-4">
            <div>
                <h4 class="fs-22 fw-semibold ff-secondary mb-4"><span class="counter-value" data-target="{{ $transferinboxrl }}">{{ $transferinboxrl }}</span></h4>

                <a href="{{ route('admin.transferrl.RegisteredLetterTransfer') }}" class="text-decoration-underline">View Transfered</a>
            </div>
            <div class="avatar-sm flex-shrink-0">
                <span class="avatar-title bg-soft-danger rounded fs-2">
                    <i class="bx bx-envelope text-danger"></i>
                </span>
            </div>
        </div>
    </div><!-- end card body -->
</div><!-- end card -->
</div><!-- end col -->
</div> <!-- end row-->
@endif
