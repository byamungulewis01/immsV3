<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UccdElectricityTransanction extends Model
{
    use HasFactory;
    protected $fillable = [
        'customer_name',
        'customer_phone',
        'reference_number',
        'amount',
        'token',
        'token_p31',
        'token_p32',
        'units',
        'external_transaction_id',
        'residential_rate',
        'units_rate',
        'request_id',
        'eucl_status',
        'electricity',
        'tva',
        'fees',
        'date_from_eucl',
    ];
}
