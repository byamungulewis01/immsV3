<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class servicetype extends Model
{
    use HasFactory;
    protected $table = 'servicetype';
    protected $primaryKey = 'servty_id';
    protected $fillable = [
        'shortname',
        'description',
    ];
}
