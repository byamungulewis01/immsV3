<?php

namespace App\Http\Controllers\Eric\Backoffice;

use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use App\Http\Controllers\Controller;

class MailListController extends Controller
{
    public function index()
    {
        $registered = Inboxing::where('instatus','0')->where('bid',auth()->user()->branch);
        $transfered = Inboxing::where('instatus','1')->where('bid',auth()->user()->branch);
        $notified = Inboxing::where('instatus','2')->where('bid',auth()->user()->branch);
        $available = Inboxing::where('instatus','3')->where('bid',auth()->user()->branch);
        $delived = Inboxing::where('instatus','4')->where('bid',auth()->user()->branch);

        // $inboxings = new Inboxing;//::where('location',auth()->user()->branch);

        return view('admin.backoffice.maillistsummary', compact('registered','transfered','notified','available','delived'));
    }
    public function all()
    {
        $inboxings = Inboxing::where('location',auth()->user()->branch);

        return view('admin.backoffice.maillist', compact('inboxings'));
    }
    public function detail($id)
    {
        $inboxings = Inboxing::where('location',auth()->user()->branch);
        $type = $id;
        return view('admin.backoffice.maillistdetail', compact('inboxings','type'));
    }
}
