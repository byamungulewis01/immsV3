<?php

namespace App\Http\Controllers\Customer;

use App\Models\Box;
use App\Models\PobPay;
use App\Models\PreFormaBill;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Models\PobApplication;
use App\Http\Controllers\Controller;

class CustomerPobController extends Controller
{
    //physicalPob
    public function physicalPob()
    {
        $boxes = PobApplication::where('customer_id', auth()->guard('customer')->user()->id)->get();
        return view('customer.pobox.physicalPob', compact('boxes'));
    }
    //physicalPob Details
    public function physicalPobDetails($id)
    {
        $id = decrypt($id);
        $box = Box::find($id);
        $years = Box::selectRaw('year')->groupBy('year')->get();
        $paidYear = $box->year + 1;
        $currentYear = now()->year + 5;
        $yearsNotpaid = [];
        for ($i = $paidYear; $i <= $currentYear; $i++) {
            $yearsNotpaid[] = $i;
        }
        $payments = PobPay::where('box_id', $id)->orderBy('id', 'desc')->limit(10)->get();
        return view('customer.pobox.physicalPobDetails', compact('box', 'yearsNotpaid', 'payments', 'years'));
    }
    public function virtualPobDetails($id)
    {
        $id = decrypt($id);
        $box = Box::find($id);
        $years = Box::selectRaw('year')->groupBy('year')->get();
        $paidYear = $box->year + 1;
        $currentYear = now()->year + 5;
        $yearsNotpaid = [];
        for ($i = $paidYear; $i <= $currentYear; $i++) {
            $yearsNotpaid[] = $i;
        }
        $payments = PobPay::where('box_id', $id)->orderBy('id', 'desc')->limit(10)->get();
        return view('customer.pobox.virtualPobDetails', compact('box', 'yearsNotpaid', 'payments', 'years'));
    }
    // updatePob
    public function physicalPobUpdate(Request $request, $id)
    {
        #validate
        $field = $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric|min:10',
            'email' => 'required|email',
            'pob_category' => 'required',
        ]);
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $name = time() . $file->getClientOriginalName();
            $file->move(public_path('attachments'), $name);
            $field['attachment'] = $name;
        }
        #update

        $box = PobApplication::find($id);
        $box->update($field);

        return redirect()->back()->with('success', 'Pob Updated Successfully');
    }

    # downloadAttachment
    public function downloadAttachment($id)
    {
        $file = public_path('attachments/' . $id);
        return response()->download($file);
    }

    public function virtualPayment(Request $request)
    {
        $field = $request->validate([
            'payment_type' => 'required',
            'payment_model' => 'required',
            'payment_ref' => 'required',
        ]);

        $box = Box::find($request->pob_id);
        $field['box_id'] = $request->pob_id;
        $field['amount'] = $request->allAmount;
        $field['serviceType'] = 'VBox';
        $field['bid'] = $box->branch_id;
        if ($request->payment_type != 'rent') {
            $field['year'] = now()->year;
            PobPay::create($field);
            if ($request->payment_type == 'cotion') {
                $box->update(['cotion' => true]);
            }
        } else {
            $field = $request->validate(['payment_year' => 'required']);
            if ($request->payment_year == 'all') {
                // if allAmount is 0
                if ($request->allAmount == 0) {
                    return redirect()->back()->with('alert', 'no debt to pay');
                }
                $box = Box::find($request->pob_id);
                $field['box_id'] = $request->pob_id;
                $field['amount'] = $request->allAmount;
                $field['serviceType'] = 'VBox';
                $field['bid'] = $box->branch_id;
                $field['payment_method'] = $request->payment_method;
                $field['payment_model'] = $request->payment_model;

                $field['year'] = now()->year;
                PobPay::create($field);
                $box->update(['year' => now()->year, 'status' => 'payee', 'date' => now()]);
            } else {
                if ($request->payment_year == $box->year + 1) {
                    $box = Box::find($request->pob_id);
                    $field['box_id'] = $request->pob_id;
                    $field['amount'] = $request->allAmount;
                    $field['serviceType'] = 'PBox';
                    $field['bid'] = $box->branch_id;
                    $field['payment_method'] = $request->payment_method;
                    $field['payment_model'] = $request->payment_model;

                    $field['year'] = $request->payment_year;
                    PobPay::create($field);
                    $box->update(['year' => $request->payment_year, 'status' => 'payee', 'date' => now()]);
                } else {
                    return redirect()->back()->with('alert', 'You next payment is ' . $box->year + 1);
                }
            }
        }

        return redirect()->back()->with('success', 'Pob Updated Successfully');
    }
    public function physicalPayment(Request $request)
    {
        $field = $request->validate([
            'payment_type' => 'required',
            'payment_model' => 'required',
            'payment_ref' => 'required',
        ]);

        $box = Box::find($request->pob_id);
        $field['box_id'] = $request->pob_id;
        $field['amount'] = $request->allAmount;
        $field['serviceType'] = 'PBox';
        $field['bid'] = $box->branch_id;
        if ($request->payment_type != 'rent') {
            $field['year'] = now()->year;
            PobPay::create($field);
            if ($request->payment_type == 'cotion') {
                $box->update(['cotion' => true]);
            }
        } else {
            $field = $request->validate(['payment_year' => 'required']);
            if ($request->payment_year == 'all') {
                // if allAmount is 0
                if ($request->allAmount == 0) {
                    return redirect()->back()->with('alert', 'no debt to pay');
                }
                $box = Box::find($request->pob_id);
                $field['box_id'] = $request->pob_id;
                $field['amount'] = $request->allAmount;
                $field['serviceType'] = 'PBox';
                $field['bid'] = $box->branch_id;
                $field['payment_method'] = $request->payment_method;
                $field['payment_model'] = $request->payment_model;

                $field['year'] = now()->year;
                PobPay::create($field);
                $box->update(['year' => now()->year, 'status' => 'payee', 'date' => now()]);
            } else {
                if ($request->payment_year == $box->year + 1) {
                    $box = Box::find($request->pob_id);
                    $field['box_id'] = $request->pob_id;
                    $field['amount'] = $request->allAmount;
                    $field['serviceType'] = 'PBox';
                    $field['bid'] = $box->branch_id;
                    $field['payment_method'] = $request->payment_method;
                    $field['payment_model'] = $request->payment_model;

                    $field['year'] = $request->payment_year;
                    PobPay::create($field);
                    $box->update(['year' => $request->payment_year, 'status' => 'payee', 'date' => now()]);
                } else {
                    return redirect()->back()->with('alert', 'You next payment is ' . $box->year + 1);
                }
            }
        }

        return redirect()->back()->with('success', 'Pob Updated Successfully');
    }

    //virtualPob
    public function virtualPob()
    {
        $boxes = Box::where('customer_id', auth()->guard('customer')->user()->id)
            ->where('serviceType', 'VBox')->get();
        return view('customer.pobox.virtualPob', compact('boxes'));
    }
    // virtualPobUpdate
    public function virtualPobUpdate(Request $request, $id)
    {
        #validate
        $field = $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric|min:10',
            'email' => 'required|email',
            'pob_category' => 'required',
        ]);
        if ($request->hasFile('attachment')) {
            $file = $request->file('attachment');
            $name = time() . $file->getClientOriginalName();
            $file->move(public_path('attachments'), $name);
            $field['attachment'] = $name;
        }
        #update

        $box = Box::find($id);
        $box->update($field);

        return redirect()->back()->with('success', 'Pob Updated Successfully');
    }
    public function preforma($id)
    {
        $item = PreFormaBill::where('box', $id)->latest()->first();
        $pdf = Pdf::loadView('admin.physicalpob.preforma', compact('item'))
        ->setPaper('a4', 'portrait');
         return $pdf->stream('preforma.pdf');

    }
    public function invoice($id)
    {
        $box = PobPay::find($id);
        $pdf = Pdf::loadView('admin.physicalPob.invoice', compact('box'))
            ->setPaper('a7', 'portrait');
        return $pdf->stream('invoice.pdf');
    }
}
