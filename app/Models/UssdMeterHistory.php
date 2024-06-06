<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UssdMeterHistory extends Model
{
    use HasFactory;
    protected $fillable = ['phone', 'meter_number', 'meter_name',];
}
