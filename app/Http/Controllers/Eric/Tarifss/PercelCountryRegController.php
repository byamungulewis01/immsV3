<?php

namespace App\Http\Controllers\Eric\Tarifss;

use App\Models\prcountries;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PercelCountryRegController extends Controller
{
    public function index()
    {
        $countries = prcountries::orderBy('pc_id', 'desc')->get();
        return view('admin.tarifs.PERCEL.percelcountryreg', compact('countries'));
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'countries' => 'required|string|regex:/^[A-Za-z\s]+$/|unique:prcountries',

        ]);

        prcountries::create($formField);
        return back()->with('success', 'Country Registration Successfully');
    }
    public function update(Request $request, $pc_id)
    {
        $formField = $request->validate([
            'countries' => 'required|string|',
        ]);
        prcountries::findorfail($pc_id)->update($formField);
        return back()->with('success', 'Country Updated Successfully');
    }
    public function destroy($pc_id)
    {
        prcountries::findorfail($pc_id)->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
