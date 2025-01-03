<?php

namespace App\Http\Controllers\Eric\Out;

use PDF;
use Carbon\Carbon;
use App\Models\Box;
use App\Models\Branch;
use App\Models\poutboxing;
use Illuminate\Http\Request;
use App\Models\OutboxingMail;
use App\Models\Eric\Transferout;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CNTPRegisteredOutboxingcontroller extends Controller
{
    public function index()
    {   $count = Transferout::where('status','0')
        ->where('mailtype','r')
        ->count();
        $branches = Branch::all();
        return view('admin.cntp.cntpmailregisteredoutboxing', compact('branches','count'));
    }
    public function index2($id)
    {
        $boxes = Box::all();
        $branches = Branch::all();
        $results = Transferout::where('bid', decrypt($id))
        ->where('mailtype','r')
            ->orderBy('id', 'desc')->get();

        return view('admin.cntp.cntpregisteredview', compact('results', 'boxes', 'branches'));
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'out_id' => 'required',
        ]);
        foreach ($request->out_id as $value) {

            OutboxingMail::findOrFail($value)->update([
                'status' => 3,
                'recdate' => now(), // This will set the transdate field to the current date and time
            ]);
        }
        Transferout::findOrFail($id)->update([ 'status' => '1', 'rvdate' => now()]);

        return back()->with('success', 'Thank you for receiveing this dispatch');

    }
    public function dailyreport()
    {

        $opens = DB::table('transferouts')
        ->select(DB::raw('pdate'), DB::raw('SUM(weight) as weight'), DB::raw('count(*) as total'))
        ->where('status','1')
        ->where('mailtype','r')
        ->groupBy('pdate')
        ->orderBy('pdate', 'DESC')
        ->limit(20)
        ->get();

        return view('admin.cntp.registercntpoutboxingrep', compact('opens'));
    }
    public function dailyreout($pdate)
    {
        $currentDateTime = Carbon::now();
        $date = decrypt($pdate);
        // $inboxings = poutboxing::where('pdate', $date)
        //     ->where('status', '3')
        //     ->get();
        $inboxings = OutboxingMail::where('type','registered')->whereDate('created_at', $date)
            ->where('status', '3')
            ->get();

            // dd($inboxings);
        $pdf = PDF::loadView('admin.cntp.dailyregisteredcntpoutboxing', compact('date', 'inboxings', 'currentDateTime'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('DailyRegisteredreport.pdf');
    }

}
