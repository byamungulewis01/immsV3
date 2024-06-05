<?php

namespace App\Models;

use App\Models\Eric\Inboxing;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeDelivery extends Model
{
    use HasFactory;
    protected $fillable = [
      'customer_id', 'pob', 'addressOfDelivery', 'inboxing', 'box_id', 'status','expectedDateOfDelivery'
      ,'amount' , 'paymentMethod' ,'paymentReference' ,'postAgent' , 'code' ,'deliveryDate'
    ];

    public function box()
    {
        return $this->belongsTo(Box::class);
    }
    public function curier()
    {
        return $this->belongsTo(Inboxing::class, 'inboxing');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'postAgent');
    }
}
