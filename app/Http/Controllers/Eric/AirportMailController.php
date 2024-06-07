<?php

namespace App\Http\Controllers\Eric;

use Carbon\Carbon;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Eric\AirportDispach;
use App\Http\Controllers\Controller;
class AirportMailController extends Controller
{
    public function index()
    {
        $inboxings = AirportDispach::where('status', 0)->where('cntp_id',auth()->user()->id)->orderBy('id', 'desc')->get();
        return view('admin.airport.airportdispach', compact('inboxings'));
    }
    public function index1()
    {
        $inboxings = AirportDispach::where('status', '1')->where('cntp_id',auth()->user()->id)->orderBy('id', 'desc')->get();
        return view('admin.airport.driverdispach', compact('inboxings'));
    }
    public function index2()
    {
        $inboxings = AirportDispach::wherein('airport_dispaches.status', [0, 1, 2,3])->where('cntp_id',auth()->user()->id)->orderBy('id', 'desc')->get();
        return view('admin.airport.mailarrived', compact('inboxings'));
    }
    public function dispachApi()
    {
        $inboxings = DB::table('airport_dispaches')
            ->join('users', 'airport_dispaches.postAgent', '=', 'users.id')
            ->select('airport_dispaches.*', 'users.name')->where('airport_dispaches.status', 3)->orderBy('airport_dispaches.id', 'desc')->get();
        return response()->json([
            'data' => $inboxings,
            'status' => 200,
        ]);
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'orgincountry' => 'required',
            'comment' => 'required',
            'grossweight' => 'required',
            'mailweight' => 'nullable',
            'dispatchNumber' => 'required|unique:airport_dispaches',
            'currentweight' => 'required',
            'dispachetype' => 'required',
            'numberitem' => 'required',

        ]);

        $formField['cntp_id'] = auth()->user()->id;
        $inbox = AirportDispach::create($formField);
        return to_route('admin.inbox.AirportDispach')->with('success', 'Dispatch Registration Successfully');
    }
    public function update(Request $request)
    {
         $request->validate([
            'dispatchid' => 'required',
        ]);
        foreach ($request->dispatchid as $value) {
            AirportDispach::findorfail($value)->update(['status' => '1','transfer_date'=> now()]);
        }

        return to_route('admin.inbox.AirportDispach')->with('success', 'Dispatch transfered successfully');
    }
    public function updateDispatch(Request $request, $id)
    {
        $formField = $request->validate([
            'orgincountry' => 'required',
            'comment' => 'required',
            'grossweight' => 'required|numeric|',
            'mailweight' => '',
            'dispatchNumber' => 'required|unique:airport_dispaches,dispatchNumber,' . $id,
            'currentweight' => 'required|numeric|',
            'dispachetype' => 'required',
            'numberitem' => 'required|numeric|',
        ]);
        AirportDispach::findOrFail($id)->update($formField);
        return back()->with('success', 'Dispatch Updated Successfully');
    }

    public function report()
    {
        $reps = DB::table('airport_dispaches')
        ->select(DB::raw('MONTH(created_at) as month'), DB::raw('SUM(currentweight) as weight'), DB::raw('count(*) as total'))
        ->groupBy(DB::raw('MONTH(created_at)'))
        ->orderBy('month', 'DESC')
        ->limit(100)
        // ->where('cntp_id',auth()->user()->id)
        ->get();
         return view('admin.airport.monthlyreport', compact('reps'));
    }
    public function airportmonthly($month)
    {
        $currentDateTime = Carbon::now();
        $date = decrypt($month);
        $inboxings = DB::table('airport_dispaches')
            ->select('*',DB::raw('MONTH(created_at) as month'),
            DB::raw('(SELECT countryname FROM country WHERE c_id = orgincountry LIMIT 1) as countryname'),
            )
            ->whereMonth('created_at', $date)
            ->get();
        $pdf = PDF::loadView('admin.airport.detailmonthairport', compact('date', 'inboxings','currentDateTime'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('MonthlyAirportreport.pdf');
    }
    public function airportdaily($date)
    {
        $currentDateTime = Carbon::now();
        $date = decrypt($date);
        $inboxings = DB::table('airport_dispaches')
            ->select('*',DB::raw('DATE(created_at) as date'))
            ->whereDate('created_at', $date)
            ->get();

        $pdf = PDF::loadView('admin.airport.detailsdaily', compact('date', 'inboxings','currentDateTime'))
            ->setPaper('a4', 'portrait');
        return $pdf->stream('DailyAirportreport.pdf');
    }

       public function reportd()
    {
        $reps = DB::table('airport_dispaches')
        ->select(DB::raw('DATE(created_at) as date'), DB::raw('SUM(currentweight) as weight'), DB::raw('count(*) as total'))
        ->groupBy('date')
        ->orderBy('date', 'DESC')
        ->limit(20)
        ->get();

        return view('admin.airport.dailyreport', compact('reps'));
    }
       public function reportd_orgin()
    {
        $date = request('date');
        $reps = AirportDispach::whereDate('created_at',$date)
        ->orderBy('created_at', 'DESC')
        ->limit(100)
        ->get();

        return view('admin.airport.dailyreport_orgin', compact('reps'));
    }

}
