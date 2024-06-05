<?php

namespace App\Http\Controllers\Eric\Tarifss;

use App\Models\prweight;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PercelWeightRegController extends Controller
{
    public function index()
    {
        $weights = prweight::orderBy('prw_id', 'desc')->get();
        return view('admin.tarifs.PERCEL.percelweightreg', compact('weights'));
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'weight' => 'required|numeric|unique:prweight',

        ]);

        prweight::create($formField);
        return back()->with('success', 'Weight Registration Successfully');
    }
    public function update(Request $request, $prw_id)
    {
        $formField = $request->validate([
            'weight' => 'required|string|',
        ]);
        prweight::findorfail($prw_id)->update($formField);
        return back()->with('success', 'Weight Updated Successfully');
    }
    public function destroy($prw_id)
    {
        prweight::findorfail($prw_id)->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
