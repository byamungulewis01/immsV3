<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Expense_types;
use Illuminate\Http\Request;

class ExpenseTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $expense_types = Expense_types::all();
        return view('admin.expense_types.index',compact('expense_types'));
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
        $expense_types = new Expense_types();
        $expense_types->et_name = $request->name;
        //save data
        $expense_types->save();
        //redirect to index
        return redirect()->route('admin.expense_types.index')->with('success','Expense Type Created Successfully');
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
        $expense_types = Expense_types::find($id);
        $expense_types->et_name = $request->editname;
        //save data
        $expense_types->save();
        //redirect to index
        return redirect()->route('admin.expense_types.index')->with('success','Expense Type Updated Successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $expense_types = Expense_types::find($id);
        $expense_types->delete();
        return redirect()->route('admin.expense_types.index')->with('success','Expense Type Deleted Successfully');

    }
}
