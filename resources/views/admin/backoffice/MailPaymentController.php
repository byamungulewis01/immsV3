<?php

namespace App\Http\Controllers\Eric\Backoffice;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Models\Eric\Courierpay;
use App\Http\Controllers\Controller;

class MailPaymentController extends Controller
{
    public function index()
    {
        $inboxings = Inboxing::where('location',auth()->user()->branch)->orderBy('id', 'desc')
        ->where('mailtype','o')->where('paystatus','0')->where('instatus','3')
        ->get();
        return view('admin.backoffice.omailpay', compact('inboxings'));
    }
    public function store(Request $request,$id)
    {
        $formField = $request->validate([
            'amount' => 'required',
            'extra' => 'required',
            'ptype' => 'required',
            'reference' => '',
            'nidtype' => 'required',
            'nid' => 'required',
            'pknames' => 'required',
        ]);
        $formattedDate = Carbon::now()->format('Y-m-d');
         $formField['userid'] = auth()->user()->id;
         $formField['cid'] =$id;
         $formField['pdate'] =$formattedDate;
         $formField['balance'] ='0';
         $formField['bid'] = auth()->user()->branch;
         Courierpay::create($formField);
         Inboxing::findorfail($id)->update(['paystatus' => '1','instatus' => '4']);
        return back()->with('success', 'Mail  payement was  successful');
    }
}
