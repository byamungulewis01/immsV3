<?php

namespace App\Models\Driver;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class RouteCard extends Model
{
    use HasFactory;
    // fillable
    protected $fillable = [
        'vehicle_id',
        'km_in',
        'date_returned',
        'km_out',
        'destination',
    ];

    // vehicle relation
    public function vehicles()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
}
