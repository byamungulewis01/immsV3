<?php

namespace App\Http\Controllers\Driver;

use Illuminate\Http\Request;
use App\Models\Driver\Calibiration;
use App\Http\Controllers\Controller;

class CaliberationController extends Controller
{
    //index
    public function index()
    {
        $calibirations = Calibiration::orderBy('id', 'desc')->get();
        return view('driver.caliberation.index', compact('calibirations'));
    }
    // store
    public function store(Request $request)
    {
        // validate
        $formDate = $request->validate([
            'vehicle_id' => 'required',
            'litres' => 'required',
            'milage' => 'required',
        ]);
        Calibiration::create($formDate);
        return redirect()->back()->with('success', 'Caliberation Created Successfully');
    }
    // update
    public function update(Request $request, $id)
    {
        // validate
        $formDate = $request->validate([
            'litres' => 'required',
            'milage' => 'required',
        ]);
        Calibiration::findorfail($id)->update($formDate);
        return redirect()->back()->with('success', 'Caliberation Updated Successfully');
    }
    // destroy
    public function destroy($id)
    {
        Calibiration::findorfail($id)->delete();
        return redirect()->back()->with('success', 'Caliberation Deleted Successfully');
    }
}
