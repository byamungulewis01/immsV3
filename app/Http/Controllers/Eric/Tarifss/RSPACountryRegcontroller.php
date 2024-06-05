<?php

namespace App\Http\Controllers\Eric\Tarifss;

use App\Models\continentw;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RSPACountryRegcontroller extends Controller
{
    public function index()
    {
        $countries = continentw::orderBy('cont_id', 'desc')->get();
        return view('admin.tarifs.RSPA.rspacountryreg', compact('countries'));
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'Continent' => 'required',
            'Country' => 'required|string|regex:/^[A-Za-z\s]+$/|unique:continentw',
            'countsh' => 'required|string|regex:/^[A-Za-z\s]+$/|unique:continentw',
        ]);
        $inbox = continentw::create($formField);
        return back()->with('success', 'Country Registration Successfully');
    }
    public function update(Request $request, $cont_id)
    {
        $formField = $request->validate([
            'Continent' => 'required',
            'Country' => 'required|string|regex:/^[A-Za-z\s]+$/',
            'countsh' => 'required|string|regex:/^[A-Za-z\s]+$/',
        ]);
        continentw::findorfail($cont_id)->update($formField);
        return back()->with('success', 'Customer Updated Successfully');
    }
    public function destroy($cont_id)
    {
        continentw::findorfail($cont_id)->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
