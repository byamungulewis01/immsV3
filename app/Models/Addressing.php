<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Addressing extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'phone',
        'email',
        'pob',
        'customer_type',
        'address',
        'photo',
        'website',
        'description',
        'longitude',
        'latitude',
        'visible',
        'customer_id',
        'index',
    ];
}
