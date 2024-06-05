<?php

namespace App\Models\Driver;

use App\Models\Vehicle;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Calibiration extends Model
{
    use HasFactory;
    // fillable
    protected $fillable = [
        'vehicle_id',
        'litres',
        'milage',
    ];
    public function vehicles()
    {
        return $this->belongsTo(Vehicle::class, 'vehicle_id', 'id');
    }
}
