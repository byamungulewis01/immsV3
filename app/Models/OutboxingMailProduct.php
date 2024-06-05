<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutboxingMailProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'outboxing_id',
        'post_card_id',
        'branch_id',
        'item_id',
        'quantity',
        'price',
        'amount',
    ];
    public function outboxing()
    {
        return $this->belongsTo(OutboxingMail::class, 'outboxing_id');
    }
   
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'item_id');
    }
}
