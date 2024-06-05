<?php

namespace App\Http\Controllers\Eric\Out;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\registoutboxing;
use App\Models\Eric\Transferout;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Eric\Transferdetailsout;

class PerceloutboxingTransfercontroller extends Controller
{
    public function index(){
        $count = registoutboxing::where('status',  '1')
                ->count();
        $employees = User::where('level',  'b')->get();

        $inboxings = DB::table('registoutboxing')
            ->join('branches', 'registoutboxing.blanch', '=', 'branches.id')
            ->select('registoutboxing.*', 'branches.name')->where('registoutboxing.status','1')->orderBy('registoutboxing.out_id', 'desc')->get();
        $bras = Branch::where('id',auth()->user()->branch)->get();
        $results = Transferout::where('mailtype','p')
        ->where('bid', auth()->user()->branch)
        ->orderBy('id', 'desc')
        ->get();
        return view('branch.perceloutboxing.perceloutboxingtransfer',compact('count','inboxings','employees','results','bras'));

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
        'mailtype' => 'p',
        'touserid' => '1',
        'weight' => array_sum($request->weight),
        'bid' => auth()->user()->branch,
      ]);
   $trnsId = $transfer->id;
      foreach ($request->out_id as $key) {
        Transferdetailsout::create([
            'trid' => $trnsId,
            'out_id' => $key,
        ]);
        $outboxing = registoutboxing::findOrFail($key);
        // Update the fields with the new values
        $outboxing->update([
            'status' => '2',
            'tradate' => now(), // This will set the transdate field to the current date and time
        ]);
      }

      return back()->with('success', 'Thank you to  Transf mail and mail tranferd Successufully .');

    }
}
