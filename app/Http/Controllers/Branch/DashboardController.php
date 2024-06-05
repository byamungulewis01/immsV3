<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\Eric\Inboxing;
use App\Models\OutboxingMail;

class DashboardController extends Controller
{
    //
    public function ems_inboxing()
    {
        if (auth()->user()->level == 'administrative') {
            $total_number = Inboxing::where('mailtype', 'ems')->count();
            $current_month = Inboxing::where('mailtype', 'ems')->whereMonth('created_at',now()->month)->count();
            // $districts = Inboxing::where('mailtype', 'ems')->whereMonth('created_at',now()->month - 1 )->count();
            $last_month = Inboxing::where('mailtype', 'ems')->whereMonth('created_at',now()->month - 1 )->count();
            $destination = Inboxing::where('mailtype', 'ems')->groupBy('orgcountry')->get()->count();
            $weights = Inboxing::where('mailtype', 'ems')->sum('weight');
        } else {
            $total_number = Inboxing::where('mailtype', 'ems')->where('bid', auth()->user()->branch)->count();
            $current_month = Inboxing::where('mailtype', 'ems')->where('bid', auth()->user()->branch)->whereMonth('created_at',now()->month)->count();
            $last_month = Inboxing::where('mailtype', 'ems')->where('bid', auth()->user()->branch)->whereMonth('created_at',now()->month - 1 )->count();
            $destination = Inboxing::where('mailtype', 'ems')->where('bid', auth()->user()->branch)->groupBy('orgcountry')->get()->count();
            $weights = Inboxing::where('mailtype', 'ems')->where('bid', auth()->user()->branch)->sum('weight');

        }

        return view('branch.dashboard.ems-inboxing', compact('total_number','current_month','last_month','destination','weights'));
    }
    public function ems_outboxing()
    {
        if (auth()->user()->level == 'administrative') {
            $total_number = OutboxingMail::where('type', 'ems')->count();
            $current_month = OutboxingMail::where('type', 'ems')->whereMonth('created_at',now()->month)->count();
            // $districts = OutboxingMail::where('type', 'ems')->whereMonth('created_at',now()->month - 1 )->count();
            $last_month = OutboxingMail::where('type', 'ems')->whereMonth('created_at',now()->month - 1 )->count();
            $districts = OutboxingMail::where('type', 'ems')->groupBy('district')->get()->count();
            $destination = OutboxingMail::where('type', 'ems')->groupBy('country')->get()->count();
            $weights = OutboxingMail::where('type', 'ems')->sum('weight');
        } else {
            $total_number = OutboxingMail::where('type', 'ems')->where('branch_id', auth()->user()->branch)->count();
            $current_month = OutboxingMail::where('type', 'ems')->where('branch_id', auth()->user()->branch)->whereMonth('created_at',now()->month)->count();
            $last_month = OutboxingMail::where('type', 'ems')->where('branch_id', auth()->user()->branch)->whereMonth('created_at',now()->month - 1 )->count();
            $districts = OutboxingMail::where('type', 'ems')->where('branch_id', auth()->user()->branch)->groupBy('district')->get()->count();
            $destination = OutboxingMail::where('type', 'ems')->where('branch_id', auth()->user()->branch)->groupBy('country')->get()->count();
            $weights = OutboxingMail::where('type', 'ems')->where('branch_id', auth()->user()->branch)->sum('weight');

        }

        return view('branch.dashboard.ems-outboxing', compact('total_number','current_month','last_month','destination','districts','weights'));
    }
    public function ordinal_inboxing()
    {
        return view('branch.dashboard.ordinal-inboxing');
    }
    public function ordinal_outboxing()
    {
        return view('branch.dashboard.ordinal-outboxing');
    }
    public function percel_inboxing()
    {
        return view('branch.dashboard.percel-inboxing');
    }
    public function percel_outboxing()
    {
        return view('branch.dashboard.percel-outboxing');
    }

}
