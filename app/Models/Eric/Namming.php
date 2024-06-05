<?php

namespace App\Models\Eric;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Namming extends Model
{
    use HasFactory;
    protected $fillable = [
        'type', 'number'
    ];
}
