<?php

namespace App\Http\Controllers\Customer;

use App\Models\Box;
use App\Models\Branch;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CustomerDashController extends Controller
{
    //
    public function index()
    {
        return view('customer.index');
    }
 
}
