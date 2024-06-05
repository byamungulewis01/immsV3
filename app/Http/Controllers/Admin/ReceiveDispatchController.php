<?php

namespace App\Http\Controllers\Admin;

use App\Models\Customer\CustomerDispatchDetails;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\NationalMailDispatch;
use App\Models\NationalMailDispatchDetails;

class ReceiveDispatchController extends Controller
{
    public function index()
    {
         $dispatches = NationalMailDispatch::where('status',1)->where('branch',auth()->user()->branch)
         ->orderby('id', 'desc')->get();
        return view('admin.receiveDispatch.index', compact('dispatches'));
    }
    public function confirmed()
    {
         $dispatches = NationalMailDispatch::where('status',2)->where('branch',auth()->user()->branch)
         ->orderby('id', 'desc')->get();
        return view('admin.receiveDispatch.confirmed', compact('dispatches'));
    }
    // confirmRecieved
    public function confirmRecieved($id)
    {
        $dispatch = NationalMailDispatch::find($id);
        $dispatch->status = 2;
        $dispatch->receivedBy = auth()->user()->id;
        $dispatch->save();

        NationalMailDispatchDetails::where('dispatch', $id)->pluck('customerMail')->each(function ($item, $key) {
            CustomerDispatchDetails::findorfail($item)->update(['status' => 4,'branchManagerDate' => now()]);
        });

        return redirect()->back()->with('success', 'Confirmed Successfully');
    }
    // show
    public function show($id)
    {
        $dispatchDetails = NationalMailDispatchDetails::where('dispatch', $id)->get();
        return view('admin.receiveDispatch.show', compact('dispatchDetails'));
    }
    // recieved
    public function recieved($id)
    {
        $dispatch = NationalMailDispatchDetails::find($id);
         $customerMail = $dispatch->customerMail;

       CustomerDispatchDetails::find($customerMail)->update(['status' => 5,'deliveredDate' => now()]);

        $dispatch->status = 1;
        $dispatch->dateReceived = date('Y-m-d');
        $weight = CustomerDispatchDetails::find($customerMail)->weight;
        $dispatch->weight = $weight;
        $price = CustomerDispatchDetails::find($customerMail)->price;
        $dispatch->price = $price;
        $dispatch->save();
        return redirect()->back()->with('success', 'Recieved Successfully');
    }
}
