<?php

namespace App\Http\Controllers\Branch;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Models\OutboxingMail;
use App\Models\registoutboxing;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\single_country_tarif;
use App\Models\stock_branch_balance;
use Illuminate\Support\Facades\Auth;

class PercelOutboxingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // return dd(single_country_tarif::single_country_tarif());
        $blanch = Auth::user()->branch;
        //model of stock_branch_balance;
        $items = stock_branch_balance::branch_balance([$blanch],"sell");
        // get outboxing records based on blanch
        $outboxings = registoutboxing::where('blanch', $blanch)
        ->where('status','1')
        ->orderBy('out_id', 'desc')
        ->get();
        return view('branch.perceloutboxing.index', compact('outboxings','items'));

    }
    public function index1()
    {
        // return dd(Country::country_tarif()->toSql());
        $count = DB::table('registoutboxing')->where('status', 1)->count();
        $bra = DB::table('branches')->where('id',auth()->user()->branch)->get();
        $blanch = Auth::user()->branch;
        //model of stock_branch_balance;
        $items = stock_branch_balance::branch_balance([$blanch],"sell");
        // get outboxing     records based on blanch
        $inboxings = registoutboxing::where('blanch', $blanch)
        ->orderBy('out_id', 'desc')
        ->get();
        return view('branch.perceloutboxing.perceloutboxingtransfer', compact('inboxings','items','count','bra'));
    }
    public function view(string $id)
    {
        //
        $blanch = Auth::user()->branch;
        //model of stock_branch_balance;
        $items = stock_branch_balance::branch_balance([$blanch],"sell");
        // get outboxing records based on blanch
        $outbox = registoutboxing::where([['blanch','=', $blanch],["out_id","=",$id]] )->get()->first();
        if(!$outbox){
            return redirect()->back()->with('error', 'Outboxing Record Not Found');
        }
        // return dd($outbox);
        return view('branch.perceloutboxing.view', compact('outbox','items'));
    }
    public function history()
    {
        //
        // return dd(single_country_tarif::single_country_tarif());
        $blanch = Auth::user()->branch;
        //model of stock_branch_balance;
        $items = stock_branch_balance::branch_balance([$blanch],"sell");
        // get outboxing records based on blanch
        return view('branch.perceloutboxing.history', compact('items'));

    }
    public function report()
    {
        // $courierPays = DB::table('registoutboxing')
        // ->select(DB::raw('SUM(amount) as cash'), DB::raw('SUM(postage) as postage'), 'pdate')
        // ->where('user_id', auth()->user()->id)
        // ->groupBy('pdate')
        // ->orderBy('pdate', 'DESC')
        // ->limit(30)
        // ->get();
        $courierPays = OutboxingMail::where('user_id', auth()->user()->id)
        ->where('type','p')
        ->select(DB::raw('SUM(amount) as cash'), DB::raw('SUM(postage) as postage'), DB::raw('DATE(created_at) as pdate'))
        ->groupBy('pdate')->orderBy('pdate', 'DESC')->limit(30)->get();
        return view('branch.perceloutboxing.report', compact('courierPays'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate the request to store in outboxing based on its $fillable
        $request->validate([
            'tracking' => 'required|string',
            'snames' => 'required|string',
            'sphone' => 'required|string',
            'semail' => 'required|string',
            'snid' => 'required|string',
            'saddress' => 'required|string',
            'rcountry' => 'required|string',
            'rnames' => 'required|string',
            'rphone' => 'required|string',
            'remail' => 'required|string',
            'raddress' => 'required|string',
            'weight' => 'required|numeric',
            'unit' => 'required|string',
            'amount' => 'required|numeric',
            'tax' => 'required|numeric',
            'item_id' => 'required|integer',
            'postage' => 'required|numeric',
            'ptype' => 'required|string',
        ]);
        // Get Branch Id
        $blanch = Auth::user()->branch;
        // get user id
        $user = Auth::user()->id;
        // return dd($user);
        //store request in db by atribute separately
        $poutboxing = new registoutboxing();
        $poutboxing->user_id = $user;
        $poutboxing->blanch = $blanch;
        $poutboxing->tracking = $request->tracking;
        $poutboxing->snames = $request->snames;
        $poutboxing->sphone = $request->sphone;
        $poutboxing->semail = $request->semail;
        $poutboxing->snid = $request->snid;
        $poutboxing->saddress = $request->saddress;
        $poutboxing->c_id = $request->rcountry;
        $poutboxing->rnames = $request->rnames;
        $poutboxing->rphone = $request->rphone;
        $poutboxing->remail = $request->remail;
        $poutboxing->raddress = $request->raddress;
        $poutboxing->weight = $request->weight;
        $poutboxing->unit = $request->unit;
        $poutboxing->amount = $request->amount;
        $poutboxing->tax = $request->tax;
        $poutboxing->item_id = $request->item_id;
        $poutboxing->postage = $request->postage;
        $poutboxing->ptype = $request->ptype;
        $poutboxing->status = 1;
        // $poutboxing->reference = $request->reference;
        $poutboxing->save();
        // return with success message
        return redirect()->route('branch.perceloutboxing.index')->with('success', 'PERCEL Mail Outboxing created successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // validate the request to store in outboxing based on its $fillable
        $request->validate([
            'tracking' => 'required|string',
            'snames' => 'required|string',
            'sphone' => 'required|string',
            'semail' => 'required|string',
            'snid' => 'required|string',
            'saddress' => 'required|string',
            'rcountry' => 'required|string',
            'rnames' => 'required|string',
            'rphone' => 'required|string',
            'remail' => 'required|string',
            'raddress' => 'required|string',
            'weight' => 'required|numeric',
            'unit' => 'required|string',
            'amount' => 'required|numeric',
            'tax' => 'required|numeric',
            'item_id' => 'required|integer',
            'postage' => 'required|numeric',
            'ptype' => 'required|string',
        ]);
        // Get Branch Id
        $blanch = Auth::user()->branch;
        // get user id
        $user = Auth::user()->id;
        // return dd($user);
        //store request in db by atribute separately
        $poutboxing = registoutboxing::findorfail($id);
        $poutboxing->user_id = $user;
        if($poutboxing->blanch != $blanch){
            return redirect()->back()->with('error', 'You are not allowed to edit this record');
        }
        $poutboxing->blanch = $blanch;
        $poutboxing->tracking = $request->tracking;
        $poutboxing->snames = $request->snames;
        $poutboxing->sphone = $request->sphone;
        $poutboxing->semail = $request->semail;
        $poutboxing->snid = $request->snid;
        $poutboxing->saddress = $request->saddress;
        $poutboxing->c_id = $request->rcountry;
        $poutboxing->rnames = $request->rnames;
        $poutboxing->rphone = $request->rphone;
        $poutboxing->remail = $request->remail;
        $poutboxing->raddress = $request->raddress;
        $poutboxing->weight = $request->weight;
        $poutboxing->unit = $request->unit;
        $poutboxing->amount = $request->amount;
        $poutboxing->tax = $request->tax;
        $poutboxing->item_id = $request->item_id;
        $poutboxing->postage = $request->postage;
        $poutboxing->ptype = $request->ptype;
        $poutboxing->status = 1;
        // $poutboxing->reference = $request->reference;
        $poutboxing->save();
        // return with success message
        return redirect()->route('branch.perceloutboxing.index')->with('success', 'PERCEL Mail Outboxing updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        registoutboxing::findorfail($id)->delete();
        return redirect()->back()->with('success', 'PERCEL Mail Outboxing Record deleted successfully');
    }
    public function updatetraper(Request $request)
    {
        foreach ($request->out_id as $value) {
            registoutboxing::findorfail($value)->update([ 'status' => '2']);
        }

        return redirect()->back()->with('success', 'Thank You To Transfer and Mail Transfer Successfully');
    }
    public function invoicep($out_id)
    {
        $inboxings = registoutboxing::where('out_id',$out_id)->get();
        $pdf = Pdf::loadView('branch.perceloutboxing.perceloutinvoice', compact('inboxings','out_id'))
            ->setPaper('a5', 'portrait');
        return $pdf->stream('percelinvoice.pdf');
    }
    public function transactionper($pdate)
    {
        // $inboxings = DB::table('registoutboxing')
        // ->select('registoutboxing.*')
        // ->where('registoutboxing.pdate',$pdate)
        // ->where('registoutboxing.user_id',auth()->user()->id)
        // ->get();

        $inboxings = OutboxingMail::where('user_id', auth()->user()->id)
        ->where('type','percel')->whereDate('created_at',$pdate)->get();


        $pdf = Pdf::loadView('branch.perceloutboxing.perceltransaction', compact('pdate','inboxings'))
        ->setPaper('a4', 'portrait');
        return $pdf->stream('transactionoutboxingpercel.pdf');
    }
}
