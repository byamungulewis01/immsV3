<?php

namespace App\Http\Controllers\Eric\Backoffice;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Models\Eric\Courierpay;
use App\Http\Controllers\Controller;

class PercelMailPaymentController extends Controller
{
    public function index()
    {
        $inboxings = Inboxing::where('location', auth()->user()->branch)
            ->where('mailtype', 'p')->where('paystatus', '0')->where('instatus', '3')
            ->limit(1000)->orderBy('id', 'desc')->get();
        return view('admin.backoffice.pmailpay', compact('inboxings'));
    }
    public function store(Request $request, $id)
    {
        $formField = $request->validate([
            'amount' => 'required',
            'extra' => 'required',
            'ptype' => '',
            'reference' => '',
            'nidtype' => '',
            'nid' => 'numeric',
            'pknames' => 'required',
        ]);
        $formattedDate = Carbon::now()->format('Y-m-d');
        $formField['userid'] = auth()->user()->id;
        $formField['cid'] = $id;
        $formField['pdate'] = $formattedDate;
        $formField['balance'] = '0';
        $formField['bid'] = auth()->user()->branch;
        Courierpay::create($formField);
        $inbox = Inboxing::findOrFail($id);

        // Update the record with the new data
        $inbox->update([
            'paystatus' => '1',
            'instatus' => '4',
            'delivdate' => now(), // Adds the current date and time to the 'delivedate' field
        ]);
        $this->mailOutReport($inbox->mailtype);

        return back()->with('success', 'Mail  payement was  successful');
    }
}
