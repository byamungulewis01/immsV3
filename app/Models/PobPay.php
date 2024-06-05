<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PobPay extends Model
{
    use HasFactory;
    // fillable
    protected $fillable = [
        'box_id',
        'amount',
        'year',
        'payment_type',
        'payment_model',
        'serviceType',
        'branch_id',
        'payment_ref',
        'serviceType',
        'bid',
    ];

    // function to get the box
    public function box()
    {
        return $this->belongsTo(Box::class);
    }
}
