<?php

namespace App\Http\Controllers\Branch;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\BranchOrder;
use App\Models\BranchStock;
use App\Models\Item;
use Illuminate\Http\Request;

class BranchOrderController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //get branch id from cuurent user
        $blanch = auth()->user()->branch;
        $items = Item::where('inStore', '>', 0)->get();

        $orders = BranchOrder::selectRaw("
                regnumber,
                MAX(`order_id`) AS order_id,
                MAX(`item_id`) AS item_id,
                MAX(`bid`) AS bid,
                MAX(`quantity`) AS quantity,
                MAX(`status`) AS status,
                MAX(`created_at`) AS created_at
            ")->where('bid', $blanch)->groupBy('regnumber', 'bid')
            ->orderBy('order_id', 'desc')
            ->get();


        return view('branch.order.index', compact('orders', 'items'));
    }
    public function status()
    {
        //get branch id from cuurent user
        // $blanch = auth()->user()->branch;
        // $items = stock_branch_balance::branch_balance([$blanch]);
        $items = BranchStock::where('branch_id', auth()->user()->branch)->get();

        return view('branch.order.status', compact('items'));
    }
    public function history()
    {
        //get branch id from cuurent user
        $blanch = auth()->user()->branch;
        if (auth()->user()->level == "branchManager") {

            $orders = BranchOrder::selectRaw("
            regnumber,
            MAX(`order_id`) AS order_id,
            MAX(`item_id`) AS item_id,
            MAX(`bid`) AS bid,
            MAX(`quantity`) AS quantity,
            MAX(`status`) AS status,
            MAX(`created_at`) AS created_at
        ")
                ->where('bid', $blanch)
                ->groupBy('regnumber', 'bid')
                ->get();
        } else {

            $orders = BranchOrder::selectRaw("
            regnumber,
            MAX(`order_id`) AS order_id,
            MAX(`item_id`) AS item_id,
            MAX(`bid`) AS bid,
            MAX(`quantity`) AS quantity,
            MAX(`status`) AS status,
            MAX(`created_at`) AS created_at
        ")
                ->groupBy('regnumber', 'bid')
                ->orderBy('order_id', 'desc')
                ->where('status', 0)
                ->get();
        }
        return view('branch.order.history', compact('orders'));
    }
    public function approved()
    {
        //get branch id from cuurent user
        $orders = BranchOrder::selectRaw("
            regnumber,
            MAX(`order_id`) AS order_id,
            MAX(`item_id`) AS item_id,
            MAX(`bid`) AS bid,
            MAX(`quantity`) AS quantity,
            MAX(`status`) AS status,
            MAX(`created_at`) AS created_at
        ")
            ->groupBy('regnumber', 'bid')
            ->where('status', 1)
            ->orderBy('order_id', 'desc')
            ->get();

        return view('branch.order.approved', compact('orders'));
    }
    public function rejected()
    {
        //get branch id from cuurent user
        $orders = BranchOrder::selectRaw("
            regnumber,
            MAX(`order_id`) AS order_id,
            MAX(`item_id`) AS item_id,
            MAX(`bid`) AS bid,
            MAX(`quantity`) AS quantity,
            MAX(`status`) AS status,
            MAX(`created_at`) AS created_at
        ")
            ->groupBy('regnumber', 'bid')
            ->where('status', 2)
            ->orderBy('order_id', 'desc')
            ->get();

        return view('branch.order.rejected', compact('orders'));
    }
    public function view(string $id)
    {
        $orders = BranchOrder::where('regnumber', $id)->get()->toArray();
        $order_1 = BranchOrder::where('regnumber', $id)->get()->first();
        //if no order found redirect to index page
        if (!$orders || !$order_1) {
            return redirect()->back()->with('error', 'Order Not Found');
        }
        $branch = Branch::find($order_1->bid);
        // $branch = Branch::find(1);
        return view('branch.order.view', compact('orders', 'order_1', 'branch'));
    }
    public function update(Request $request, string $id)
    {
        //
        $request->validate([
            'order_id' => 'required|array',
            'order_id.*' => 'required|integer',
            'qty' => 'required|array',
            'qty.*' => 'required|integer',
        ]);
        $req = $request->all();
        // return dd($req);
        for ($i = 0; $i < count($req['order_id']); $i++) {
            $order = BranchOrder::find($req['order_id'][$i]);
            $order->quantity = $req['qty'][$req['order_id'][$i]];
            $order->save();
        }
        return redirect()->route('branch.order.history')->with('success', 'Order Updated Successfully');

    }
    public function approve(Request $request, string $id)
    {
        //
        $request->validate([
            'order_id' => 'required|array',
            'order_id.*' => 'required|integer',
            'qty' => 'required|array',
            'qty.*' => 'required|integer',
        ]);
        $req = $request->all();
        for ($i = 0; $i < count($req['item_id']); $i++) {
            $item = Item::findOrFail($req['item_id'][$i]);
            if ($req['qty'][$req['order_id'][$i]] > $item->inStore) {
                return back()->with('warning1', $item->name .' remains ' .$item->inStore . ' in store');
            }
        }

        for ($i = 0; $i < count($req['order_id']); $i++) {

            $order = BranchOrder::find($req['order_id'][$i]);
            $order->quantity = $req['qty'][$req['order_id'][$i]];
            $order->status = '1';
            $order->save();

            $stock = BranchStock::where('branch_id', $request->bid)->where('item_id', $req['item_id'][$i])->first();
            if ($stock) {
                $stock->increment('qty', $req['qty'][$req['order_id'][$i]]);
            } else {
                BranchStock::create([
                    'qty' => $req['qty'][$req['order_id'][$i]],
                    'branch_id' => $request->bid,
                    'item_id' => $req['item_id'][$i],
                ]);
            }
            Item::findOrFail($req['item_id'][$i])->decrement('inStore', $req['qty'][$req['order_id'][$i]]);
        }
        return redirect()->route('branch.order.history')->with('success', 'Order Approved Successfully');

    }
    // public function approve(Request $request, string $id)
    // {
    //     //
    //     $request->validate([
    //         'order_id' => 'required|array',
    //         'order_id.*' => 'required|integer',
    //         'qty' => 'required|array',
    //         'qty.*' => 'required|integer',
    //     ]);
    //     $req = $request->all();

    //     for ($i = 0; $i < count($req['order_id']); $i++) {
    //         $order = BranchOrder::find($req['order_id'][$i]);
    //         // verify out of stock
    //         $qty = $req['qty'][$req['order_id'][$i]];
    //         $ck1 = main_stock_balance::main_stock_balance([$order->item_id],"data");
    //         if (isset($ck1['qty'])) {
    //             $ck2 = $ck1['qty'] - $qty;
    //             if ($ck2 >= 0) {

    //             }else{
    //                 return redirect()->route('branch.order.history')->with('error', 'Order Not Approved Please check Stock');
    //                 continue;
    //             }
    //         }
    //         if ($order->status > 0) {

    //             continue;

    //         }

    //         $order->quantity = $req['qty'][$req['order_id'][$i]];
    //         $order->status = '1';
    //         $order->save();
    //     }
    //     return redirect()->route('branch.order.history')->with('success', 'Order Approved Successfully');

    // }
    public function reject(Request $request, string $id)
    {
        //
        $request->validate([
            'order_id' => 'required|array',
            'order_id.*' => 'required|integer',
            'qty' => 'required|array',
            'qty.*' => 'required|integer',
        ]);
        $req = $request->all();
        for ($i = 0; $i < count($req['order_id']); $i++) {
            $order = BranchOrder::find($req['order_id'][$i]);

            if ($order->status > 0) {
                continue;
            }

            $order->quantity = $req['qty'][$req['order_id'][$i]];
            $order->status = '2';
            $order->save();
        }
        return redirect()->route('branch.order.history')->with('success', 'Order Rejected Successfully');

    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // validate all requested fields array for value and qty
        $request->validate([
            'item_id' => 'required|array',
            'item_id.*' => 'required|integer',
            'quantity' => 'required|array',
            'quantity.*' => 'required|integer',
        ]);

        $blanch = auth()->user()->branch;
        $regnumber = 'ORD' . date('ymdhis') . rand(100, 999);
        for ($i = 0; $i < count($request['item_id']); $i++) {
            # code...
            $order = new BranchOrder();
            // create random regnumber based on current time with ORD prefix
            $order->regnumber = $regnumber;
            $order->bid = $blanch;
            $order->user_id = auth()->id();
            $order->item_id = $request['item_id'][$i];
            $order->quantity = $request['quantity'][$i];
            $order->save();
        }
        return redirect()->route('branch.order.index')->with('success', 'Order Created Successfully');
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
