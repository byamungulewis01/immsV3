<?php

namespace App\Http\Controllers\Eric\Tarifss;

use App\Models\prtarif;
use App\Models\prweight;
use App\Models\prcountries;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class PercelTarifRegController extends Controller
{
    public function index()
    {
        $czones = prcountries::orderBy('pc_id', 'desc')->get();
        $servs = DB::table('servicetype')->where('shortname', 'PERCEL')->get();
        return view('admin.tarifs.PERCEL.perceltarifreg', compact('czones', 'servs'));
    }
    public function PercelTarifController($pc_id, $servty_id)
    {

        $sets = DB::table('prtarif')
        ->join('prweight', function ($join) {
            $join->on('prtarif.prw_id', '=', 'prweight.prw_id');


        })
        ->select('prtarif.*', 'prweight.weight')
        ->where('pc_id', $pc_id)
        ->get();

        $zones = prcountries::where('pc_id', $pc_id)
        ->groupBy('countries')
            ->select('countries', DB::raw('MAX(pc_id) as pc_id'))
        ->get();
        $results =prweight::all();

        return view('admin.tarifs.PERCEL.percelsettarif', compact('sets', 'pc_id', 'servty_id', 'zones', 'results'));
    }
    public function update(Request $request, $prt_id )
    {
        $this->validate($request, [
            'amount' => 'required|numeric',

        ]);
        //store date in Category table
        $category = prtarif::findorfail($prt_id );
        $category->amount = $request->amount;
        $category->save();
       return back()->with('success', 'Weight  Updated Successfully');
    }
    public function store(Request $request)
    {
        $formField = $request->validate([
            'amount' => 'required|numeric',
        ]);

        $select_chech = DB::table('prtarif')
            ->where('prw_id', $request->prw_id)
            ->where('pc_id', $request->pc_id)
            ->get();

        if ($select_chech->count() > 0) {

            return back()->with('warning', 'Weight is already Exists');

        } elseif ($select_chech->count() == 0) {
            $inbox = DB::table('prtarif')->insert([
                'pc_id' => $request->pc_id,
                'prw_id' => $request->prw_id,
                'amount' => $request->amount,
            ]);

            if ($inbox) {

                return back()->with('success', ' Tarif is inserted');

            } else {

                return back()->with('success', ' Something went wrong. Tarif not inserted.');

            }
        }

    }

}
