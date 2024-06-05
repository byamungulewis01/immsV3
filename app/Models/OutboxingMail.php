<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutboxingMail extends Model
{
    use HasFactory;
    protected $fillable = [
        'tracking', 'snames', 'sphone', 'semail',
        'snid', 'district', 'rnames', 'rphone', 'remail',
        'raddress',
        'type',
        'note',
        'user_id',
        'status',
        'branch_id',
        'recdate',
        'tradate',
        'country',
        'weight',
        'postage',
        'unit',
        'amount',
        'tax',
    ];
    // public function weight()
    // {
    //     return OutboxingMailProduct::where('outboxing_id', $this->id)->sum('weight');
    // }
    public function destiny()
    {
        return $this->belongsTo(Country::class, 'country', 'c_id');
    }
    public function products()
    {
        return $this->hasMany(OutboxingMailProduct::class,'outboxing_id');
    }
}
