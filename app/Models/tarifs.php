<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class tarifs extends Model
{
    use HasFactory;
    protected $table = 'tarifs';
    protected $primaryKey = 'tarif_id';
    protected $fillable = [
        'maxweight',
        'minweight',
        'servty_id',
        'zone_id',
        'type'
    ];
}
