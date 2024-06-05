<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VehicleHistory extends Model
{
    use HasFactory;
    protected $fillable = [
        'vehicle_id',
        'driver_id',
        'date_of_assignment',
        'date_of_return',
    ];
    public function vehicle()
    {
        return $this->belongsTo(Vehicle::class);
    }
    public function driver()
    {
        return $this->belongsTo(User::class);
    }
}
