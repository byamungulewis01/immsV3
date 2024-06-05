<?php

namespace App\Http\Controllers\Eric\Tarifss;

use App\Models\zone;
use App\Models\czone;
use App\Models\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EmsCountryZoneRegcontroller extends Controller
{
    public function index()
    {
        $zones = zone::orderBy('zone_id','DESC')->get();
        return view('admin.tarifs.EMS.zoneregistration', compact('zones'));
    }
    public function viewcountryzone($zone_id)
    {
        $countries = DB::table('czone')
        ->join('country', 'country.c_id', '=', 'czone.c_id')
        ->join('zone', 'zone.zone_id', '=', 'czone.zone_id')
        ->select('country.countryname', 'country.countsh', 'country.code', 'zone.zonename', 'zone.zone_id'
        , 'country.c_id','czone.cz_id')
        ->where('czone.zone_id',$zone_id)
        ->orderBy('cz_id', 'desc')
        ->get();
        $results = Country::all();
        $zonecounts = zone::where('zone_id',$zone_id)->get();
        return view('admin.tarifs.EMS.viewcountryizone', compact('countries','results','zone_id','zonecounts'));
    }

    public function store(Request $request)
    {
        $formField = $request->validate([
            'zonename' => 'required',

        ]);
        $inbox = zone::create($formField);
        return back()->with('success', 'Zone Registration Successfully');
    }
    public function storeczone(Request $request)
    {
        $formField = $request->validate([
            'zone_id' => 'required',
            'c_id' => 'required',

        ]);
        $czone = czone::where('c_id',$request->c_id)->count();
        if($czone == 0){
            $inbox = czone::create($formField);
            return back()->with('success', 'Country In zone Registration Successfully');
        }
        else{
            return back()->with('warning', 'This Country Is already have Zone');
        }

    }
    public function update(Request $request, $zone_id)
    {
        $formField = $request->validate([
            'zonename' => 'required',
        ]);
        zone::findorfail($zone_id)->update($formField);
        return back()->with('success', 'Zone Updated Successfully');
    }
    public function destroy($zone_id)
    {
        zone::findorfail($zone_id)->delete();
        return back()->with('success', 'Deleted Successfully');
    }
    public function destroy1($cz_id)
    {
        czone::findorfail($cz_id)->delete();
        return back()->with('success', 'Deleted Successfully');
    }
}
