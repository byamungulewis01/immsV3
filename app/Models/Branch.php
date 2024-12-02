<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;
    protected $fillable = ['name', 'status',
        'company_fees',
        'individual_fees',
        'cotion_fees',
        'certificate_fees',
        'key_fees',
        'ingufuri_fees'];
    public static function Branch($value = [], $ret)
    {
        $return = [];

        if ($ret == '') {
            $return = Branch::where('status', 'active')->get()->toArray();
        } elseif ($ret == 'available') {
            $return = Branch::where('status', 'active')->get()->toArray();
        }
        return $return;
    }
}
