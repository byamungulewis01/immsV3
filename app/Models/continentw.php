<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class continentw extends Model
{
    use HasFactory;
    protected $table = 'continentw';
    protected $primaryKey = 'cont_id';
    protected $fillable = [
        'cont_id',
        'Continent',
        'Country',
        'countsh'
    ];
}
