<?php

namespace App\Http\Controllers;

use App\Models\Box;
use Illuminate\Http\Request;
use App\Models\Eric\Inboxing;
use Barryvdh\DomPDF\Facade\Pdf;

class HomeController extends Controller
{
    protected $hashids;
    public function __construct()
    {
        $this->hashids = new \Hashids\Hashids(env('HASHIDS_SALT'), 8); // minimum length of 8 characters

    }
    public function index()
    {

        return view('home.index');
    }
    public function inboxings_mails($mail)
    {

        $decoded = $this->hashids->decode($mail);

        $inboxings = Inboxing::where('pob', $decoded[0])->where('instatus', '4')->get();
        return view('home.inboxing-mails',compact('inboxings'));
    }

    public function customer_login()
    {
        return view('home.login');
    }
    public function register()
    {
        return view('home.register');
    }
    public function certificate($id)
    {
        $decoded = $this->hashids->decode($id);
        $box = Box::findorfail($decoded);

        $pdf = Pdf::loadView('admin.physicalpob.certificate', compact('box'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('certificate.pdf');
    }

}
