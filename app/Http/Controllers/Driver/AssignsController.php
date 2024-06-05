<?php

namespace App\Http\Controllers\Driver;

use App\Models\HomeDelivery;
use Illuminate\Http\Request;
use App\Models\Eric\AirportDispach;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerDispatch;

class AssignsController extends Controller
{
    //emsNational
    public function emsNational()
    {
        $myMails = CustomerDispatch::where('status',2)->where('postAgent',auth()->user()->id)->orderby('sentDate','desc')->get();
        return view('driver.assigns.ems-national',compact('myMails'));
    }
    // emsNationalReceive
    public function emsNationalReceive()
    {
        $myMails = CustomerDispatch::where('status',3)->where('postAgent',auth()->user()->id)->orderby('sentDate','desc')->get();
        return view('driver.assigns.ems-national',compact('myMails'));
    }
    // emsInternational
    public function emsInternational()
    {
        $myMails = AirportDispach::where('status',1)->orderby('id','desc')->get();
        // $myMails = AirportDispach::where('status',1) return view('driver.assigns.ems-international',compact('myMails'));

        return view('driver.assigns.ems-international',compact('myMails'));
    }
    // emsInternationalReceive
    public function emsInternationalReceive()
    {
        $myMails = AirportDispach::where('status',2)->orderby('id','desc')->get();
        // $myMails = AirportDispach::where('status',2)->where('postAgent',auth()->user()->id)->orderby('id','desc')->get();
        return view('driver.assigns.ems-international',compact('myMails'));
    }
    // emsInternationalPickup
    public function emsInternationalPickup(Request $request)
    {
      foreach ($request->checkAll as $value) {
        $mail = AirportDispach::find($value);
        $mail->update([
            'status'=>2,
            'driverpickupdate'=>now(),
        ]);
      }
        return redirect()->back()->with('success','Mails picked up');
    }
    // homeDelivery
    public function homeDelivery()
    {
        $deliveries =  HomeDelivery::where('status',1)->where('postAgent',auth()->user()->id)->orderBy('created_at','desc')->get();
        return view('driver.assigns.homeDelivery',compact('deliveries'));
    }
    // homeDeliveryReceive
    public function homeDeliveryReceive()
    {
        $deliveries =  HomeDelivery::where('status',2)->where('postAgent',auth()->user()->id)->orderBy('created_at','desc')->get();
        return view('driver.assigns.homeDelivery',compact('deliveries'));
    }
    // homeDeliveryApprove
    public function homeDeliveryApprove(Request $request, $id)
    {
        $request->validate([
            'code' => 'required',
        ]);
       $assign = HomeDelivery::find($id);
         if($assign->code != $request->code){
            return redirect()->back()->with('error','Code does not match');
         }
         $assign->update([
            'status'=>2,
            'deliveryDate' => now(),
         ]);
        return redirect()->back()->with('success','Delivery approved');
    }
}
