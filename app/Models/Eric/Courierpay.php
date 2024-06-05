<?php

namespace App\Models\Eric;

use App\Models\Eric\Inboxing;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Courierpay extends Model
{
    use HasFactory;
    protected $fillable = [
        'cid', 'ptype', 'amount', 'extra', 'balance', 'nidtype',
        'nid', 'pknames', 'comment','bid', 'reference', 'return_status',
        'userid', 'pdate',

    ];
    public function detailsin()
    {
        return $this->belongsTo(Inboxing::class,'cid');
    }

}
