<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Item;
use Illuminate\Http\Request;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $items = Item::with('category_info')->orderByDesc('item_id')->get();
        return view('admin.item.index', compact('items'));
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
        //
        // validate the item data and store them
        $request->validate([
            'name' => 'required',
            'category' => 'required',
            'purchasingprice' => 'nullable',
            'sellingprice' => 'nullable',
            'description' => 'required',
        ]);
        Item::create([
            'name' => $request->name,
            'category' => $request->category,
            'purchasingprice' => $request->purchasingprice,
            'sellingprice' => $request->sellingprice,
            'description' => $request->description,
        ]);
        return redirect()->back()->with('success', 'Item created successfully');
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
        //
        // validate and save data using edit prefix
        $request->validate([
            'editname' => 'required',
            'editcategory' => 'required',
            'editpurchasingprice' => 'nullable',
            'editsellingprice' => 'nullable',
            'editdescription' => 'required',
        ]);

        Item::where('item_id', $id)->update([
            'name' => $request->editname,
            'category' => $request->editcategory,
            'purchasingprice' => $request->editpurchasingprice,
            'sellingprice' => $request->editsellingprice,
            'description' => $request->editdescription,
        ]);
        return redirect()->back()->with('success', 'Item updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //delete data
        try {
            //code...
            Item::where('item_id', $id)->delete();
            return redirect()->back()->with('success', 'Item deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
        return back()->with('warning', 'Item not deleted ask administrator for support');

        }
    }
}
