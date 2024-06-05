<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prcountries extends Model
{
    use HasFactory;
    protected $table = 'prcountries';
    protected $primaryKey = 'pc_id';
    protected $fillable = ['countries'];
    
}
