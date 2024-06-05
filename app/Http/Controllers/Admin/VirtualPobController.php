<?php

namespace App\Http\Controllers\Admin;

use App\Models\Box;
use App\Models\PobPay;
use App\Models\PobBackup;
use Illuminate\Http\Request;
use App\Models\PobApplication;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class VirtualPobController extends Controller
{
    //
    public function index()
    {
        $boxes = Box::where('serviceType', 'VBox')->where('branch_id', auth()->user()->branch)->
        orderBy('name')->get();
        return view('admin.virtualPob.index', compact('boxes'));
    }

    public function details($id)
    {
        $box = Box::find(decrypt($id));
        #group by all year in boxes table
        $years = Box::selectRaw('year')->groupBy('year')->get();
        $paidYear = $box->year + 1;
        $currentYear = now()->year + 5;
        $yearsNotpaid = [];
        for ($i = $paidYear; $i <= $currentYear; $i++) {
            $yearsNotpaid[] = $i;
        }
        $payments = PobPay::where('box_id', decrypt($id))->orderBy('year', 'desc')->limit(10)->get();
        return view('admin.virtualPob.details', compact('box','payments','years', 'yearsNotpaid'));
    }
    public function approved()
    {
        $boxes = Box::where('aprooved', true)->where('serviceType', 'VBox')->orderBy('name')->get();
        return view('admin.virtualPob.approved', compact('boxes'));
    }
    #details
    public function waitingList()
    {
        $boxes = Box::where('aprooved', false)->where('serviceType', 'VBox')->orderBy('name')->get();
        return view('admin.virtualPob.waitingList', compact('boxes'));
    }
    public function update(Request $request, $id)
    {
        #validate
        $field = $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'phone' => 'required|numeric|digits:10',
            'year' => 'required',
            'cotion' => 'required',
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
        $box = Box::find($id);
        $box->update(['aprooved' => true]);

        return redirect()->back()->with('success', 'Pob Approved Successfully');
    }
    #reject
    public function reject($id)
    {
        $box = Box::find($id);
        $box->update(['aprooved' => 3]);

        return redirect()->back()->with('success', 'Pob Rejected Successfully');
    }

    public function paymentStore(Request $request)
    {
        $field = $request->validate([
            'payment_type' => 'required',
            'payment_model' => 'required',
            'payment_ref' => 'required',
            'payment_year' => 'required',
        ]);
        $box = Box::find($request->pob_id);


        $field['box_id'] = $request->pob_id;
        $field['amount'] = $request->allAmount;
        $field['serviceType'] = 'VBox';
        $field['bid'] = auth()->user()->branch;


        if ($request->payment_year == 'all') {
            // if allAmount is 0
            if ($request->allAmount == 0) {
                return redirect()->back()->with('alert', 'no debt to pay');
            }
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
    public function dailyIncome()
    {

        $courierPays = DB::table('pob_pays')
        ->select(DB::raw('SUM(amount) as cash'), 'pdate')
        ->where('bid', auth()->user()->branch)
        ->where('serviceType', 'VBox')
        ->groupBy('pdate')
        ->orderBy('pdate', 'DESC')
        ->limit(20)
        ->get();
        return view('admin.virtualPob.dailyIncome', compact('courierPays'));
    }

    public function monthlyIncome()
    {
        $boxes =  PobPay::where('serviceType', 'VBox')->where('branch_id', auth()->user()->branch)
        ->select(DB::raw('SUM(amount) as cash'),DB::raw('MONTH(created_at) as created_month'),DB::raw('YEAR(created_at) as created_year'))
        ->groupBy('created_month','created_year')->orderBy('created_year', 'DESC')->orderBy('created_month')->limit(20)->get();

        return view('admin.virtualPob.monthlyIncome', compact('boxes'));
    }
    public function transactionvbox($pdate)
    {
        $inboxings = PobPay::where('pdate',decrypt($pdate))
        ->where('serviceType','VBox')
        ->where('bid',auth()->user()->branch)
        ->get();

        $pdf = \Pdf::loadView('admin.backoffice.transactionvirtual', compact('pdate','inboxings'))
        ->setPaper('a4', 'portrait');
        return $pdf->stream('Virtualpoboxtransaction.pdf');
    }


}
