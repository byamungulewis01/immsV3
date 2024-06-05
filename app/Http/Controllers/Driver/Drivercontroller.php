<?php

namespace App\Http\Controllers\Driver;

use App\Models\User;
use App\Models\Branch;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\VehicleHistory;

class Drivercontroller extends Controller
{
    //index
    public function index()
    {
        $employees = User::where('level', 'driver')->where('driverRole','driver')->get();
        return view('driver.index', compact('employees'));
    }
    //withVehicle
    public function withVehicle()
    {
        $employees = User::where('level', 'driver')->where('driverRole','driver')->whereNotNull('vehicle_id')->get();
        return view('driver.withVehicle', compact('employees'));
    }
    //withoutVehicle
    public function withoutVehicle()
    {
        $vehicles = Vehicle::whereNull('driverid')->get();
        $employees = User::where('level', 'driver')->where('driverRole','driver')->whereNull('vehicle_id')->get();
        return view('driver.withoutVehicle', compact('employees', 'vehicles'));
    }
    // assignVehicle
    public function assignVehicle(Request $request, $id)
    {
        $formField = $request->validate([
            'vehicle' => 'required',
        ]);
        User::findorfail($id)->update(['vehicle_id' => $request->vehicle]);
        Vehicle::findorfail($request->vehicle)->update(['driverid' => $id]);

        VehicleHistory::create([
            'vehicle_id' => $request->vehicle,
            'driver_id' => $id,
            'date_of_assignment' => now(),
        ]);

        return back()->with('success', 'Vehicle  Assigned Successfully');
    }
    // releaseVehicle
    public function releaseVehicle($id)
    {
        $user = User::findorfail($id);
        // select last in VehicleHistory where driver_id = $id and vehicle_id = $user->vehicle_id
        $vehicleHistory = VehicleHistory::where('driver_id', $id)->where('vehicle_id', $user->vehicle_id)->latest()->first();
        $vehicleHistory->update(['date_of_return' => now()]);
        User::findorfail($id)->update(['vehicle_id' => null]);
        Vehicle::findorfail($user->vehicle_id)->update(['driverid' => null]);
        return back()->with('success', 'Vehicle  Released Successfully');
    }
    // vehicleHistory
    public function vehicleHistory()
    {
        $vehicleHistory = VehicleHistory::orderBy('id', 'desc')->get();
        return view('driver.vehicleHistory', compact('vehicleHistory'));
    }
}
