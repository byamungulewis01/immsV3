<?php

namespace App\Http\Controllers\Eric;

use Illuminate\Http\Request;
use App\Models\Eric\TotalAllMails;
use App\Http\Controllers\Controller;

class MailsTotalController extends Controller
{
    public function index()
    {
        $totals = TotalAllMails::all();
        return view('admin.register.totalmails', compact('totals'));
    }
}
