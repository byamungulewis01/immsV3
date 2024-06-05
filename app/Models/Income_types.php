<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income_types extends Model
{
    use HasFactory;
    protected $table = 'income_types';
    protected $primaryKey = 'et_id';
    protected $fillable = [
        'et_name',
    ];
}
