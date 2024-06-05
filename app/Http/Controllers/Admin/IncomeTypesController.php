<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Income_types;
use Illuminate\Http\Request;

class IncomeTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $income_types = Income_types::all();
        return view('admin.income_types.index',compact('income_types'));
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
        //validate the data only name parsed
        $request->validate([
            'name' => 'required',
        ]);
        //create new object of the model and make mapping to the data
        $income_types = new Income_types();
        $income_types->et_name = $request->name;
        //save data
        $income_types->save();
        //redirect to index
        return redirect()->route('admin.income_types.index')->with('success','Income Type Created Successfully');
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
        //validate name only
        $request->validate([
            'editname' => 'required',
        ]);
        //find the object and update its data
        $income_types = Income_types::find($id);
        $income_types->et_name = $request->editname;
        //save data
        $income_types->save();
        //redirect to index
        return redirect()->route('admin.income_types.index')->with('success','Income Type Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $income_types = Income_types::find($id);
        $income_types->delete();
        return redirect()->route('admin.income_types.index')->with('success','Income Type Deleted Successfully');

    }
}
