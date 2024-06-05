<?php

namespace App\Models\Eric;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    use HasFactory;
    protected $fillable = [
        'office', 'amount', 'pdate', 'ddate', 'realamount', 'duserid',
        'rdate', 'userid','bid','dtime',

    ];
}
