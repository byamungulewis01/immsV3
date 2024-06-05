<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prweight extends Model
{
    use HasFactory;
    protected $table = 'prweight';
    protected $primaryKey = 'prw_id';
    protected $fillable = [
        'prw_id',
        'type',
        'weight'
    ];
}
