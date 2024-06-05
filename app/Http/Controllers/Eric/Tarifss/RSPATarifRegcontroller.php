<?php

namespace App\Http\Controllers\Eric\Tarifss;

use App\Models\continentw;
use App\Models\Eric\Range;
use App\Models\Eric\Prange;
use Illuminate\Http\Request;
use App\Models\ptarifcontinet;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class RSPATarifRegcontroller extends Controller
{
    public function index()
    {
        $czones = continentw::groupBy('Continent')
            ->select('Continent', DB::raw('MAX(cont_id) as cont_id'))
            ->get();
        $servs = DB::table('servicetype')->where('shortname', 'RSPA')->get();
        return view('admin.tarifs.RSPA.rspatarifreg', compact('czones', 'servs'));
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
    public function RspaTarifController($cont_id, $servty_id)
    {

        $sets = DB::table('ptarifcontinet')
            ->where('servty_id', $servty_id)
            ->where('cont_id', $cont_id)
            ->orderBy('pcon_id', 'DESC')
            ->get();

        $zones = continentw::where('Continent', $cont_id)
        ->groupBy('Continent')
            ->select('Continent', DB::raw('MAX(cont_id) as cont_id'))
        ->get();
        $results = Prange::all();

        return view('admin.tarifs.RSPA.rspasettarif', compact('sets', 'cont_id', 'servty_id', 'zones', 'results'));
    }
    public function updatetar(Request $request, $tarif_id)
    {
        $this->validate($request, [
            'amount' => 'required|numeric',

        ]);
        //store date in Category table
        $category = ptarifcontinet::findorfail($tarif_id);
        $category->amount = $request->amount;
        $category->save();
       return back()->with('success', 'Weight Range Updated Successfully');
    }
    public function storetarifp(Request $request)
    {
        $formField = $request->validate([
            'amount' => 'required|numeric',
        ]);
        $range_array = explode(',', $request->range);
        $minweight = $range_array[0];
        $maxweight = $range_array[1];
        $select_chech = DB::table('ptarifcontinet')
            ->where('maxweight', $maxweight)
            ->where('minweight', $minweight)
            ->where('cont_id', $request->cont_id)
            ->where('servty_id', $request->servty_id)
            ->get();

        if ($select_chech->count() > 0) {

            return back()->with('warning', 'Weight Range is already Exists');

        } elseif ($select_chech->count() == 0) {
            $inbox = DB::table('ptarifcontinet')->insert([
                'cont_id' => $request->cont_id,
                'maxweight' => $maxweight,
                'minweight' => $minweight,
                'servty_id' => $request->servty_id,
                'amount' => $request->amount,
                'type' => $request->type,

            ]);

            if ($inbox) {

                return back()->with('success', ' Tarif is inserted');

            } else {

                return back()->with('success', ' Something went wrong. Tarif not inserted.');

            }
        }

    }

}
