<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    //
    public function adminLogout()
    {
        auth()->logout();
        return view('auth.login');
    }
    #customer logout
    public function customerLogout()
    {
        auth()->guard('customer')->logout();
        return view('home.index');
    }
}
