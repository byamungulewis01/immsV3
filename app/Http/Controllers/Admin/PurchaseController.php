<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Item;
use App\Models\main_stock_balance;
use App\Models\Purchase;
use App\Models\supplier;
use DB;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = supplier::orderBy('suppliername', 'asc')->get();
        $items = Item::whereNot('category','service')->orderBy('item_id', 'desc')->get();

        return view('admin.purchase.index', compact('suppliers','items'));
    }
    public  function list()
    {
        $purchases = Purchase::groupBy('code')->orderByDesc('created_at')->get();
        return view('admin.purchase.list', compact('purchases'));
    }
    public  function stock()
    {
        $items = Item::where('inStore','>',0)->get();
        return view('admin.purchase.stock', compact('items'));
    }
    public  function report()
    {
        $purch = new Purchase();
        $purchases = $purch->getPurchaseTotalsByCode();
        // dd($purchases);
        return view('admin.purchase.report', compact('purchases'));
    }
    public function view(string $id)
    {
        $purchase = Purchase::where('code', $id)->get();
        $suppliers = supplier::orderBy('suppliername', 'asc')->get();

        return view('admin.purchase.view', compact('suppliers','purchase'));
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

        $purchase_code = 'PU' . date('y') . rand(10, 99);

        for ($i = 0; $i < count($request['item_id']); $i++) {
            Item::where('item_id',$request['item_id'][$i])->first()->increment('inStore',$request['qty'][$i]);
            $purchase = new Purchase();
            $purchase->code = $purchase_code;
            $purchase->item_id = $request['item_id'][$i];
            $purchase->supplier_id = $request['supplier_id'];
            $purchase->quantity = $request['qty'][$i];
            $purchase->price = $request['price'][$i];
            $purchase->total = $request['total'][$i];
            $purchase->save();
        }
        return redirect()->route('admin.purchase.list')->with('success', 'Purchase Order Created Successfully');
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
    public function update(Request $request)
    {
        //validate request and sub array
        $request->validate([
            'purcha_id' => 'required|array',
            'purcha_id.*' => 'required|integer',
            'qty' => 'required|array',
            'qty.*' => 'required',
            'total' => 'required|array',
            'total.*' => 'required',
        ]);

        $req = $request->all();
        for ($i = 0; $i < count($req['purcha_id']); $i++) {
            Item::findOrFail($req['item_id'][$i])->update(['inStore' => $req['qty'][$i]]);

            $order = Purchase::find($req['purcha_id'][$i]);
            $order->total = $req['total'][$i];
            $order->supplier_id = $req['supplier_id'];
            $order->total = $req['price'][$i];
            $order->quantity = $req['qty'][$i];
            $order->save();
        }
        return redirect()->route('admin.purchase.list')->with('success', 'Purchase Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $orders = Purchase::where('code', $id)->get();

        foreach ($orders as $value) {
            Item::findOrFail($value->item_id)->decrement('inStore', $value->quantity);
            $value->delete();
        }
        return redirect()->route('admin.purchase.list')->with('success', 'Purchase Deleted Successfully');
    }
}
