<?php

namespace App\Http\Controllers\Cntp;

use App\Models\Box;
use App\Models\User;
use App\Models\Branch;
use App\Models\Eric\Namming;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Models\Eric\Transfer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Eric\Transferdatails;

class JurnalTransferController extends Controller
{
    public function index()
    {
        $branches = Branch::all();

        return view('admin.register.jurnaltransfer', compact('branches'));
    }
    public function registertr($id){
        //$inboxings = Inboxing::where('location',$id)->where('instatus','0')->where('mailtype','ems')->get() ;
        //$boxes = Box::all();
       // $branches = Branch::all();
        //$bras = Branch::where('id',$id)->get();
        $count = Inboxing::where('mailtranserf',  '0')
                ->Where('mailtype',  'JUR')
                ->Where('location',  decrypt($id))
                ->count();
        $employees = User::where('level',  'b')->get();

        $inboxings = DB::table('inboxings')
            ->join('branches', 'inboxings.bid', '=', 'branches.id')
            ->select('inboxings.*', 'branches.name')->where('inboxings.instatus','0')->where('mailtype','JUR')->where('inboxings.instatus','0')->where('location',decrypt($id))->orderBy('inboxings.id', 'desc')->get();
        $bras = Branch::where('id',decrypt($id))->get();
        $results = Transfer::where('mailtype','JUR')->where('touserid',decrypt($id))->get();
        return view('admin.register.jurnaltransferformreg',compact('id','count','inboxings','employees','results','bras'));
    }
    public function jurnaltn(Request $request)
    {
        $formField = $request->validate([
            'mnumber' => 'required',
            'touserid' => 'required',
        ]);
    $totalpmt = Branch::where('id',$request->touserid)->sum('jrt');
    $mnumber = $request->mnumber;
    if($totalpmt<$mnumber){
        return back()->with('warning', 'Not Transfered Becouse number of Percel Transfer is Higher than Percel Transfer In Store.');
    }
    else{

     Branch::where('id',$request->touserid)->decrement('jrt',$request->mnumber);

     $transfer = Transfer::create([
        'fromuserid' => auth()->user()->id,
        'touserid' =>$request->touserid,
        'rvdate' => now(),
        'mailtype' => 'JUR',
        'mnumber' =>$request->mnumber,
      ]);
    }

      return back()->with('success', 'Thank you to  Transf mail and mail tranferd Successufully .');

    }
    public function RegApi($id,$user)
    {
        $results = Transfer::join('users', 'transfers.fromuserid', '=', 'users.id')
        ->join('branches', 'transfers.touserid', '=', 'branches.id')
        ->select('users.name as user_name', 'branches.name as branch_name','transfers.id as idd','transfers.mnumber as mnumb','transfers.created_at as dates')
        ->where('transfers.mailtype', 'JUR')
        ->where('transfers.touserid', decrypt($id))
        ->orderBy('transfers.id', 'desc')
        ->get();


        // $inboxings = Inboxing::where('location',$id)->get();

        return response()->json([
            'data' => $results,
            'status' => 200,
        ]);
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'inid' => 'required',
            'touserid' => 'required',
        ]);

    $transfer = Transfer::create([
        'fromuserid' => auth()->user()->id,
        'touserid' => decrypt($request->touserid),
        'rvdate' => now(),
        'mnumber' => count($request->inid),
        'mailtype' => 'JUR',
      ]);
   $trnsId = $transfer->id;
      foreach ($request->inid as $key) {
        Transferdatails::create([
            'trid' => $trnsId,
            'inid' => $key,
        ]);
        $inboxing = Inboxing::findOrFail($key);

        // Update the fields with the new values
        $inboxing->update([
            'mailtranserf' => '1',
            'instatus' => '1',
            'transdate' => now(), // This will set the transdate field to the current date and time
        ]);
      }

      return back()->with('success', 'Thank you to  Transf mail and mail tranferd Successufully .');

    }
    // invoice
    public function invoicejurnal($id)
    {
        $inboxings = DB::select("SELECT * FROM inboxings WHERE id IN (SELECT inid FROM transferdatails WHERE trid = ?)", [(decrypt($id))]);
        $pdf = Pdf::loadView('admin.register.invoicejurnal', compact('inboxings','id'))
        ->setPaper('a4', 'portrait');
         return $pdf->stream('JurnalMailTransfer.pdf');
    }
}
