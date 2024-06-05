<?php

namespace App\Http\Controllers\Eric\Out;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Eric\Transferdetailsout;
use App\Models\Eric\Transferout;
use App\Models\OutboxingMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OutboxingTransfercontroller extends Controller
{
    // public function index(){
    //     $count = Outboxing::where('status',  '1')
    //             ->count();
    //     $employees = User::where('level',  'b')->get();

    //     $inboxings = DB::table('outboxing')
    //         ->join('branches', 'outboxing.blanch', '=', 'branches.id')
    //         ->select('outboxing.*', 'branches.name')->where('outboxing.status','1')->orderBy('outboxing.out_id', 'desc')->get();
    //     $bras = Branch::where('id',auth()->user()->branch)->get();
    //     $results = Transferout::where('mailtype','ems')
    //     ->where('bid', auth()->user()->branch)
    //     ->orderBy('id', 'desc')
    //     ->get();
    //     return view('branch.outboxing.emsmailouttransfer',compact('count','inboxings','employees','results','bras'));

    // }
    public function ems()
    {
        $outboxings = OutboxingMail::where('status', 1)->where('branch_id', auth()->user()->branch)
            ->where('user_id', auth()->user()->id)->where('type', 'ems')->orderByDesc('id')->get();

        $branch = Branch::findOrFail(auth()->user()->branch);
        $results = Transferout::where('mailtype', 'ems')
            ->where('bid', auth()->user()->branch)
            ->orderBy('id', 'desc')
            ->get();
        return view('branch.outboxing.transfer', compact('outboxings', 'results', 'branch'));

    }
    public function registerd()
    {
        $outboxings = OutboxingMail::where('status', 1)->where('branch_id', auth()->user()->branch)
            ->where('user_id', auth()->user()->id)->where('type', 'r')->orderByDesc('id')->get();

        $branch = Branch::findOrFail(auth()->user()->branch);
        $results = Transferout::where('mailtype', 'r')
            ->where('bid', auth()->user()->branch)
            ->orderBy('id', 'desc')
            ->get();
        return view('branch.outboxing.transfer', compact('outboxings', 'results', 'branch'));

    }
    public function percel()
    {
        $outboxings = OutboxingMail::where('status', 1)->where('branch_id', auth()->user()->branch)
            ->where('user_id', auth()->user()->id)->where('type', 'p')->orderByDesc('id')->get();

        $branch = Branch::findOrFail(auth()->user()->branch);
        $results = Transferout::where('mailtype', 'p')
            ->where('bid', auth()->user()->branch)
            ->orderBy('id', 'desc')
            ->get();
        return view('branch.outboxing.transfer', compact('outboxings', 'results', 'branch'));

    }
    public function store(Request $request)
    {
        $request->validate([
            'id' => 'required',
        ]);

        $transfer = Transferout::create([
            'fromuserid' => auth()->user()->id,
            'rvdate' => now(),
            'mnumber' => count($request->id),
            'mailtype' => $request->mailtype,
            'weight' => array_sum($request->weight),
            'touserid' => 1,
            'bid' => auth()->user()->branch,
        ]);
        if ($transfer) {
            foreach ($request->id as $key) {
                Transferdetailsout::create([
                    'trid' => $transfer->id,
                    'out_id' => $key,

                ]);
                OutboxingMail::findOrFail($key)->update([
                    'status' => 2,
                    'tradate' => now(), // This will set the transdate field to the current date and time
                ]);
            }
        }

        return back()->with('success', 'Thank you to  Transf mail and mail tranferd Successufully .');

    }
//     public function store(Request $request)
//     {
//         dd($request->all(),array_sum($request->weight),count($request->out_id));
//         $formField = $request->validate([
//             'out_id' => 'required',
//         ]);

//         $transfer = Transferout::create([
//             'fromuserid' => auth()->user()->id,
//             'rvdate' => now(),
//             'mnumber' => count($request->out_id),
//             'mailtype' => 'ems',
//             'weight' => array_sum($request->weight),
//             'touserid' => '1',
//             'bid' => auth()->user()->branch,
//         ]);
//    $trnsId = $transfer->id;
//       foreach ($request->out_id as $key) {
//         Transferdetailsout::create([
//             'trid' => $trnsId,
//             'out_id' => $key,

//         ]);
//         $outboxing = Outboxing::findOrFail($key);
//         // Update the fields with the new values
//         $outboxing->update([
//             'status' => '2',
//             'tradate' => now(), // This will set the transdate field to the current date and time
//         ]);
//       }

//       return back()->with('success', 'Thank you to  Transf mail and mail tranferd Successufully .');

//     }
    // invoice

}
