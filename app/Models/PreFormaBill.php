<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PreFormaBill extends Model
{
    use HasFactory;
    protected $fillable = [
        'bill_number',
        'non_pay_years',
        'rental_amount',
        'total_amount',
        'box',
    ];

    public function pobBox()
    {
        return $this->belongsTo(Box::class,'box');
    }
}
