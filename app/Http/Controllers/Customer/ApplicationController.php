<?php

namespace App\Http\Controllers\Customer;

use App\Models\Box;
use App\Models\Branch;
use App\Models\PobPay;
use App\Models\VirtualBox;
use Illuminate\Http\Request;
use App\Models\PobApplication;
use App\Http\Controllers\Controller;

class ApplicationController extends Controller
{
    //
    public function index()
    {
        $branches = Branch::orderBy('name', 'asc')->get();
        return view('customer.pobox.application', compact('branches'));
    }
    public function getAvailablePob($branch)
    {
        $boxes = Box::where('branch_id', $branch)->where('available', true)->where('booked', false)->get();
        return response()->json($boxes);
    }
    public function getTakenPob($branch)
    {
        $boxes = Box::where('branch_id', $branch)->where('available', false)->where('booked', false)->get();
        return response()->json($boxes);
    }
    public function getPobInfo($pobId)
    {
        $pob = Box::find($pobId);
        return response()->json($pob);
    }

    public function store(Request $request)
    {
        $request->validate([
            'branch' => 'required',
            'attachment' => 'required|file|max:2048|mimes:pdf',
        ]);

        if ($request->PBox == 'ExistPO') {
            $request->validate([
                'name' => '',
                'email' => 'email',
                'phone' => '',
                'existypobox' => 'required'
            ]);
            $box = Box::findorfail($request->existypobox);

            $attachment = $request->file('attachment');
            $attachment_name = time() . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(public_path('attachments'), $attachment_name);

            #insert in Application model
            PobApplication::create(
                [
                    'pob' => $box->pob,
                    'branch_id' => $box->branch_id,
                    'status' => $box->status,
                    'name' => $box->name,
                    'email' => $request->email,
                    'phone' => $box->phone,
                    'year' => $box->year,
                    'pob_category' => $box->pob_category,
                    'serviceType' => 'PBox',
                    'pob_type' => $box->pob_type,
                    'amount' => $box->amount,
                    'attachment' => $attachment_name,
                    'is_new_customer' => 'no',
                    'customer_id' => auth()->guard('customer')->user()->id,
                ]
            );
            Box::findorfail($request->existypobox)->update(['booked' => true]);
            return to_route('customer.application.index')->with('success', 'Application Submitted Successfully');
        }

        if ($request->service == 'Physical Box') {
            $request->validate([
                'pob_category' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|numeric|min:10',
                'pobox' => 'required'
        ]);
            $pob_type = ($request->pob_category == 'Individual') ? 'Individual' : 'Company';

            #attachment
            $attachment = $request->file('attachment');
            $attachment_name = time() . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(public_path('attachments'), $attachment_name);

            #insert in Application model

            $pob = Box::findorfail($request->pobox)->pob;
            PobApplication::create(
                [
                    'pob' => $pob,
                    'branch_id' => $request->branch,
                    'status' => 'payee',
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'pob_category' => $request->pob_category,
                    'serviceType' => 'PBox',
                    'year' => now()->year,
                    'pob_type' => $pob_type,
                    'amount' => $request->total_amount,
                    'attachment' => $attachment_name,
                    'is_new_customer' => 'yes',
                    'customer_id' => auth()->guard('customer')->user()->id,
                ]
            );
            PobPay::create(
                [
                    'box_id' => $request->pobox,
                    'amount' => $request->total_amount,
                    'year' => now()->year,
                    'payment_type' => 'rent',
                    'payment_model' => 'Mobile Money',
                    'serviceType' => 'PBox',
                    'bid' =>$request->branch,
                    'payment_ref' => '0000000000',
                ]
            );
            Box::findorfail($request->pobox)->update(['booked' => true]);
            return to_route('customer.application.index')->with('success', 'Application Submitted Successfully');
        }
        else {
            $request->validate([
                'pob_category' => 'required',
                'name' => 'required',
                'email' => 'required|email',
                'phone' => 'required|numeric|min:10',
                'virtualPob' => 'required|numeric|min:10|unique:boxes,pob',
            ]);
            $pob_type = ($request->pob_category == 'Individual') ? 'Individual' : 'Company';
            $attachment = $request->file('attachment');
            $attachment_name = time() . '.' . $attachment->getClientOriginalExtension();
            $attachment->move(public_path('attachments'), $attachment_name);
           $boxe = Box::create(
                [
                    'pob' => $request->virtualPob,
                    'name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                    'branch_id' => $request->branch,
                    'pob_category' => $request->pob_category,
                    'status' => 'payee',
                    'date' => now(),
                    'year' => now()->year,
                    'pob_type' => $pob_type,
                    'serviceType' => 'VBox',
                    'amount' => 5000,
                    'cotion' => 0,
                    'booked' => true,
                    'attachment' => $attachment_name,
                    'customer_id' => auth()->guard('customer')->user()->id,
                ]
            );
            PobPay::create(
                [
                    'box_id' => $boxe->id,
                    'amount' => 5000,
                    'year' => now()->year,
                    'payment_type' => 'rent',
                    'payment_model' => 'Mobile Money',
                    'serviceType' => 'VBox',
                    'bid' =>$request->branch,
                    'payment_ref' => '0000000000',
                ]
            );
            return to_route('customer.application.index')->with('success', 'Application Submitted Successfully');
        }
    }
}
