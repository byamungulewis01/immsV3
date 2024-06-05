<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Country extends Model
{
    use HasFactory;
    protected $table = 'country';
    protected $primaryKey = 'c_id';
    protected $fillable = ['countryname','countsh','code'];
    public static function country_tarif($value = 0, $ret = '')
    {
        if ($ret == '') {
            $return = array();

            $return = Country::selectRaw("
                    country.c_id,
                    MAX(country.countryname) AS countryname,
                    MAX(country.countsh) AS countsh,
                    MAX(country.code) AS code,
                    MAX(tarifs.tarif_id)
                ")
                ->join('czone', 'country.c_id', '=', 'czone.c_id')
                ->join('tarifs', 'czone.zone_id', '=', 'tarifs.zone_id')
                ->where('tarifs.servty_id', 1)
                ->groupBy('country.c_id')
                ->orderBy('country.countryname', 'asc')
                ->get()
                ->toArray();
        }else{
            $return = array();

            $return = Country::selectRaw("
                    country.c_id,
                    MAX(country.countryname) AS countryname,
                    MAX(country.countsh) AS countsh,
                    MAX(country.code) AS code,
                    MAX(tarifs.tarif_id)
                ")
                ->join('czone', 'country.c_id', '=', 'czone.c_id')
                ->join('tarifs', 'czone.zone_id', '=', 'tarifs.zone_id')
                ->where('tarifs.servty_id', 1)
                ->where('country.countsh', $value)
                ->groupBy('country.c_id')
                ->orderBy('country.countryname', 'asc')
                ->get()->first()
                ->toArray();
        }
        return $return;
    }
    public static function continent_tarif($value = 0, $ret = '')
    {
        $return = [];
        if ($ret == '') {
            $countries = continentw::selectRaw("
            MAX(continentw.Country) AS countryname,
            MAX(continentw.Country) AS countsh,
            MAX(continentw.Country) AS code,
            MAX(ptarifcontinet.pcon_id) AS pcon_id")
                ->join('ptarifcontinet', 'continentw.Continent', '=', \DB::raw('ptarifcontinet.cont_id'))
                ->where('ptarifcontinet.servty_id', '=', 2)
                ->groupBy('continentw.Country')
                ->orderBy('continentw.Country', 'asc')
                ->get();

            $return = $countries->toArray();
        }else{
            $countries = continentw::selectRaw("
            MAX(continentw.Country) AS countryname,
            MAX(continentw.Country) AS countsh,
            MAX(continentw.Country) AS code,
            MAX(ptarifcontinet.pcon_id) AS pcon_id")
                ->join('ptarifcontinet', 'continentw.Continent', '=', \DB::raw('ptarifcontinet.cont_id'))
                ->where('ptarifcontinet.servty_id', '=', 2)
                ->where('continentw.Country', '=',"'".addslashes($value)."'")
                ->groupBy('continentw.Country')
                ->orderBy('continentw.Country', 'asc')
                ->get()->first();
            // if (isa) {
            //     # code...
            // }
            $return = $countries->toArray();
        }
        return $return;
    }

}
