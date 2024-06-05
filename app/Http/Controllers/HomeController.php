<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
    {
        return view('home.index');
    }
   
    public function customer_login()
    {
        return view('home.login');
    }
    public function register()
    {
        return view('home.register');
    }

}
