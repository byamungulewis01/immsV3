<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carneroute extends Model
{
    use HasFactory;
    protected $table = 'carneroute';
    protected $fillable = ['km_in', 'plate_number','destination','car_name','dateTimeOut',
    'datetimeIn',
    'car_type',
    'userId',
    'date','km_out'];
    protected $hidden = [
        
    ];
}
