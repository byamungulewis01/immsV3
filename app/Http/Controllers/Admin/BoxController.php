<?php

namespace App\Http\Controllers\Admin;

use App\Models\Box;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class BoxController extends Controller
{
    //
    public function index()
    {
        $boxes = Box::all();
        $branches = Branch::orderBy('name', 'asc')->get();
        return view('admin.box', compact('boxes', 'branches'));
    }
    // function to store the box
    public function store(Request $request)
    {
        $request->validate([
            'branch' => 'required',
            'size' => 'required',
        ]);
        # count the number of boxes with the same branch
        $count = Box::where('branch_id', $request->branch)->count();
        # add 1 to the count and insert the new box
        $box = new Box();
        $box->pob = $count + 1;
        $box->branch_id = $request->branch;
        $box->size = $request->size;
        $box->status = 1;
        $box->save();
        # redirect to the box page
        return to_route('admin.box.index')->with('success', 'Box added successfully');
    }
    // function to update the box
    public function update(Request $request, $id)
    {
        $request->validate([
            'size' => 'required',
        ]);
        # update the box
        $box = Box::find($id);
        $box->size = $request->size;
        $box->save();
        # redirect to the box page
        return to_route('admin.box.index')->with('success', 'Box updated successfully');
    }
    // function to delete the box
    public function destroy($id)
    {
        # delete the box
        $box = Box::find($id);
        $box->delete();
        # redirect to the box page
        return to_route('admin.box.index')->with('success', 'Box deleted successfully');
    }
}
