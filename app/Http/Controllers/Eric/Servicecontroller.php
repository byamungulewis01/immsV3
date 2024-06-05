<?php

namespace App\Http\Controllers\Eric;

use App\Models\servicetype;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class Servicecontroller extends Controller
{
    public function index()
    {
        $services = servicetype::orderBy('servty_id','DESC')->get();
        return view('admin.tarifs.servicetypereg', compact('services'));
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'shortname' => 'required|string|regex:/^[A-Za-z\s]+$/',
            'description' => 'required',
        ]);
        $inbox = servicetype::create($formField);
        return back()->with('success', 'Service Type Registration Successfully');
    }
    public function update(Request $request,$servty_id)
    {
        $formField = $request->validate([
            'shortname' => 'required|string|regex:/^[A-Za-z\s]+$/',
            'description' => 'required',
        ]);
        servicetype::findorfail($servty_id)->update($formField);
        return back()->with('success', 'Service Type  Updated Successfully');
    }
    public function destroy($servty_id)
    {
        servicetype::findorfail($servty_id)->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
