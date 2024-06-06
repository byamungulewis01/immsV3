<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UccdDpoTransanction extends Model
{
    use HasFactory;
    protected $fillable = ['trans_token', 'trans_ref', 'phone','meter_number','status','amount'];

}
