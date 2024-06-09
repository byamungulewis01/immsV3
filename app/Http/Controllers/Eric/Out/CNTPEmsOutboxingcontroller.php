<?php

namespace App\Http\Controllers\Eric\Out;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Eric\Transferout;
use App\Models\OutboxingMail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;

class CNTPEmsOutboxingcontroller extends Controller
{
    public function index()
    {
        $count = Transferout::where('status', '0')
            ->where('mailtype', 'ems')->count();
        $branches = Branch::all();
        return view('admin.cntp.cntpmailemsautboxing', compact('branches', 'count'));
    }
    public function index2($id)
    {

        $branches = Branch::all();
        $results = Transferout::where('bid', decrypt($id))
            ->where('mailtype', 'ems')->orderBy('id', 'desc')->get();

        return view('admin.cntp.ctntpemsview', compact('results', 'branches'));
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
        Transferout::findOrFail($id)->update(['status' => '1', 'rvdate' => now()]);

        return back()->with('success', 'Thank you for receiveing this dispatch');
    }
    public function verify(Request $request, $id)
    {
        Transferout::findOrFail($id)->update([
            'recieced_weight' => $request->recieced_weight,
            'cntp_comment' => $request->cntp_comment,
            'status' => '2']);

        return back()->with('success', 'Dispatcher opened and verified');
    }
    public function dailyreport()
    {
        $opens = DB::table('transferouts')
            ->select(DB::raw('pdate'), DB::raw('SUM(weight) as weight'), DB::raw('count(*) as total'))
            ->where('status', '1')
            ->where('mailtype', 'ems')
            ->groupBy('pdate')
            ->orderBy('pdate', 'DESC')
            ->limit(20)
            ->get();

        return view('admin.cntp.emscntpoutboxing', compact('opens'));
    }
    public function dailyreout($pdate)
    {
        $currentDateTime = Carbon::now();
        $date = decrypt($pdate);
        // $inboxings = Outboxing::where('pdate', $date)
        //     ->where('status', '3')
        //     ->get();
        $inboxings = OutboxingMail::where('type', 'ems')->whereDate('created_at', $date)
            ->where('status', '3')
            ->get();
        $pdf = Pdf::loadView('admin.cntp.dailyemscntpoutboxing', compact('date', 'inboxings', 'currentDateTime'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('Dailyopeningreport.pdf');
    }

}
