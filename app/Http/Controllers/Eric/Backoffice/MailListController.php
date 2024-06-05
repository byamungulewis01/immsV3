<?php

namespace App\Http\Controllers\Eric\Backoffice;

use App\Models\Branch;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Models\Eric\Notification;
use App\Http\Controllers\Controller;
use App\Http\Controllers\NotificationController;

class MailListController extends Controller
{

    public function all(Request $request)
    {

        $query = $request->input('query');

        if ($query)
        {
            try {
                $inboxings = Inboxing::where('bid',auth()->user()->branch)->where(function ($queryBuilder) use ($query) {
                    $queryBuilder->where('inname', 'like', '%' . $query . '%')
                        ->orWhere('intracking', 'like', '%' . $query . '%')
                        ->orWhere('innumber', 'like', '%' . $query . '%')
                        ->orWhere('phone', 'like', '%' . $query . '%')
                        ->orWhere('created_at', 'like', '%' . $query . '%');
                })->get();
            } catch (\Throwable $th) {
                return back()->with('warning', 'Something went wrong');
            }
        }else{
            $inboxings = null;
        }
        return view('admin.backoffice.maillist', compact('inboxings'));
    }


    public function notify(Request $request, $id)
    {
        $request->validate([
            'weight' => 'numeric|required',
        ]);


        Inboxing::findorfail($id)->update([
            'akabati' => $request->akabati,
            'renotify_date' => now(),
        ]);

        Notification::create([
            'userid' => auth()->user()->id,
            'bid' => auth()->user()->branch,
            'akabati' => $request->akabati,
            'phone' => $request->phone,
            'cid' => $id,
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
        $branch = Branch::where('id', auth()->user()->branch)->first()->name;

        $message = "IPOSITA $branch BRANCH informs you that you have an item to pick at Guichet:$gu code:$request->innumber-$request->akabati If you need home delivery service,please call this number $phone";

        (new NotificationController)->send_sms($receiver, $message);

        return to_route('admin.list.search')->with('success', 'Notification sent Success');
    }



}
