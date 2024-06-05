<?php

namespace App\Http\Controllers\Eric\Backoffice;

use App\Models\Box;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Models\Eric\Transfer;
use App\Models\Eric\Notification;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;

class MailRcsnController extends Controller
{
    public function index()
    {
        $results = Transfer::where('touserid', auth()->user()->branch)->where('status', '1')
            ->limit(1000)->orderBy('id', 'desc')->get();
        return view('admin.backoffice.mailrcsn', compact('results'));
    }
    public function index1($id)
    {
        $branches = Branch::where('id', auth()->user()->branch)->get();

        $boxes = Box::all();
        $inboxings = DB::table('inboxings')
            ->join('transferdatails', 'inboxings.id', '=', 'transferdatails.inid')
            ->where('inboxings.instatus', '=', '2')
            ->where('transferdatails.trid', decrypt($id))
            ->select('inboxings.id as inbox_id','inboxings.*')
            ->get();

        return view('admin.backoffice.rcsnotification', compact('inboxings', 'boxes', 'id', 'branches'));
    }
    public function update(Request $request, $id)
    {

        Transfer::findorfail($id)->update(['status' => '2']);

        return back()->with('success', 'Thank you to close dsp on time successful');
    }
    public function notify(Request $request, $id)
    {
        $request->validate([
            'weight' => 'numeric|required',
            // Add other validation rules for other fields if needed
        ]);
        Inboxing::findorfail($id)->update([
            'notification' => '1',
            'instatus' => '3',
            'akabati' => $request->akabati,
            'notdate' => now(),
        ]);
        Notification::create([
            'userid' => auth()->user()->id,
            'bid' => auth()->user()->branch,
            'akabati' => $request->akabati,
            'phone' => $request->phone,
            'cid' => $request->id,
            'mailtype' => $request->mailtype,
            'weight' => $request->weight,
        ]);
        $receiver = '+25' . $request->phone;
        if ($request->mailtype == 'r') {
            $gu = 6;
        } elseif ($request->mailtyp == 'o') {
            $gu = 8;
        } else {
            $gu = 8;
        }
        $phone = auth()->user()->phone;

        $message = "IPOSITA $request->location BRANCH informs you that you have an item to pick at Guichet:$gu code:$request->innumber-$request->akabati If you need home delivery service,please call this number $phone";
        (new NotificationController)->send_sms($receiver, $message);
        // $curl = curl_init();
        // curl_setopt_array($curl, array(
        //     CURLOPT_URL => 'https://api.mista.io/sms',
        //     CURLOPT_RETURNTRANSFER => true,
        //     CURLOPT_ENCODING => '',
        //     CURLOPT_MAXREDIRS => 10,
        //     CURLOPT_TIMEOUT => 0,
        //     CURLOPT_FOLLOWLOCATION => true,
        //     CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        //     CURLOPT_CUSTOMREQUEST => 'POST',
        //     CURLOPT_POSTFIELDS => array('to' => $receiver, 'from' => 'IPOSITA', 'unicode' => '0', 'sms' => $message, 'action' => 'send-sms'),
        //     CURLOPT_HTTPHEADER => array(
        //             'x-api-key:bkVxc3FQQmVtbEJhREtrY25DZW0=',
        //         ),
        // )
        // );

        // $response = curl_exec($curl);

        // curl_close($curl);
        return back()->with('success', 'Notification sent Success');
    }
}
