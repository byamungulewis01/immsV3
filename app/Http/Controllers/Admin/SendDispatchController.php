<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Customer\CustomerDispatch;
use App\Models\Customer\CustomerDispatchDetails;
use App\Models\NationalMailDispatch;
use App\Models\NationalMailDispatchDetails;
use Illuminate\Http\Request;

class SendDispatchController extends Controller
{
    //index
    public function index($id)
    {
        $branches = Branch::where('status', 'active')->get();
        $branchName = Branch::findorfail($id);
        $dispatches = NationalMailDispatch::where('branch', $id)->where('status',0)->orderby('id', 'desc')->get();
        //  $mails = CustomerDispatchDetails:: pluck('dispatch_id')->toArray();
        $mails = CustomerDispatchDetails::where('status', 2)->pluck('refNumber')->toArray();
        return view('admin.sendDispatch.index', compact('branches', 'id', 'branchName', 'dispatches', 'mails'));
    }
    //store
    public function store(Request $request)
    {
        NationalMailDispatch::create(['branch' => $request->branch]);
        return redirect()->back()->with('success', 'Dispatch created successfully');
    }
    // destroy
    public function destroy($id)
    {
        NationalMailDispatch::findorfail($id)->delete();
        return redirect()->back()->with('success', 'Dispatch deleted successfully');
    }
    //show
    public function show($id)
    {

        $branches = Branch::where('status', 'active')->get();
        $dispatch = NationalMailDispatch::findorfail($id);
        $dispatchDetails = NationalMailDispatchDetails::where('dispatch', $id)->where('status',0)->get();
        $branchId = $dispatch->branch;
        $mails = CustomerDispatchDetails::where('status', 2)->pluck('refNumber')->toArray();
        return view('admin.sendDispatch.show', compact('dispatchDetails', 'branchId', 'branches', 'mails', 'id'));
    }
    // showStore
    public function showStore(Request $request)
    {
        $request->validate([
            'refNumber' => 'required',
        ]);
        $item = CustomerDispatchDetails::where('refNumber', $request->refNumber)->first();
        $exists = NationalMailDispatchDetails::where('customerMail', $item->id)->first();
        if ($exists) {
            return redirect()->back()->with('error', 'Mail already added');
        } else {
            NationalMailDispatchDetails::create([
                'dispatch' => $request->id,
                'customerMail' => $item->id,
                'customer_id' => CustomerDispatch::findorfail($item->dispatch_id)->customer_id,
            ]);
            $totalWeight = NationalMailDispatch::findorfail($request->id)->weight;

            NationalMailDispatch::findorfail($request->id)->update(['weight' => $totalWeight + $item->weight]);
            NationalMailDispatch::findorfail($request->id)->increment('mailsNumber');
        }
        return redirect()->back()->with('success', 'Mail added successfully');
    }
    // showDestroy
    public function showDestroy($id)
    {
        $item = NationalMailDispatchDetails::findorfail($id);
        $totalWeight = NationalMailDispatch::findorfail($item->dispatch)->weight;
        NationalMailDispatch::findorfail($item->dispatch)->update(['weight' => $totalWeight - $item->details->weight]);
        NationalMailDispatch::findorfail($item->dispatch)->decrement('mailsNumber');
        $item->delete();
        return redirect()->back()->with('success', 'Mail deleted successfully');
    }
    // viewDispatch
    public function viewDispatch()
    {
        $dispatches = NationalMailDispatch::where('status',0)->orderby('id', 'desc')->get();
        return view('admin.sendDispatch.viewDispatch', compact('dispatches'));
    }
    public function sentDispatch()
    {
        $dispatches = NationalMailDispatch::where('status',1)->orderby('id', 'desc')->get();
        return view('admin.sendDispatch.sentDispatch', compact('dispatches'));
    }
    public function recievedDispatch()
    {
        $dispatches = NationalMailDispatch::where('status',2)->orderby('id', 'desc')->get();
        return view('admin.sendDispatch.sentDispatch', compact('dispatches'));
    }
    // sentDispatchUpdate
    public function sentDispatchUpdate($id)
    {

        NationalMailDispatch::findorfail($id)->update(['status' => 1,'sentDate' => date('Y-m-d')]);
        NationalMailDispatchDetails::where('dispatch', $id)->pluck('customerMail')->each(function ($item, $key) {
            CustomerDispatchDetails::findorfail($item)->update(['status' => 3,'emsDate' => now()]);
        });
        return redirect()->back()->with('success', 'Dispatch sent successfully');
    }
    // mailsList
    public function mailsList($id)
    {
        $dispatches = NationalMailDispatchDetails::where('dispatch', $id)->get();
        return view('admin.sendDispatch.mails', compact('dispatches'));
    }
}
