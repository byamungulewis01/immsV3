<?php

namespace App\Http\Controllers\Cntp;

use App\Models\Box;
use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Models\Eric\Transfer;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Eric\Transferdatails;

class PostCardTransferMailController extends Controller
{
    public function index()
    {
        $branches = Branch::all();

        return view('admin.register.postcardtransfer', compact('branches'));
    }
    public function registertr($id){
        //$inboxings = Inboxing::where('location',$id)->where('instatus','0')->where('mailtype','ems')->get() ;
        //$boxes = Box::all();
       // $branches = Branch::all();
        //$bras = Branch::where('id',$id)->get();
        $count = Inboxing::where('mailtranserf',  '0')
                ->Where('mailtype',  'POD')
                ->Where('location',  decrypt($id))
                ->count();
        $employees = User::where('level',  'b')->get();

        $inboxings = DB::table('inboxings')
            ->join('branches', 'inboxings.bid', '=', 'branches.id')
            ->select('inboxings.*', 'branches.name')->where('inboxings.instatus','0')->where('mailtype','POD')->where('inboxings.instatus','0')->where('location',decrypt($id))->orderBy('inboxings.id', 'desc')->get();
        $bras = Branch::where('id',decrypt($id))->get();
        $results = Transfer::where('mailtype','POD')->where('touserid',decrypt($id))->get();
        return view('admin.register.postcardtransferformreg',compact('id','count','inboxings','employees','results','bras'));
    }
    public function posttn(Request $request)
    {
        $formField = $request->validate([
            'mnumber' => 'required',
            'touserid' => 'required',
        ]);
    $totalpmt = Branch::where('id',$request->touserid)->sum('podt');
    $mnumber = $request->mnumber;
    if($totalpmt<$mnumber){
        return back()->with('warning', 'Not Transfered Becouse number of Percel Transfer is Higher than Percel Transfer In Store.');
    }
    else{

     Branch::where('id',$request->touserid)->decrement('podt',$request->mnumber);

     $transfer = Transfer::create([
        'fromuserid' => auth()->user()->id,
        'touserid' =>$request->touserid,
        'rvdate' => now(),
        'mailtype' => 'POD',
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
        ->where('transfers.mailtype', 'POD')
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
        'mailtype' => 'POD',
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
    public function invoicepostcard($id)
    {
        $inboxings = DB::select("SELECT * FROM inboxings WHERE id IN (SELECT inid FROM transferdatails WHERE trid = ?)", [(decrypt($id))]);
        $pdf = Pdf::loadView('admin.register.invoicepostcard', compact('inboxings','id'))
        ->setPaper('a4', 'portrait');
         return $pdf->stream('PostCardTransfer.pdf');
    }
}
