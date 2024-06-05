<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class czone extends Model
{
    use HasFactory;
    protected $table = "czone";
    protected $primaryKey = "cz_id";
    protected $fillable = [
        'zone_id',
        'c_id'
    ];
}
