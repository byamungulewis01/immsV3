<?php

namespace App\Models\Eric;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Prange extends Model
{
    use HasFactory;
    protected $fillable = [
        'maxweight', 'minweight','status',

   ];
}
