<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\BranchStock;
use App\Models\Item;
use App\Models\Outboxing;
use App\Models\OutboxingMail;
use App\Models\OutboxingMailProduct;
use App\Models\stock_branch_balance;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OutboxingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        // return dd(Country::country_tarif()->toSql());
        //
        $blanch = Auth::user()->branch;

        //model of stock_branch_balance;
        $items = stock_branch_balance::branch_balance([$blanch], "sell");

        // get outboxing records based on blanch
        $outboxings = Outboxing::where('blanch', $blanch)
            ->where('status', '1')
            ->orderBy('out_id', 'desc')
            ->get();
        return view('branch.outboxing.index', compact('outboxings', 'items'));
    }
    public function index1()
    {
        // return dd(Country::country_tarif()->toSql());
        $count = DB::table('outboxing')->where('status', 1)->count();
        $bra = DB::table('branches')->where('id', auth()->user()->branch)->get();
        $blanch = Auth::user()->branch;
        //model of stock_branch_balance;
        $items = stock_branch_balance::branch_balance([$blanch], "sell");
        // get outboxing records based on blanch
        $inboxings = Outboxing::where('blanch', $blanch)
            ->orderBy('out_id', 'desc')
            ->get();
        return view('branch.outboxing.emsmailouttransfer', compact('inboxings', 'items', 'count', 'bra'));
    }
    public function view(string $id)
    {
        //
        $blanch = Auth::user()->branch;
        //model of stock_branch_balance;
        $items = stock_branch_balance::branch_balance([$blanch], "sell");
        // get outboxing records based on blanch
        $outbox = Outboxing::where([['blanch', '=', $blanch], ["out_id", "=", $id]])->get()->first();
        if (!$outbox) {
            return redirect()->back()->with('error', 'Outboxing Record Not Found');
        }
        // return dd($outbox);
        return view('branch.outboxing.view', compact('outbox', 'items'));
    }
    public function history()
    {
        //
        $blanch = Auth::user()->branch;
        //model of stock_branch_balance;
        $items = stock_branch_balance::branch_balance([$blanch], "sell");
        // get outboxing records based on blanch
        return view('branch.outboxing.history', compact('items'));
    }
    public function report()
    {

        // $courierPays = DB::table('outboxing')
        //     ->select(DB::raw('SUM(amount) as cash'), DB::raw('SUM(postage) as postage'), 'pdate')
        //     ->where('user_id', auth()->user()->id)
        //     ->groupBy('pdate')
        //     ->orderBy('pdate', 'DESC')
        //     ->limit(30)
        //     ->get();
        $courierPays = OutboxingMail::where('user_id', auth()->user()->id)
            ->where('type', 'ems')
            ->select(DB::raw('SUM(amount) as cash'), DB::raw('SUM(postage) as postage'), DB::raw('DATE(created_at) as pdate'))
            ->groupBy('pdate')->orderBy('pdate', 'DESC')->limit(30)->get();

        return view('branch.outboxing.report', compact('courierPays'));

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('branch.outboxing.create');
    }
    public function items()
    {
        $items = BranchStock::where('branch_id', auth()->user()->branch)->where('qty', '>', 0)
            ->select('item_id', 'qty', DB::raw('(SELECT purchasingprice FROM items WHERE item_id = branch_stocks.item_id LIMIT 1) as purchasingprice'),
                DB::raw('(SELECT name FROM items WHERE item_id = branch_stocks.item_id LIMIT 1) as name')
                , DB::raw('(SELECT sellingprice FROM items WHERE item_id = branch_stocks.item_id LIMIT 1) as sellingprice')
                , DB::raw('(SELECT category FROM items WHERE item_id = branch_stocks.item_id LIMIT 1) as category')
            )->get();

        $serviceItem = Item::where('category', 'service')
            ->select('item_id',
                DB::raw('NULL as qty'), // Assuming qty for service item is 0
                'purchasingprice',
                'name',
                'sellingprice',
                'category'
            )->first();
        if ($serviceItem) {
            // Add service item to the collection
            $items->push($serviceItem);
        }
        return $items;
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
        $outboxing = new Outboxing();
        $outboxing->user_id = $user;
        $outboxing->blanch = $blanch;
        $outboxing->tracking = $request->tracking;
        $outboxing->snames = $request->snames;
        $outboxing->sphone = $request->sphone;
        $outboxing->semail = $request->semail;
        $outboxing->snid = $request->snid;
        $outboxing->saddress = $request->saddress;
        $outboxing->c_id = $request->rcountry;
        $outboxing->rnames = $request->rnames;
        $outboxing->rphone = $request->rphone;
        $outboxing->remail = $request->remail;
        $outboxing->raddress = $request->raddress;
        $outboxing->weight = $request->weight;
        $outboxing->unit = $request->unit;
        $outboxing->amount = $request->amount;
        $outboxing->tax = $request->tax;
        $outboxing->item_id = $request->item_id;
        $outboxing->postage = $request->postage;
        $outboxing->ptype = $request->ptype;
        $outboxing->status = 1;
        // $outboxing->reference = $request->reference;
        $outboxing->save();
        // return with success message
        return redirect()->route('branch.outboxing.index')->with('success', 'EMS Mail Outboxing created successfully.');

    }
    public function store2(Request $request)
    {

        $request->validate([
            'tracking' => 'required|string',
            'snames' => 'required|string',
            'sphone' => 'required|string',
            'semail' => 'sometimes|string',
            'snid' => 'sometimes|string',
            'district' => 'required|string',
            'rnames' => 'required|string',
            'rphone' => 'required|string',
            'remail' => 'required|string',
            'raddress' => 'required|string',
            'type' => 'required',
            'note' => 'sometimes',
            'country' => 'required',
            'weight' => 'nullable',
            'unit' => 'nullable',
            'amount' => 'nullable',
        ]);
        $request->merge([
            'user_id' => auth()->user()->id,
            'branch_id' => auth()->user()->branch,
            'postage' => $request->postage,
            'tax' => ($request->amount + $request->postage) * 0.18,
        ]);
        // dd($request->all());
        try {
            $outbox = OutboxingMail::create($request->all());
            if ($outbox) {
                for ($i = 0; $i < count($request->items); $i++) {
                    OutboxingMailProduct::create([
                        'branch_id' => $outbox->branch_id,
                        'outboxing_id' => $outbox->id,
                        'item_id' => $request->items[$i],
                        'quantity' => $request->quantity[$i],
                        'price' => $request->unitprice[$i],
                        'amount' => $request->amount_array[$i],
                    ]);
                    if ($request->category[$i] != 'service') {
                        BranchStock::where('branch_id', auth()->user()->branch)->where('item_id', $request->items[$i])->first()->decrement('qty', $request->quantity[$i]);
                    }
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th->getMessage());
            return back()->with('warning', 'not created try again');

        }

        return to_route('branch.outboxing.list')->with('success', 'Mail Outboxing created successfully.');

    }
    public function update2(Request $request, $id)
    {
        $request->validate([
            'tracking' => 'required|string',
            'snames' => 'required|string',
            'sphone' => 'required|string',
            'semail' => 'sometimes|string',
            'snid' => 'sometimes|string',
            'district' => 'sometimes|string',
            'rnames' => 'required|string',
            'rphone' => 'required|string',
            'remail' => 'required|string',
            'raddress' => 'required|string',
            'type' => 'required',
            'note' => 'sometimes',
            'country' => 'required',
            'weight' => 'required',
            'unit' => 'required',
            'amount' => 'required',
        ]);
        $request->merge([
            'postage' => $request->postage,
            'tax' => ($request->amount + $request->postage) * 0.18,
        ]);

        try {
            $outbox = OutboxingMail::findOrFail($id);
            $outbox->update($request->all());
            $products = OutboxingMailProduct::where('outboxing_id', $outbox->id)->get();
            foreach ($products as $product) {
                if ($product->item->category != 'service') {
                    BranchStock::where('branch_id', auth()->user()->branch)->where('item_id', $product->item_id)->first()->increment('qty', $product->quantity);
                }
                $product->delete();
            }
            for ($i = 0; $i < count($request->items); $i++) {
                OutboxingMailProduct::create([
                    'branch_id' => $outbox->branch_id,
                    'outboxing_id' => $outbox->id,
                    'item_id' => $request->items[$i],
                    'quantity' => $request->quantity[$i],
                    'price' => $request->unitprice[$i],
                    'amount' => $request->amount_array[$i]]);
                if ($request->category[$i] != 'service') {
                    BranchStock::where('branch_id', auth()->user()->branch)->where('item_id', $request->items[$i])->first()->decrement('qty', $request->quantity[$i]);
                }
            }
        } catch (\Throwable $th) {
            //throw $th;
            // dd($th->getMessage());

            return to_route('branch.outboxing.list')->with('warning', 'not updated try again');

        }

        // OutboxingMail::find($id)->update($request->all());

        // for ($i = 0; $i < count($request->items); $i++) {
        //     BranchStock::where('branch_id', auth()->user()->branch)->where('item_id', $request->items[$i])->first()->decrement('qty', $request->quantity[$i]);
        // }

        return to_route('branch.outboxing.list')->with('success', 'Mail Outboxing updated successfully.');

    }

    /**
     * Display the specified resource.
     */
    public function list()
    {
        $outboxings = OutboxingMail::where('user_id', auth()->user()->id)
            ->where('status', 1)->orderByDesc('id')->get();
        return view('branch.outboxing.list', compact('outboxings'));
    }
    public function tranfered()
    {
        $outboxings = OutboxingMail::where('user_id', auth()->user()->id)->whereNot('status', 1)->orderByDesc('id')->get();
        return view('branch.outboxing.tranfered', compact('outboxings'));
    }
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $outboxing = OutboxingMail::findOrFail($id);
        // dd($outboxing);
        return view('branch.outboxing.edit', compact('outboxing'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
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
        $outboxing = Outboxing::findorfail($id);
        $outboxing->user_id = $user;
        if ($outboxing->blanch != $blanch) {
            return redirect()->back()->with('error', 'You are not allowed to edit this record');
        }
        $outboxing->blanch = $blanch;
        $outboxing->tracking = $request->tracking;
        $outboxing->snames = $request->snames;
        $outboxing->sphone = $request->sphone;
        $outboxing->semail = $request->semail;
        $outboxing->snid = $request->snid;
        $outboxing->saddress = $request->saddress;
        $outboxing->c_id = $request->rcountry;
        $outboxing->rnames = $request->rnames;
        $outboxing->rphone = $request->rphone;
        $outboxing->remail = $request->remail;
        $outboxing->raddress = $request->raddress;
        $outboxing->weight = $request->weight;
        $outboxing->unit = $request->unit;
        $outboxing->amount = $request->amount;
        $outboxing->tax = $request->tax;
        $outboxing->item_id = $request->item_id;
        $outboxing->postage = $request->postage;
        $outboxing->ptype = $request->ptype;
        $outboxing->status = 1;
        // $outboxing->reference = $request->reference;
        $outboxing->save();
        // return with success message
        return redirect()->route('branch.outboxing.index')->with('success', 'EMS Mail Outboxing Updated successfully.');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        Outboxing::findorfail($id)->delete();
        return redirect()->back()->with('success', 'EMS Mail Outboxing Record deleted successfully');
    }
    public function destroy2(string $id)
    {
        $products = OutboxingMailProduct::where('outboxing_id', $id)->get();
        foreach ($products as $product) {
            if ($product->item->category != 'service') {
                BranchStock::where('branch_id', auth()->user()->branch)->where('item_id', $product->item_id)->first()->increment('qty', $product->quantity);
            }
            $product->delete();
        }
        OutboxingMail::findorfail($id)->delete();
        return redirect()->back()->with('success', 'Mail Record deleted successfully');
    }
    public function invoiceems($out_id)
    {
        $outbox = Outboxing::where('out_id', $out_id)->get()->first();
        // dd($outbox);

        $pdf = Pdf::loadView('branch.outboxing.emsinvoice', compact('outbox', 'out_id'))
            ->setPaper('a5', 'portrait');
        // Set the font size to 10px
        $font = [
            'size' => 1,
        ];

        $pdf->getDomPDF()->getOptions()->set('font-size', $font);
        return $pdf->stream('emsinvoice.pdf');

        // return view('branch.outboxing.emsinvoice', compact('outbox', 'out_id'));
    }
    public function print_out($out_id)
    {
        $outbox = OutboxingMail::findOrFail($out_id);
        if ($outbox->type == 'ems') {
            $path = 'branch.outboxing.print_ems';
            $name = 'ems';
        } elseif ($outbox->type == 'p') {
            $path = 'branch.perceloutboxing.perceloutinvoice';
            $name = 'percel';

        } elseif ($outbox->type == 'r') {
            $path = 'branch.registeredoutboxing.registeredoutinvoice';
            $name = 'registered';
        } else {
            $path = 'branch.tembleoutboxing.emstembleinvoice';
            $name = 'stamps';
        }

        $pdf = Pdf::loadView($path, compact('outbox', 'out_id'))
            ->setPaper('a5', 'portrait');
        // Set the font size to 10px
        $font = [
            'size' => 1,
        ];

        $pdf->getDomPDF()->getOptions()->set('font-size', $font);
        return $pdf->stream($name.'.pdf');

        // return view('branch.registeredoutboxing.registeredoutinvoice', compact('outbox', 'out_id'));
    }

    public function transactionouems($pdate)
    {
        // $inboxings = DB::table('outboxing')
        //     ->select('outboxing.*')
        //     ->where('outboxing.pdate', $pdate)
        //     ->where('outboxing.user_id', auth()->user()->id)
        //     ->get();
        $inboxings = OutboxingMail::where('user_id', auth()->user()->id)
            ->where('type', 'ems')->whereDate('created_at', $pdate)->get();

        $pdf = Pdf::loadView('branch.outboxing.emstransaction', compact('pdate', 'inboxings'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('transactionoutboxingems.pdf');
    }
}
