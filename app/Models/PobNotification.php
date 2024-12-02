<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PobNotification extends Model
{
    use HasFactory;
    protected $fillable = [
        'rent_year',
        'type',
        'status',
        'pob',
        'name',
        'phone',
    ];

}
