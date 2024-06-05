<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class single_country_tarif extends Model
{
    use HasFactory;
    protected $table = 'single_country_tarif';
    public static function single_country_tarif($value = 0, $ret = '')
    {
        $return = [];

        if ($ret == '') {
            $query = DB::table('single_country_tarif')
                ->groupBy('countries')
                ->get();

            if ($query->count() > 0) {
                $return = $query->toArray();
            }
        }

        return $return;
    }

}
