<?php

namespace App\Http\Controllers\Eric\Backoffice;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RegisteredMailIncomeController extends Controller
{
    public function index()
    {
        $courierPays = DB::table('courierpays')
        ->select(DB::raw('SUM(amount) as cash'), 'pdate')
        ->where('userid', auth()->user()->id)
        ->where('extra', 'r')
        ->groupBy('pdate')
        ->orderBy('pdate', 'DESC')
        ->limit(30)
        ->get();
        return view('admin.backoffice.rincames', compact('courierPays'));
    }
    public function submito(Request $request,$pdate){

$ddate = Carbon::now()->format('Y-m-d');
$rdate = Carbon::now()->format('Y-m-d');
// Check if the income record already exists
$existingIncome = DB::table('incomes')
    ->where('pdate', $request->pdate)
    ->where('userid', auth()->user()->id)
    ->where('office', 'r')
    ->get();

if ($existingIncome->count() >= 1) {
    // Update the existing income record
    $uqry = DB::table('incomes')
        ->where('userid', auth()->user()->id)
        ->where('pdate', $request->pdate)
        ->where('office', 'r')
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
        'office' => 'r',
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
    public function transactionr($pdate)
    {
        $inboxings = DB::table('courierpays')
        ->join('inboxings', 'courierpays.cid', '=', 'inboxings.id')
        ->select('inboxings.*', 'courierpays.*')
        ->where('courierpays.pdate',$pdate)
        ->where('courierpays.extra','r')
        ->where('courierpays.userid',auth()->user()->id)
        ->get();

        $pdf = Pdf::loadView('admin.backoffice.registeredtrainvoice', compact('pdate','inboxings'))
        ->setPaper('a4', 'portrait');
        return $pdf->stream('transactionregistered.pdf');
    }


}
