<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status'];
    public static function Branch($value = [], $ret)
    {
        $return = [];

        if ($ret == '') {
            $return = Branch::where('status','active')

                ->get()
                ->toArray();
        } elseif ($ret == 'available') {
            $return = Branch::where('status','active')
                ->get()
                ->toArray();
        }
        return $return;
    }
}
