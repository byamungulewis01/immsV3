<?php

namespace App\Models;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    use HasFactory;
    protected $fillable = [
        'name', 'plate_number', 'model', 'type', 'status', 'fuel_liters','driverid','status',
    ];
    public function drivername()
    {
        return $this->belongsTo(User::class,'driverid');
    }
}
