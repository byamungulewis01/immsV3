<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $suppliers = supplier::orderByDesc('id')->get();
        return view('admin.supplier.index', compact('suppliers'));
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

        $request->validate([
            'suppliername' => 'required',
            'tinnumber' => 'required|numeric',
            'phone' => 'required|numeric',
        ]);
        $supp = new supplier();
        $supp->suppliername = $request->suppliername;
        $supp->tinnumber = $request->tinnumber;
        $supp->phone = $request->phone;
        $supp->save();
        return to_route('admin.supplier.index')->with('success', 'Supplier Added Successfully');

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
        $request->validate([
            'editsuppliername' => 'required',
            'edittinnumber' => 'required|numeric',
            'editphone' => 'required|numeric',
        ]);
        $supp = Supplier::findorfail($id);
        $supp->suppliername = $request->editsuppliername;
        $supp->tinnumber = $request->edittinnumber;
        $supp->phone = $request->editphone;
        $supp->save();
        return to_route('admin.supplier.index')->with('success', 'Supplier Updated Successfully');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Supplier::findorfail($id)->delete();
        return to_route('admin.supplier.index')->with('success', 'Supplier Deleted Successfully');
    }
}
