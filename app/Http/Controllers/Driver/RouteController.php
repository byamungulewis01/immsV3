<?php

namespace App\Http\Controllers\Driver;

use Illuminate\Http\Request;
use App\Models\Driver\RouteCard;
use App\Http\Controllers\Controller;

class RouteController extends Controller
{
    //index
    public function index()
    {
        $routes = RouteCard::orderBy('id', 'desc')->get();
        return view('driver.route.index', compact('routes'));
    }
    // store
    public function store(Request $request)
    {
        // validate
        $formDate = $request->validate([
            'vehicle_id' => 'required',
            'km_out' => 'required',
            'destination' => 'required',
        ]);
         $route = RouteCard::where('vehicle_id',$request->vehicle_id)->where('km_in',null)->latest()->first();
         if ($route) {
            return redirect()->back()->with('error', 'You Must fill Last Kilometers in to Continue');
         }
         RouteCard::create($formDate);
        return redirect()->back()->with('success', 'Route Card Created Successfully');
    }
    // update
    public function update(Request $request, $id)
    {
        // validate
        $formDate = $request->validate([
            'km_out' => 'required',
            'destination' => 'required',
        ]);
        RouteCard::findorfail($id)->update($formDate);
        return redirect()->back()->with('success', 'Route Card Updated Successfully');
    }
    // destroy
    public function destroy($id)
    {
        RouteCard::findorfail($id)->delete();
        return redirect()->back()->with('success', 'Route Card Deleted Successfully');
    }
    // kmIn
    public function kmIn(Request $request, $id)
    {
        // validate
        $formDate = $request->validate([
            'km_in' => 'required',
        ]);
        $route = RouteCard::findorfail($id);
        if ($route->km_out > $request->km_in) {
            return redirect()->back()->with('error', 'Km In Must Be Greater Than Km Out');
        }
        $route->update([
            'km_in' => $request->km_in,
            'date_returned' => now(),
        ]);
        return redirect()->back()->with('success', 'Route Card Updated Successfully');
    }
}
