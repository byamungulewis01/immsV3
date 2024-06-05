<?php

namespace App\Models\Eric;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $fillable = [
         'userid', 'phone','weight','instatus','mailtype','bid',
        'smsnotication', 'cid','phone',


    ];
}
