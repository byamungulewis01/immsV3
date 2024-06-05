<?php

namespace App\Models\Customer;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CustomerDispatch extends Model
{
    use HasFactory;
    protected $fillable = [
        'dispatchNumber','senderName','senderPhone','senderPOBox','mailsNumber','weight',
        'price','observation','securityCode','sentDate','deliveryDate','customer_id','postAgent','status'
    ];
    public function agent()
    {
        return $this->belongsTo(User::class,'postAgent','id');
    }
    // pobox where box is = to the senderPOBox



}
