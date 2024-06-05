<?php

namespace App\Http\Controllers\Eric\Tarifss;

use App\Models\Eric\Range;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EmsWeightRangeRegcontroller extends Controller
{
    public function index()
    {
        $ranges = DB::table('ranges')->orderBy('id', 'desc')->get();
        return view('admin.tarifs.EMS.weightrange', compact('ranges'));
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'minweight' => 'required|numeric||unique:ranges',
            'maxweight' => 'required|numeric||unique:ranges',


        ]);
        if($request->minweight >= $request->maxweight){
            return back()->with('warning', 'Not Inserted becouse minweight is higher than max weight');

        }
        else{
            $inbox = Range::create($formField);
            return back()->with('success', 'Weight Range Registration Successfully');
        }


    }
    public function update(Request $request, $id)
    {
        $formField = $request->validate([
            'minweight' => 'required|numeric|',
            'maxweight' => 'required|numeric|',
        ]);
        if($request->minweight >= $request->maxweight){
            return back()->with('warning', 'Not Inserted becouse minweight is higher than max weight');

        }
        else{
            Range::findorfail($id)->update($formField);
            return back()->with('success', 'Weight Range Updated Successfully');
        }

    }
    public function destroy($id)
    {
        Range::findorfail($id)->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
