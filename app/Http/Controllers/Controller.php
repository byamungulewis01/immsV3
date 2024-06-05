<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\InboxingReport;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;



    public function mailOutReport($mailtype)
    {
        $inbox_reports = InboxingReport::where('branch', auth()->user()->branch)->first();
        if ($inbox_reports) {
            $balance = InboxingReport::where('branch', auth()->user()->branch)->where('mailtype', $mailtype)->latest()->first()->balance;
            $currentDate = Carbon::today();
            $reports = InboxingReport::where('branch', auth()->user()->branch)->where('mailtype', $mailtype)->whereDate('created_at', $currentDate)->first();
            if ($reports) {
                $reports->update([
                    'outMails' => $reports->outMails + 1,
                    'balance' => $balance - 1,
                ]);
            } else {
                InboxingReport::create([
                    'mailtype' => $mailtype,
                    'outMails' => 1,
                    'balance' => $balance - 1,
                    'branch' => auth()->user()->branch
                ]);
            }
        }
    }
}
