<?php

namespace App\Http\Controllers\Eric\Tarifss;

use App\Models\Country;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class EmsCountryRegcontroller extends Controller
{
    public function index()
    {
        $countries = Country::orderBy('c_id', 'desc')->get();
        return view('admin.tarifs.EMS.emscountryreg', compact('countries'));
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'countryname' => 'required|string|regex:/^[A-Za-z\s]+$/|unique:country',
            'countsh' => 'required|string|regex:/^[A-Za-z\s]+$/|unique:country',
            'code' => 'required|string|regex:/^\+\d+$/|unique:country',
        ]);

        $inbox = Country::create($formField);
        return back()->with('success', 'Country Registration Successfully');
    }
    public function update(Request $request, $c_id)
    {
        $formField = $request->validate([
            'countryname' => 'required|string|regex:/^[A-Za-z\s]+$/',
            'countsh' => 'required|string|regex:/^[A-Za-z\s]+$/',
            'code' => 'required|string|regex:/^\+\d+$/',
        ]);
        Country::findorfail($c_id)->update($formField);
        return back()->with('success', 'Country Updated Successfully');
    }
    public function destroy($c_id)
    {
        Country::findorfail($c_id)->delete();
        return back()->with('success', 'Deleted Successfully');
    }

}
