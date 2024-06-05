<?php

namespace App\Http\Controllers\Eric\Backoffice;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Models\InboxingReport;
use App\Models\Eric\Courierpay;
use App\Http\Controllers\Controller;

class EmsMailPaymentcontroller extends Controller
{
    public function index()
    {
        $inboxings = Inboxing::where('location', auth()->user()->branch)
            ->where('mailtype', 'ems')->where('paystatus', '0')->where('instatus', '3')
            ->orderBy('id', 'desc')
            ->limit(1000)->get();
        return view('admin.backoffice.emspay', compact('inboxings'));
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
        $formField['userid'] = auth()->user()->id;
        $formField['cid'] = $id;
        $formField['pdate'] = now()->format('Y-m-d');
        $formField['balance'] = '0';
        $formField['bid'] = auth()->user()->branch;
        Courierpay::create($formField);
        // Assuming you have imported the necessary classes and namespaces

        // Find the record by ID or throw an exception if not found
        $inbox = Inboxing::findOrFail($id);
        // Update the record with the new data
        $inbox->update([
            'paystatus' => '1',
            'instatus' => '4',
            'delivdate' => now(),
        ]);

        $this->mailOutReport($inbox->mailtype);

        return back()->with('success', 'Mail  payement was  successful');
    }
}
