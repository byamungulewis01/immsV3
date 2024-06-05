<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\continentw;
use App\Models\single_country_tarif;
use App\Models\zone;
use DB;
use Illuminate\Http\Request;

class TarifController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function zone()
    {
        //return to the view with the data
        $zones = zone::all();
        $all_tarifs = DB::table('tarifs')
            ->select('minweight', 'maxweight')
            ->groupBy('minweight', 'maxweight')
            ->orderBy('minweight', 'ASC')
            ->orderBy('maxweight', 'ASC')
            ->get();

        // return dd($all_tarifs);
        return view('admin.tarif.zone', compact('zones','all_tarifs'));
    }
    public function continent()
    {
        //return to the view with the data
        $continents = continentw::select("Continent")->groupBy("Continent")->orderBy('Continent', 'ASC')->get();
        $all_tarifs = DB::table('ptarifcontinet')
            ->select('minweight', 'maxweight')
            ->groupBy('minweight', 'maxweight')
            ->orderBy('minweight', 'ASC')
            ->orderBy('maxweight', 'ASC')
            ->get();

        // return dd($all_tarifs);
        return view('admin.tarif.continent', compact('continents','all_tarifs'));
    }
    public function country()
    {
        //return to the view with the data
        $countries = single_country_tarif::select("countries")->groupBy("countries")->orderBy('countries', 'ASC')->get();
        $weights = single_country_tarif::select("weight")->groupBy("weight")->orderBy('weight', 'ASC')->get();

        // return dd($all_tarifs);
        return view('admin.tarif.country', compact('countries','weights'));
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
