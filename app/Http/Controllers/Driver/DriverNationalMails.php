<?php

namespace App\Http\Controllers\Driver;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Customer\CustomerDispatch;
use App\Models\Customer\CustomerDispatchDetails;
use Barryvdh\DomPDF\Facade\Pdf;
class DriverNationalMails extends Controller
{
    //index
    public function index()
    {
        $myMails = CustomerDispatch::where('status',1)->orderby('sentDate','desc')->get();
        $drivers = User::where('level','driver')->where('status','active')->where('driverRole','driver')->whereNotNull('vehicle_id')->get();
        return view('driver.nationalMails.index',compact('myMails','drivers'));
    }
    public function assigned()
    {
        $myMails = CustomerDispatch::where('status',2)->orderby('sentDate','desc')->get();
        return view('driver.nationalMails.assigned',compact('myMails'));
    }
    // assignMail
    public function assignMail(Request $request,$id)
    {
        $mail = CustomerDispatch::findorfail($id);
        $mail->update([
            'postAgent' => $request->driver,
            'status' => 2,
            'securityCode' => rand(10000,99999),
        ]);
        return back()->with('success','Mail assigned successfully');
    }
    // received
    public function received()
    {
        $myMails = CustomerDispatch::where('status',3)->orderby('deliveryDate')->get();
        return view('driver.nationalMails.received',compact('myMails'));
    }
    public function sentMail()
    {
        $myMails = CustomerDispatch::where('status',4)->orderby('deliveryDate')->get();
        return view('driver.nationalMails.sentMail',compact('myMails'));
    }
    // details
    public function details($id)
    {

        $dispatches = CustomerDispatchDetails::where('dispatch_id',decrypt($id))->get();
        $dispatche = CustomerDispatch::findorfail(decrypt($id));
        $id = decrypt($id);
        return view('driver.nationalMails.details',compact('dispatches','dispatche','id'));
    }
    public function sentMailDetail($id)
    {

        $dispatches = CustomerDispatchDetails::where('dispatch_id',decrypt($id))->get();
        $dispatche = CustomerDispatch::findorfail(decrypt($id));
        $id = decrypt($id);
        return view('driver.nationalMails.details',compact('dispatches','dispatche','id'));
    }
    // fillUp
    public function fillUp(Request $request,$id)
    {
        // validate
        $request->validate([
            'weight' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $dispatch = CustomerDispatchDetails::findorfail($id);
        $dispatch->update([
            'weight' => $request->weight,
            'price' => $request->price,
            'observation' => $request->observation,
            'status' => 2,
            'logisticDate' => now(),
        ]);
    //  update CustomerDispatch weight where id = $id
        $dispatche = CustomerDispatch::findorfail($dispatch->dispatch_id);
        $dispatche->update([
            'weight' => $dispatche->weight + $request->weight,
            'price' => $dispatche->price + $request->price,
        ]);

        return back()->with('success','Mail filled up successfully');
    }
    // submit
    public function submit($id)
    {
        $dispatch = CustomerDispatchDetails::where('dispatch_id',$id)->whereIn('status',[0,1])->first();
        if($dispatch){
            return back()->with('warning','Please fill up all mails');
        }
        CustomerDispatchDetails::where('dispatch_id',$id)->update(['status' => 2,]);
        CustomerDispatch::findorfail($id)->update(['status' => 4,]);

        return to_route('driver.nationalMails.received')->with('success','Mail submitted successfully');
    }
    public function pod($id)
    {
        $dispatches = CustomerDispatchDetails::where('dispatch_id',$id)->get();

        $pdf = Pdf::loadView('driver.nationalMails.pod', compact('dispatches'))
        ->setPaper('a4', 'landscape');
         return $pdf->download('pod.pdf');
    }
}
