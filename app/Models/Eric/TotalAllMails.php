<?php

namespace App\Models\Eric;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TotalAllMails extends Model
{
    use HasFactory;
    protected $fillable = [
        'omt','rmt','pmt','emst','rlt','olt',
    ];
}
