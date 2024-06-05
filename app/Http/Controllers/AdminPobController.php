<?php

namespace App\Http\Controllers;

use App\Models\Box;
use App\Models\PobPay;
use Illuminate\Http\Request;
use App\Models\PobApplication;
use Illuminate\Support\Facades\DB;

class AdminPobController extends Controller
{
    public function index()
    {
        return view('admin.physicalPob.adminIndex');
    }
    // api for pob
    public function pobApi($id)
    {
        $boxes = Box::where('serviceType', 'PBox')
        ->orderBy('pob','asc')->get();
        return response()->json([
            'data' => $boxes,
            'status' => 200,
        ]);
    }
    public function approved()
    {
        $boxes = Box::where('aprooved', true)->where('serviceType', 'PBox')->orderBy('name')->limit(100)->get();
        return view('admin.physicalPob.approved', compact('boxes'));
    }
    #details
    public function waitingList()
    {
        //   $boxes = Box::where('branch_id', auth()->user()->branch_id)->get();
        $boxes = PobApplication::where('aprooved', false)->get();
        return view('admin.physicalPob.waitingList', compact('boxes'));
    }
    public function pobSelling()
    {
        $boxes = Box::where('serviceType', 'PBox')->where('available', true)->orderBy('pob')->get();
        return view('admin.physicalPob.selling', compact('boxes'));
    }
    public function dailyIncome()
    {
        $boxes = PobPay::where('serviceType', 'PBox')->select(DB::raw('SUM(amount) as cash'), DB::raw('DATE(created_at) as created_date'))->groupBy('created_date')
        ->orderBy('created_at', 'DESC')->limit(20)->get();

        return view('admin.physicalPob.dailyIncome', compact('boxes'));
    }

    public function monthlyIncome()
    {
        $boxes =  PobPay::where('pob_pays.serviceType', 'PBox')
        ->select(DB::raw('SUM(amount) as cash'),DB::raw('MONTH(created_at) as created_month'),DB::raw('YEAR(created_at) as created_year'))
        ->groupBy('created_month','created_year')->orderBy('created_year', 'DESC')->orderBy('created_month')->limit(20)->get();
        return view('admin.physicalPob.monthlyIncome', compact('boxes'));
    }
    public function pobCategory()
    {
         $boxes = Box::where('serviceType', 'PBox')->
         select('pob_category', DB::raw('count(*) as total'),
         DB::raw('count(CASE WHEN available = 0 THEN 1 ELSE NULL END) as totalrenew'),
         DB::raw('count(CASE WHEN available = 1 THEN 1 ELSE NULL END) as totalavailable'))->groupBy('pob_category')->get();
        return view('admin.physicalPob.pobCategory', compact('boxes'));
    }
    public function index_virtualPob()
    {
        $boxes = Box::where('serviceType', 'VBox')->orderBy('name')->get();
        return view('admin.virtualPob.index', compact('boxes'));
    }
    // api for pob
    public function pobApi_virtualPob($id)
    {
        $boxes = Box::where('serviceType', 'VBox')
        ->orderBy('pob','asc')->get();
        return response()->json([
            'data' => $boxes,
            'status' => 200,
        ]);
    }
    public function approved_virtualPob()
    {
        $boxes = Box::where('aprooved', true)->where('serviceType', 'VBox')->orderBy('name')->get();
        return view('admin.virtualPob.approved', compact('boxes'));
    }
    #details
    public function waitingList_virtualPob()
    {
        $boxes = Box::where('aprooved', false)->where('serviceType', 'VBox')->orderBy('name')->get();
        return view('admin.virtualPob.waitingList', compact('boxes'));
    }
    public function dailyIncome_virtualPob()
    {
        $boxes = PobPay::where('serviceType', 'VBox')->select(DB::raw('SUM(amount) as cash'), DB::raw('DATE(created_at) as created_date'))->groupBy('created_date')
        ->orderBy('created_at', 'DESC')->limit(20)->get();

        return view('admin.virtualPob.dailyIncome', compact('boxes'));
    }

    public function monthlyIncome_virtualPob()
    {
        $boxes =  PobPay::where('serviceType', 'VBox')
        ->select(DB::raw('SUM(amount) as cash'),DB::raw('MONTH(created_at) as created_month'),DB::raw('YEAR(created_at) as created_year'))
        ->groupBy('created_month','created_year')->orderBy('created_year', 'DESC')->orderBy('created_month')->limit(20)->get();
        return view('admin.virtualPob.monthlyIncome', compact('boxes'));
    }



}
