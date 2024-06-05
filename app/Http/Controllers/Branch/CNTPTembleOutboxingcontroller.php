<?php

namespace App\Http\Controllers\Eric\Out;

use Carbon\Carbon;
use App\Models\Box;
use App\Models\Branch;
use Barryvdh\DomPDF\PDF;
use Illuminate\Http\Request;
use App\Models\tembleoutboxing;
use App\Models\Eric\Transferout;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class CNTPTembleOutboxingcontroller extends Controller
{
    public function index()
    {   $count = Transferout::where('status','0')
        ->where('mailtype','t')
        ->count();
        $branches = Branch::all();
        return view('admin.cntp.cntpmailtembleoutboxing', compact('branches','count'));
    }
    public function index2($id)
    {
        $boxes = Box::all();
        $branches = Branch::all();
        $results = Transferout::where('bid', decrypt($id))
        ->where('mailtype','t')
            ->orderBy('id', 'desc')->get();

        return view('admin.cntp.cntptembleview', compact('results', 'boxes', 'branches'));
    }
    public function update(Request $request, $id)
    {
        $formField = $request->validate([
            'out_id' => 'required',
        ]);
        $currentDateTime = Carbon::now();
        foreach ($request->out_id as $value) {
            $outboxing = tembleoutboxing::findOrFail($value);
            // Update the fields with the new values
            $outboxing->update([
                'status' => '3',
                'recdate' => now(), // This will set the transdate field to the current date and time
            ]);
        }
        $trans = Transferout::findOrFail($id);
        // Update the fields with the new values
        $trans->update([
            'status' => '1',
            'rvdate' => now(), // This will set the transdate field to the current date and time
        ]);

        return back()->with('success', 'Thank you for receiveing this dispatch');
    }
    public function dailyreport()
    {
        $opens = DB::table('transferouts')
        ->select(DB::raw('pdate'), DB::raw('SUM(weight) as weight'), DB::raw('count(*) as total'))
        ->where('status','1')
        ->where('mailtype','t')
        ->groupBy('pdate')
        ->orderBy('pdate', 'DESC')
        ->limit(20)
        ->get();


        return view('admin.cntp.temblecntpoutboxing', compact('opens'));
    }
 public function dailyreout($pdate)
    {
        $currentDateTime = Carbon::now();
        $date = decrypt($pdate);
        $inboxings = tembleoutboxing::where('pdate', $date)
            ->where('status', '3')
            ->get();
        $pdf = \PDF::loadView('admin.cntp.dailytemblecntpoutboxing', compact('date', 'inboxings', 'currentDateTime'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('DailyTemblereport.pdf');
    }
}
