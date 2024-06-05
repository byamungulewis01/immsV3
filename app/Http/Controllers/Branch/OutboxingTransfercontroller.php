<?php

namespace App\Http\Controllers\Eric\Out;
use App\Models\User;
use App\Models\Branch;
use App\Models\Outboxing;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Models\Eric\Transferout;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Eric\Transferdatails;
use Illuminate\Support\Facades\Auth;
use App\Models\Eric\Transferdetailsout;

class OutboxingTransfercontroller extends Controller
{
    public function index(){
        $count = Outboxing::where('status',  '1')
                ->count();
        $employees = User::where('level',  'b')->get();

        $inboxings = DB::table('outboxing')
            ->join('branches', 'outboxing.blanch', '=', 'branches.id')
            ->select('outboxing.*', 'branches.name')->where('outboxing.status','1')->orderBy('outboxing.out_id', 'desc')->get();
        $bras = Branch::where('id',auth()->user()->branch)->get();
        $results = Transferout::where('mailtype','ems')
        ->where('bid', auth()->user()->branch)
        ->orderBy('id', 'desc')
        ->get();
        return view('branch.outboxing.emsmailouttransfer',compact('count','inboxings','employees','results','bras'));

    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'out_id' => 'required',
        ]);

        $transfer = Transferout::create([
            'fromuserid' => auth()->user()->id,
            'rvdate' => now(),
            'mnumber' => count($request->out_id),
            'mailtype' => 'ems',
            'weight' => array_sum($request->weight),
            'touserid' => '1',
            'bid' => auth()->user()->branch,
        ]);
   $trnsId = $transfer->id;
      foreach ($request->out_id as $key) {
        Transferdetailsout::create([
            'trid' => $trnsId,
            'out_id' => $key,

        ]);
        $outboxing = Outboxing::findOrFail($key);
        // Update the fields with the new values
        $outboxing->update([
            'status' => '2',
            'tradate' => now(), // This will set the transdate field to the current date and time
        ]);
      }

      return back()->with('success', 'Thank you to  Transf mail and mail tranferd Successufully .');

    }
    // invoice


}
