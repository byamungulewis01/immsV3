<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BranchController extends Controller
{
    //
    public function index()
    {
        $branches = Branch::orderBy('name')->get();
        $users = User::orderBy('name')->get();
        return view('admin.branch', compact('branches', 'users'));
    }
    # API
    public function api()
    {
        $branches = Branch::orderBy('name')->get();
        return response()->json([
            'success' => true,
            'data' => $branches,
        ]);
    }
    # Store
    public function store(Request $request)
    {
        $formField = $request->validate([
            'name' => 'required|unique:branches,name',
            'status' => 'required',
        ]);
        Branch::create($formField);
        return redirect()->back()->with('success', 'Branch Added Successfully');
    }
    # Edit
    public function update(Request $request, $id)
    {
        $formField = $request->validate([
            'name' => 'required|unique:branches,name,' . $id,
            'status' => 'required',
        ]);
        Branch::findorfail($id)->update($formField);
        return to_route('admin.branch.index')->with('success', 'Branch Updated Successfully');
    }
    # Delete
    public function destroy($id)
    {
        Branch::findorfail($id)->delete();
        return to_route('admin.branch.index')->with('success', 'Branch Deleted Successfully');
    }
}
