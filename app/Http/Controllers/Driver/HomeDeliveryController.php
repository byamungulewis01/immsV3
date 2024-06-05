<?php

namespace App\Http\Controllers\Driver;

use App\Models\User;
use App\Models\HomeDelivery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeDeliveryController extends Controller
{
    //index
    public function index()
    {
        $drivers = User::where('level','driver')->where('status','active')->where('driverRole','driver')->get();
        $deliveries =  HomeDelivery::where('status',0)->orderBy('created_at','desc')->get();
        return view('driver.homeDelivery.index', compact('deliveries','drivers'));
    }
    public function transit()
    {
        $drivers = User::where('level','driver')->where('status','active')->where('driverRole','driver')->get();
        $deliveries =  HomeDelivery::where('status',1)->orderBy('created_at','desc')->get();
        return view('driver.homeDelivery.index', compact('deliveries','drivers'));
    }
    public function delivered()
    {  
        $drivers = User::where('level','driver')->where('status','active')->where('driverRole','driver')->get();
        $deliveries =  HomeDelivery::where('status',2)->orderBy('created_at','desc')->get();
        return view('driver.homeDelivery.index', compact('deliveries','drivers'));
    }
    // assign delivery to driver
    public function assignDelivery(Request $request, $id)
    {
        $request->validate([
            'driver' => 'required',
        ]);

      HomeDelivery::find($id)->update([
        'postAgent'=>$request->driver,
      'status'=>1,
      'code' => rand(10000, 99999),
    ]); // status 1 means 'transit to driver'
        return redirect()->back()->with('success','Delivery assigned to driver');
    }
}
