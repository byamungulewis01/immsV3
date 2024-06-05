<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calibration extends Model
{
    use HasFactory;
    protected $table = 'calibrations';
    protected $fillable = ['liters', 'plate_number','milleage','car_name',
    'car_type',
    'userId',
    'date',];
}
