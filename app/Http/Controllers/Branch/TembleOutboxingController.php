<?php

namespace App\Http\Controllers\Branch;

use App\Models\Country;
use App\Models\temble_items;
use Illuminate\Http\Request;
use App\Models\OutboxingMail;
use App\Models\tembleoutboxing;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\stock_branch_balance;
use Illuminate\Support\Facades\Auth;

class TembleOutboxingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $blanch = Auth::user()->branch;
        //model of stock_branch_balance;
        $items = stock_branch_balance::branch_balance([$blanch],"sell");
        // dd($items);
        // return dd($items);
        // get outboxing records based on blanch
        $outboxings = tembleoutboxing::where('blanch', $blanch)
        ->where('status','1')
        ->orderBy('out_id', 'desc')
        ->get();

        return view('branch.tembleoutboxing.index', compact('outboxings','items'));

    }
    public function index1()
    {
        // return dd(Country::country_tarif()->toSql());
        $count = DB::table('tembleoutboxing')->where('status', 1)->count();
        $bra = DB::table('branches')->where('id',auth()->user()->branch)->get();
        $blanch = Auth::user()->branch;
        //model of stock_branch_balance;
        $items = stock_branch_balance::branch_balance([$blanch],"sell");
        // get outboxing     records based on blanch
        $inboxings = tembleoutboxing::where('blanch', $blanch)
        ->orderBy('out_id', 'desc')
        ->get();
        return view('branch.tembleoutboxing.tembleoutboxingtransfer', compact('inboxings','items','count','bra'));
    }
    public function view(string $id)
    {
        //
        $blanch = Auth::user()->branch;
        //model of stock_branch_balance;
        $items = stock_branch_balance::branch_balance([$blanch],"sell");
        // get outboxing records based on blanch
        $outbox = tembleoutboxing::where([['blanch','=', $blanch],["out_id","=",$id]] )->get()->first();
        if(!$outbox){
            return redirect()->back()->with('error', 'Outboxing Record Not Found');
        }
        // return dd($outbox);
        return view('branch.tembleoutboxing.view', compact('outbox','items'));
    }
    public function history()
    {
        //
        $blanch = Auth::user()->branch;
        //model of stock_branch_balance;
        $items = stock_branch_balance::branch_balance([$blanch],"sell");
        return view('branch.tembleoutboxing.history', compact('items'));

    }
    public function report()
    {
        // $courierPays = DB::table('tembleoutboxing')
        // ->select(DB::raw('SUM(temb_amount) as cash'), 'pdate')
        // ->where('user_id', auth()->user()->id)
        // ->groupBy('pdate')
        // ->orderBy('pdate', 'DESC')
        // ->limit(30)
        // ->get();
        $courierPays = OutboxingMail::where('user_id', auth()->user()->id)
        ->where('type','stamps')
        ->select(DB::raw('SUM(amount) as cash'), DB::raw('SUM(postage) as postage'), DB::raw('DATE(created_at) as pdate'))
        ->groupBy('pdate')->orderBy('pdate', 'DESC')->limit(30)->get();

        return view('branch.tembleoutboxing.report', compact('courierPays'));
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
            // 'item_id' => 'required|integer',
            // 'postage' => 'required|numeric',
            'ptype' => 'required|string',
            // 'item_id_2' => 'required|integer',
            'postage_2' => 'required|numeric',
            'temb_qty' => 'required|string',
        ]);
        // return dd($request);
        // Get Branch Id
        $blanch = Auth::user()->branch;
        // get user id
        $user = Auth::user()->id;
        // return dd($user);
        //store request in db by atribute separately
        $poutboxing = new tembleoutboxing();
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
        $poutboxing->amount = 0;
        // $poutboxing->amount = $request->amount;
        $poutboxing->tax = $request->tax;
        // $poutboxing->item_id = $request->item_id;
        $poutboxing->item_id = null;
        $poutboxing->postage = $request->postage;
        $poutboxing->postage = 0;
        $poutboxing->ptype = $request->ptype;
        $poutboxing->item_id_2 = null;
        // $poutboxing->item_id_2 = $request->item_id_2;
        $poutboxing->temb_amount = $request->postage_2;
        // $itm = stock_branch_balance::branch_balance([$blanch,$request->item_id_2],"data");
        // // if ($request->temb_qty > ($itm->qty)) {
        // //     return redirect()->route('branch.tembleoutboxing.index')->with('error', 'Quantity entered for temble is more than available stock');
        // // }
        $poutboxing->temb_qty = $request->temb_qty;
        $poutboxing->status = 1;
        // $poutboxing->reference = $request->reference;
        $poutboxing->save();
        $req = $request->all();
        for ($i = 0; $i < count($req['item_id']); $i++) {
            $order = new temble_items();
            $order->out_id = $poutboxing->out_id;
            $order->item_id = $req['item_id'][$i];
            $order->quantity = $req['quantity'][$i];
            $order->save();
        }
        // return with success message
        return redirect()->route('branch.tembleoutboxing.index')->with('success', 'POSTING WITH TEMBLE Outboxing created successfully.');

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
            'item_id_2' => 'required|integer',
            'postage_2' => 'required|numeric',
            'temb_qty' => 'required|string',
        ]);
        // Get Branch Id
        $blanch = Auth::user()->branch;
        // get user id
        $user = Auth::user()->id;
        // return dd($user);
        //store request in db by atribute separately
        $poutboxing = tembleoutboxing::findorfail($id);
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
        $poutboxing->amount = 0;
        // $poutboxing->amount = $request->amount;
        $poutboxing->tax = $request->tax;
        $poutboxing->item_id = $request->item_id;
        $poutboxing->postage = 0;
        $poutboxing->ptype = $request->ptype;
        $poutboxing->item_id_2 = $request->item_id_2;
        $poutboxing->temb_amount = $request->postage_2;
        $itm = stock_branch_balance::branch_balance([$blanch,$request->item_id_2],"data");
        if ($request->temb_qty > ($itm->qty+ $poutboxing->temb_qty)) {
            return redirect()->route('branch.tembleoutboxing.index')->with('error', 'Quantity entered for temble is more than available stock');
        }
        $poutboxing->temb_qty = $request->temb_qty;
        $poutboxing->status = 1;
        // $poutboxing->reference = $request->reference;
        $poutboxing->save();
        // return with success message
        return redirect()->route('branch.tembleoutboxing.index')->with('success', 'POSTING WITH TEMBLE Outboxing updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        tembleoutboxing::findorfail($id)->delete();
        return redirect()->back()->with('success', 'POSTING WITH TEMBLE Outboxing Record deleted successfully');
    }
    public function updatetratemble(Request $request)
    {
        foreach ($request->out_id as $value) {
            tembleoutboxing::findorfail($value)->update([ 'status' => '2']);
        }

        return redirect()->back()->with('success', 'Thank You To Transfer and Mail Transfer Successfully');
    }
    public function invoiceemst($out_id)
    {
        $pay = tembleoutboxing::where('out_id',$out_id)->get()->first();
        $pdf = Pdf::loadView('branch.tembleoutboxing.emstembleinvoice', compact('pay','out_id'))
            ->setPaper('a5', 'portrait');
        return $pdf->stream('emstembleinvoice.pdf');
    }
    public function transactiontemb($pdate)
    {
        // $inboxings = DB::table('tembleoutboxing')
        // ->select('tembleoutboxing.*')
        // ->where('tembleoutboxing.pdate',$pdate)
        // ->where('tembleoutboxing.user_id',auth()->user()->id)
        // ->get();

        $inboxings = OutboxingMail::where('user_id', auth()->user()->id)
        ->where('type','temble')->whereDate('created_at',$pdate)->get();

        $pdf = Pdf::loadView('branch.tembleoutboxing.tembletransaction', compact('pdate','inboxings'))
        ->setPaper('a4', 'portrait');
        return $pdf->stream('transactionoutboxingtemble.pdf');
    }
}
