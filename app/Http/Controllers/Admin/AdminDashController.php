<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminDashController extends Controller
{
    //
    public function index()
    {
        return view('admin.index');
    }
}

// use Carbon\Carbon;
// use App\Models\User;
// use App\Models\PobPay;
// use App\Models\Incomes;
// use App\Models\Vehicle;
// use App\Models\Expenses;
// use App\Models\Outboxing;
// use App\Models\poutboxing;
// use App\Models\Eric\Inboxing;
// use App\Models\Eric\Transfer;
// use App\Models\Eric\Courierpay;
// use App\Models\posteloutboxing;
// use App\Models\registoutboxing;
// use App\Models\tembleoutboxing;
// use App\Models\Eric\TotalAllMails;
// use Illuminate\Support\Facades\DB;
// use App\Models\Eric\AirportDispach;
// use App\Http\Controllers\Controller;


//         //admin dashboard
//         $postageems = Outboxing::sum('amount');
//         $ainboxing = Courierpay::sum('amount');
//         $cartonems = Outboxing::sum('postage');
//         $postagereg = poutboxing::sum('amount');
//         $cartonreg = poutboxing::sum('postage');
//         $cartepo = posteloutboxing::sum('amount');
//         $cartonpercel = registoutboxing::sum('postage');
//         $postagepercel = registoutboxing::sum('amount');
//         $temble = tembleoutboxing::sum('temb_amount');
//         $pobpays = PobPay::sum('amount');
//         $inc=Incomes::sum('e_amount');
//         $income = $postageems + $cartonems + $postagereg + $cartonreg + $cartepo + $cartonpercel + $postagepercel + $temble + $pobpays + $inc + $ainboxing;
//         $expenses = Expenses::where('e_status', 1)->sum('e_amount');
//         $balance = $income - $expenses;
//         //end of admin dashboard
//         // branch manager dashboard

//         $postageemsbranch = Outboxing::where('blanch',auth()->user()->branch)->sum('amount');
//         $cinboxing = Courierpay::where('bid',auth()->user()->branch)->sum('amount');
//         $cartonemsbranch = Outboxing::where('blanch',auth()->user()->branch)->sum('postage');
//         $postageregbranch =poutboxing::where('blanch',auth()->user()->branch)->sum('amount');
//         $cartonregbranch = poutboxing::where('blanch',auth()->user()->branch)->sum('postage');
//         $cartepobranch = posteloutboxing::where('blanch',auth()->user()->branch)->sum('amount');
//         $cartonpercelbranch = registoutboxing::where('blanch',auth()->user()->branch)->sum('postage');
//         $postagepercelbranch = registoutboxing::where('blanch',auth()->user()->branch)->sum('amount');
//         $temblebranch = tembleoutboxing::where('blanch',auth()->user()->branch)->sum('amount');
//         $pobpaysbranch = PobPay::where('bid',auth()->user()->branch)->sum('amount');
//         $inc=Incomes::where('branch_id',auth()->user()->branch)->sum('e_amount');
//         $incomebranch = $postageemsbranch + $cartonemsbranch + $postageregbranch + $cartonregbranch + $cartepobranch + $cartonpercelbranch + $postagepercelbranch + $temblebranch + $pobpaysbranch + $cinboxing;
//         $expensesbranch = Expenses::where('e_status', 1)->where('branch_id',auth()->user()->branch)->sum('e_amount');
//         $balancebranch = $incomebranch - $expensesbranch;
//          // end of branch manager  dashborad
//          //airport user dashborad
//          $pendingdispatch = AirportDispach::where('cntp_id',auth()->user()->id)->where('status','0')->count();
//          $assigneddispatch = AirportDispach::where('cntp_id',auth()->user()->id)->where('status','1')->count();
//          $approveddispatchcntp = AirportDispach::where('cntp_id',auth()->user()->id)->where('status','2')->count();
//          //end of airport user dashborad
//          //cntp user dashboard
//          $pendingdispatchcntp = AirportDispach::where('status','1')->count();
//          $approveddispatchcntps = AirportDispach::where('status','2')->count();
//          $approveddispatchopen = AirportDispach::whereNotNull('mailnumber')->count();
//          //end of cntp user dashboard
//          //register user dashboard
//          $pendinginboxre = TotalAllMails::sum('rmt');
//          $transferinboxre = Inboxing::where('mailtype','r')->where('instatus','1')->count();
//          $approvedinboxre = Inboxing::where('mailtype','r')->where('instatus','0')->count();
//          $pendinginboxo = TotalAllMails::sum('omt');
//          $transferinboxo = Inboxing::where('mailtype','o')->where('instatus','1')->count();
//          $approvedinboxo = Inboxing::where('mailtype','o')->where('instatus','0')->count();
//          $pendinginboxp = TotalAllMails::sum('pmt');
//          $transferinboxp = Inboxing::where('mailtype','p')->where('instatus','1')->count();
//          $approvedinboxp = Inboxing::where('mailtype','p')->where('instatus','0')->count();
//          $pendinginboxems = TotalAllMails::sum('emst');
//          $transferinboxems = Inboxing::where('mailtype','ems')->where('instatus','1')->count();
//          $approvedinboxems = Inboxing::where('mailtype','ems')->where('instatus','0')->count();

//          $pendinginboxol = TotalAllMails::sum('olt');
//          $transferinboxol = Inboxing::where('mailtype','ol')->where('instatus','1')->count();
//          $approvedinboxol = Inboxing::where('mailtype','ol')->where('instatus','0')->count();

//          $pendinginboxrl = TotalAllMails::sum('rlt');
//          $transferinboxrl = Inboxing::where('mailtype','rl')->where('instatus','1')->count();
//          $approvedinboxrl = Inboxing::where('mailtype','rl')->where('instatus','0')->count();

//          $dispatchmailpending = Transfer::where('status','0')->where('touserid',auth()->user()->branch)->count();
//          $dispatchmailnotify = Transfer::where('status','1')->where('touserid',auth()->user()->branch)->count();
//          $dispatchmailtransfer = Inboxing::where('paystatus','1')->where('bid',auth()->user()->branch)->count();

//          $totaldriver = User::where('level', 'driver')->where('driverRole','driver')->count();
//          $totalvehicle = Vehicle::all()->count();
//          $totalassigned = User::where('level', 'driver')->where('driverRole','driver')->whereNotNull('vehicle_id')->count();
//          $totalunassigned =  User::where('level', 'driver')->where('driverRole','driver')->whereNull('vehicle_id')->count();
// //AIRPORT EMS

//       // Query to get the created days for the past five days
// // Query to get the created days for the past five days
// // Retrieve dates for the past five days
// $created_days = AirportDispach::where('cntp_id', auth()->user()->id)
//     ->select(DB::raw('DATE(created_at) as created_day'))
//     ->groupBy('created_day')
//     ->orderBy('created_day', 'DESC')
//     ->limit(5)
//     ->pluck('created_day')
//     ->toArray();

// // Query to get the dispatch count for EMS for the past five days
// $dispatch_counts_ems = AirportDispach::where('cntp_id', auth()->user()->id)
//     ->select(DB::raw('DATE(created_at) as created_day'), DB::raw('COALESCE(COUNT(*), 0) as dispatch_count'))
//     ->where('dispachetype', 'EMS')
//     ->whereIn(DB::raw('DATE(created_at)'), $created_days)
//     ->groupBy(DB::raw('DATE(created_at)'))
//     ->orderBy('created_day', 'DESC')
//     ->pluck('dispatch_count', 'created_day')
//     ->toArray();

// // Query to get the dispatch count for PERCEL for the past five days
// $dispatch_counts_percel = AirportDispach::where('cntp_id', auth()->user()->id)
//     ->select(DB::raw('DATE(created_at) as created_day'), DB::raw('COALESCE(COUNT(*), 0) as dispatch_count'))
//     ->where('dispachetype', 'PERCEL')
//     ->whereIn(DB::raw('DATE(created_at)'), $created_days)
//     ->groupBy(DB::raw('DATE(created_at)'))
//     ->orderBy('created_day', 'DESC')
//     ->pluck('dispatch_count', 'created_day')
//     ->toArray();

// // Query to get the dispatch count for Mails for the past five days
// $dispatch_counts_mails = AirportDispach::where('cntp_id', auth()->user()->id)
//     ->select(DB::raw('DATE(created_at) as created_day'), DB::raw('COALESCE(COUNT(*), 0) as dispatch_count'))
//     ->where('dispachetype', 'Mails')
//     ->whereIn(DB::raw('DATE(created_at)'), $created_days)
//     ->groupBy(DB::raw('DATE(created_at)'))
//     ->orderBy('created_day', 'DESC')
//     ->pluck('dispatch_count', 'created_day')
//     ->toArray();



//          return view('admin.index', compact('dispatch_counts_ems','dispatch_counts_percel','created_days', 'dispatch_counts_mails','approveddispatchopen','income', 'expenses', 'balance','incomebranch', 'expensesbranch', 'balancebranch'
//       ,'pendingdispatch','assigneddispatch','approveddispatchcntp','pendingdispatchcntp','approveddispatchcntps','pendinginboxre','approvedinboxre','transferinboxre',
//     'pendinginboxo','transferinboxo','approvedinboxo','pendinginboxp','transferinboxp','approvedinboxp'
//     ,'pendinginboxems','transferinboxems','approvedinboxems','pendinginboxol','transferinboxol','approvedinboxol'
//     ,'pendinginboxrl','transferinboxrl','approvedinboxrl','dispatchmailpending'
//     ,'dispatchmailnotify','dispatchmailtransfer','totaldriver','totalvehicle','totalassigned','totalunassigned'));
//     }


//         return view('admin.index');

