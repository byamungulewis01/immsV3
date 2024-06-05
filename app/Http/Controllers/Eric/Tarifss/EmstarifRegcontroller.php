<?php

namespace App\Http\Controllers\Eric\Tarifss;

use App\Models\zone;
use App\Models\tarifs;
use App\Models\Eric\Range;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class EmstarifRegcontroller extends Controller
{
    public function index()
    {
        // $ranges = DB::table('pranges')->orderBy('id', 'desc')->get();

        $czones = DB::table('zone')->get();
        $servs = DB::table('servicetype')->where('shortname', 'EMS')->get();
        return view('admin.tarifs.EMS.emstarifreg', compact('czones', 'servs'));
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'maxweight' => 'required|numeric',
            'minweight' => 'required|numeric',

        ]);
        if ($request->minweight >= $request->maxweight) {
            return back()->with('warning', 'Not Inserted becouse minweight is higher than max weight');

        } else {
            $inbox = Range::create($formField);
            return back()->with('success', 'Weight Range Registration Successfully');
        }

    }
    public function update(Request $request, $id)
    {
        $formField = $request->validate([
            'maxweight' => 'required|numeric',
            'minweight' => 'required|numeric',
        ]);
        Range::findorfail($id)->update($formField);
        return back()->with('success', 'Weight Range Updated Successfully');
    }
    public function updatetar(Request $request, $tarif_id)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',

        ]);
        //store date in Category table
        $category = tarifs::findorfail($tarif_id);
        $category->amount = $request->amount;
        $category->save();
       return back()->with('success', 'Weight Range Updated Successfully');
    }

    public function CzTarifController($zone_id, $servty_id)
    {

        $sets = DB::table('tarifs')
        ->where('servty_id', $servty_id)
        ->where('zone_id', $zone_id)
        ->orderBy('tarif_id','DESC')
        ->get();

        $zones = zone::where('zone_id', $zone_id)->get();
        $results = Range::all();

        return view('admin.tarifs.EMS.emssettarif', compact('sets', 'zone_id', 'servty_id','zones','results'));
    }
    public function storetarif(Request $request)
    {
        $formField = $request->validate([
            'amount' => 'required|numeric',
        ]);
        $range_array = explode(',', $request->range);
        $minweight = $range_array[0];
        $maxweight = $range_array[1];
        $select_chech = DB::table('tarifs')
            ->where('maxweight', $maxweight)
            ->where('minweight', $minweight)
            ->where('zone_id', $request->zone_id)
            ->where('servty_id', $request->servty_id)
            ->get();

        if ($select_chech->count() > 0) {

            return back()->with('warning', 'Weight Range is already Exists in zone And Tarifs');

        } elseif ($select_chech->count() == 0) {
            $inbox = DB::table('tarifs')->insert([
                'zone_id' => $request->zone_id,
                'maxweight' => $maxweight,
                'minweight' => $minweight,
                'servty_id' => $request->servty_id,
                'amount' => $request->amount,
                'type' => $request->type,
                'status' => $request->status
            ]);

            if ($inbox) {

                return back()->with('success', ' Tarif is inserted');

            } else {

                return back()->with('success', ' Something went wrong. Tarif not inserted.');

            }
        }

    }

    // delete tari

}
