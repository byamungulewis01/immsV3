<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\PobPay;
use App\Models\PobBackup;
use App\Models\PobApplication;
use Illuminate\Http\Request;

class BranchManagerController extends Controller
{
    public function index()
    {
        //   $boxes = Box::where('branch_id', auth()->user()->branch_id)->get();
        $boxes = Box::where('aprooved', true)->get();
        return view('admin.branchManager.index', compact('boxes'));
    }
    #details
    public function waitingList()
    {
        //   $boxes = Box::where('branch_id', auth()->user()->branch_id)->get();
        $boxes = PobApplication::where('aprooved', false)->get();
        return view('admin.branchManager.waitingList', compact('boxes'));
    }
    #details
    public function details($id)
    {
        $box = Box::find($id);
        #group by all year in boxes table
        $years = Box::selectRaw('year')->groupBy('year')->get();
        $paidYear = $box->year + 1;
        $currentYear = now()->year;
        $yearsNotpaid = [];
        for ($i = $paidYear; $i <= $currentYear; $i++) {
            $yearsNotpaid[] = $i;
        }
        return view('admin.branchManager.details', compact('box', 'years', 'yearsNotpaid'));
    }
    #updatePob
    public function updatePob(Request $request, $id)
    {
        #validate
        $field = $request->validate([
            'name' => 'required',
            'phone' => 'required|numeric|min:10',
            'year' => 'required',
            'pob_category' => 'required',
            'size' => 'required',
            'cotion' => 'required',
            'available' => 'required',
        ]);
        #update
        $box = Box::find($id);
        $box->update($field);

        return redirect()->back()->with('success', 'Pob Updated Successfully');
    }

    # downloadAttachment
    public function download($id)
    {
        $file = public_path('attachments/' . $id);
        return response()->download($file);
    }

    #approve
    public function approve($id)
    {
        $box = PobApplication::find($id);
        $box->update(['aprooved' => true]);
        #box update where pob = $box->pob
        if ($box->is_new_customer == 'yes') {
            $existyPob = Box::where('pob', $box->pob)->first();
            // add in backup table
            PobBackup::create([
                'pob' => $existyPob->pob,
                'branch_id' => $existyPob->branch_id,
                'status' => $existyPob->status,
                'name' => $existyPob->name,
                'email' => $existyPob->email,
                'phone' => $existyPob->phone,
                'date' => $existyPob->date,
                'size' => $existyPob->size,
                'pob_category' => $existyPob->pob_category,
                'pob_type' => $existyPob->pob_type,
                'amount' => $existyPob->amount,
                'year' => $existyPob->year,
                'attachment' => $existyPob->attachment,
                'available' => $existyPob->available,
                'cotion' => $existyPob->cotion,
                'customer_id' => $existyPob->customer_id,
            ]);

            Box::where('pob', $box->pob)->update([
                'aprooved' => true,
                'branch_id' => $box->branch_id,
                'status' => $box->status,
                'name' => $box->name,
                'email' => $box->email,
                'phone' => $box->phone,
                'date' => $box->created_at,
                'pob_category' => $box->pob_category,
                'pob_type' => $box->pob_type,
                'amount' => $box->amount,
                'year' => $box->year,
                'attachment' => $box->attachment,
                'available' => false,
                'booked' => true,
                'customer_id' => $box->customer_id,
            ]);
        } else {
            Box::where('pob', $box->pob)->update([
                'aprooved' => true,
                'branch_id' => $box->branch_id,
                'name' => $box->name,
                'email' => $box->email,
                'phone' => $box->phone,
                'pob_category' => $box->pob_category,
                'pob_type' => $box->pob_type,
                'attachment' => $box->attachment,
                'available' => false,
                'booked' => true,
                'customer_id' => $box->customer_id,
            ]);
        }
        return redirect()->back()->with('success', 'Pob Approved Successfully');
    }
    #reject
    public function reject($id)
    {
        $box = PobApplication::find($id);
        if ($box->is_new_customer == 'yes') {
            # code...
            $box->update(['aprooved' => 3]);
            #update box where pob = $box->pob
            Box::where('pob', $box->pob)->update(['aprooved' => false, 'available' => true, 'booked' => false]);
        } else {
            # code...
            $box->update(['aprooved' => 3]);
            #update box where pob = $box->pob
            Box::where('pob', $box->pob)->update(['aprooved' => false, 'booked' => false]);
        }
        return redirect()->back()->with('success', 'Pob Rejected Successfully');
    }
    #transfer
    public function transfer(Request $request, $id)
    {
        #update
        $box = Box::find($id);
        PobBackup::create(
            [
                'pob' => $box->pob,
                'branch_id' => $box->branch_id,
                'size' => $box->size,
                'status' => $box->status,
                'name' => $box->name,
                'email' => $box->email,
                'phone' => $box->phone,
                'available' => $box->available,
                'date' => $box->date,
                'pob_category' => $box->pob_category,
                'pob_type' => $box->pob_type,
                'amount' => $box->amount,
                'year' => $box->year,
                'attachment' => $box->attachment,
                'available' => $box->available,
            ]
        );

        $box->update(['available' => true, 'booked' => false]);

        return redirect()->back()->with('success', 'Pob Transfered Successfully');
    }
    #paymentStore
    public function paymentStore(Request $request)
    {
        #validate
        $field = $request->validate([
            'payment_type' => 'required',
            'payment_model' => 'required',
            'payment_ref' => 'required',
            'payment_year' => 'required',
        ]);
        $box = Box::find($request->pob_id);


        $field['box_id'] = $request->pob_id;
        $field['amount'] = $request->allAmount;

        if ($request->payment_year == 'all') {
            $field['year'] = now()->year;
            PobPay::create($field);
            $box->update(['year' => now()->year, 'status' => 'payee', 'date' => now()]);
        } else {
            if ($request->payment_year == $box->year + 1) {
                $field['year'] = $request->payment_year;
                PobPay::create($field);
                $box->update(['year' => $request->payment_year, 'status' => 'payee', 'date' => now()]);
            } else {
                return redirect()->back()->with('alert', 'You next payment is ' . $box->year + 1);
            }
        }
        return redirect()->back()->with('success', 'Pob Updated Successfully');
    }
}
