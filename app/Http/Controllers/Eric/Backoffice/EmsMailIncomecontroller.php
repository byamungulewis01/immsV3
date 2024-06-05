<?php

namespace App\Http\Controllers\Eric\Backoffice;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EmsMailIncomecontroller extends Controller
{
    public function index()
    {
        $courierPays = DB::table('courierpays')
        ->select(DB::raw('SUM(amount) as cash'), 'pdate')
        ->where('userid', auth()->user()->id)
        ->where('extra', 'ems')
        ->groupBy('pdate')
        ->orderBy('pdate', 'DESC')
        ->limit(30)
        ->get();
        return view('admin.backoffice.emsincome', compact('courierPays'));
    }
    public function submito(Request $request,$pdate){

$ddate = Carbon::now()->format('Y-m-d');
$rdate = Carbon::now()->format('Y-m-d');
// Check if the income record already exists
$existingIncome = DB::table('incomes')
    ->where('pdate', $request->pdate)
    ->where('userid', auth()->user()->id)
    ->where('office', 'ems')
    ->get();

if ($existingIncome->count() >= 1) {
    // Update the existing income record
    $uqry = DB::table('incomes')
        ->where('userid', auth()->user()->id)
        ->where('pdate', $request->pdate)
        ->where('office', 'ems')
        ->update([
            'amount' => $request->amount,
            'ddate' => $ddate,
        ]);

    if ($uqry) {
        return back()->with('success', 'Thank you to submit NPO daily income again');

    } else {
        return back()->with('success', 'Thank you to submit NPO daily income again');


    }
} else {
    // Insert a new income record
    $uqry = DB::table('incomes')->insert([
        'userid' => auth()->user()->id,
        'office' => 'ems',
        'amount' => $request->amount,
        'realamount' => '0',
        'pdate' => $request->pdate,
        'ddate' => $ddate,
        'rdate' => $ddate,
        'bid' => auth()->user()->branch,
    ]);

    if ($uqry) {
        return back()->with('success', 'Thank you to submit NPO daily income.');
    } else {
        return back()->with('success', 'Thank you to submit NPO daily income.');
    }
}
    }
    public function transactionems($pdate)
    {
        $inboxings = DB::table('courierpays')
        ->join('inboxings', 'courierpays.cid', '=', 'inboxings.id')
        ->select('inboxings.*', 'courierpays.*')
        ->where('courierpays.pdate',$pdate)
        ->where('courierpays.extra','ems')
        ->where('courierpays.userid',auth()->user()->id)
        ->get();

        $pdf = Pdf::loadView('admin.backoffice.emstransaction', compact('pdate','inboxings'))
        ->setPaper('a4', 'portrait');
        return $pdf->stream('transactionems.pdf');
    }

}
