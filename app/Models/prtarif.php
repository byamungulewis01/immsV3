<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class prtarif extends Model
{
    use HasFactory;
    protected $table = 'prtarif';
    protected $primaryKey = 'prt_id';
    protected $fillable = ['prt_id','prw_id','pc_id'];
    
}
