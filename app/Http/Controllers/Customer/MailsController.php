<?php

namespace App\Http\Controllers\Customer;

use App\Models\Box;
use App\Models\HomeDelivery;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerDispatchDetails;

class MailsController extends Controller
{
    //index
    public function index()
    {
        $boxes = Box::where('customer_id', auth()->guard('customer')->user()->id)->get();
          $box = Box::where('customer_id', auth()->guard('customer')->user()->id)->first();
        $couriers = Inboxing::where('customer_id',auth()->guard('customer')->user()->id)->where('instatus', '3')
        ->where('pob',$box->pob)->where('pob_bid',$box->branch_id)->orderby('id', 'desc')->get();

        return view('customer.mails.international', compact('boxes', 'couriers'));
    }
    public function show($id)
    {
        $pob = Box::findorfail(decrypt($id));
        $couriers = Inboxing::where('pob', $pob->pob)->where('pob_bid', $pob->branch_id)->where('instatus', '3')
        ->where('customer_id', auth()->guard('customer')->user()->id)->orderby('id', 'desc')->get();
        $boxes = Box::where('customer_id', auth()->guard('customer')->user()->id)->get();
        $id = decrypt($id);
        return view('customer.mails.international', compact('boxes', 'couriers','id'));
    }
    public function national()
    {
       //select pobox to array
       $box = Box::where('customer_id', auth()->guard('customer')->user()->id)->first();
        $couriers = CustomerDispatchDetails::where('customer_id', auth()->guard('customer')->user()->id)->where('status',4)
        ->where('pob',$box->pob)->orderby('id', 'desc')->get();
        $boxes = Box::where('customer_id', auth()->guard('customer')->user()->id)->get();
        return view('customer.mails.national', compact('boxes', 'couriers'));
    }
    public function nationalShow($id)
    {
        $pob = Box::findorfail(decrypt($id))->pob;
        $couriers = CustomerDispatchDetails::where('pob', $pob)->where('status',4)
        ->where('customer_id', auth()->guard('customer')->user()->id)
        ->orderby('id', 'desc')->get();
        $boxes = Box::where('customer_id', auth()->guard('customer')->user()->id)->get();
        $id = decrypt($id);
        return view('customer.mails.national', compact('boxes', 'couriers','id'));
    }
    // deliveryOrder
    public function deliveryOrder(Request $request, $id)
    {
      validator($request->all(), [
        'address' => 'required',
        'expectedDate' => 'required',
      ]);
      $courier = Inboxing::find($id);
      $check = HomeDelivery::where('inboxing', $id)->first();
        if ($check) {
        return back()->with('error', 'This inboxing is already requested for delivery');
        }
        HomeDelivery::create([
            'customer_id' => auth()->guard('customer')->user()->id,
            'pob' => $courier->pob,
            'box_id' => Box::where('pob', $courier->pob)->where('branch_id',$courier->pob_bid)->first()->id,
            'addressOfDelivery' => $request->address,
            'inboxing' => $id,
            'expectedDateOfDelivery' => $request->expectedDate,
            'amount' => 3000,
            'paymentMethod' => 'cash',
            'paymentReference' => rand(100000, 999999),
        ]);
        Inboxing::findorfail($id)->update(['instatus' => '5']);
        return to_route('customer.mail.homeDelivery')->with('success', 'Delivery request sent successfully');


    }

    // homeDelivery
    public function homeDelivery()
    {
        $deliveries = HomeDelivery::where('customer_id', auth()->guard('customer')->user()->id)->orderby('id', 'desc')->get();
        return view('customer.mails.homeDelivery', compact('deliveries'));
    }


}
