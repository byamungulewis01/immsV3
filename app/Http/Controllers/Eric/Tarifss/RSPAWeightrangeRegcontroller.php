<?php

namespace App\Http\Controllers\Eric\Tarifss;

use App\Models\Eric\Prange;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;


class RSPAWeightrangeRegcontroller extends Controller
{
    public function index()
    {
        $ranges = DB::table('pranges')->orderBy('id', 'desc')->get();
        return view('admin.tarifs.RSPA.weightrange', compact('ranges'));
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'minweight' => 'required|numeric||unique:pranges',
            'maxweight' => 'required|numeric||unique:pranges',


        ]);
        if($request->minweight >= $request->maxweight){
            return back()->with('warning', 'Not Inserted becouse minweight is higher than max weight');

        }
        else{
            $inbox = Prange::create($formField);
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
            Prange::findorfail($id)->update($formField);
            return back()->with('success', 'Weight Range Updated Successfully');
        }

    }
    
    public function destroy($id)
    {
        Prange::findorfail($id)->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
