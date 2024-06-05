<?php

namespace App\Http\Controllers\Eric\Vehicle;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Vehicle::all();
        return view('admin.vehicle.Vehicle', compact('vehicles'));
    }
    public function index1()
    {
        $drivers = User::where('level', 'driver')->whereNull('vehicle_id')
            ->where('driverRole', 'driver')
            ->get();
        $vehicles = Vehicle::all();
        return view('admin.vehicle.assign', compact('vehicles', 'drivers'));
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'name' => 'required',
            'plate_number' => 'required',
            'model' => 'required',
            'type' => 'required',
            'fuel_liters' => 'required',
        ]);
        Vehicle::create($formField);
        return redirect()->back()->with('success', 'Vehicle Added Successfully');
    }
    public function update(Request $request, $id)
    {
        $formField = $request->validate([
            'name' => 'required',
            'plate_number' => 'required',
            'model' => 'required',
            'type' => 'required',
            'fuel_liters' => 'required',
        ]);
        Vehicle::findorfail($id)->update($formField);
        return back()->with('success', 'Vehicle  Updated Successfully');
    }
    public function assign(Request $request, $id)
    {
        $formField = $request->validate([
            'driverid' => 'required',
        ]);
        Vehicle::findorfail($id)->update(['status' => '1', 'driverid' => $request->driverid]);
        User::where('id', $request->driverid)->update(['vehicle_id' => $id]);
        return back()->with('success', 'Vehicle  Assigned Successfully');
    }
    public function reassign(Request $request, $id)
    {
        $formField = $request->validate([

        ]);
        Vehicle::findorfail($id)->update(['status' => '0', 'driverid' => null]);
        User::where('id', $request->driverid)->update(['vehicle_id' => null]);
        return back()->with('success', 'Vehicle  ReAssigned Successfully');
    }
   public function destroy($id)
{
    // Find the Vehicle with the given ID and delete it
    $vehicle = Vehicle::findOrFail($id);
    $vehicle->delete();
    
    // Find the associated User and update their vehicle_id to null only if it is not already null
    $user = User::where('vehicle_id', $id)->first();
    if ($user && $user->vehicle_id !== null) {
        $user->update(['vehicle_id' => null]);
    }

    return back()->with('success', 'Deleted Successfully');
}

}
