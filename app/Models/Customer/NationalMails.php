<?php

namespace App\Models\Customer;

use App\Models\User;
use App\Models\Customer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NationalMails extends Model
{
    use HasFactory;
    protected $fillable = [
        'dispatchNumber','customer_id','destination_id','status','created_at','updated_at',
        'refNumber','weight','price','observation','token','sentDate','deliveryDate','postAgent','dispatchDate'
    ];
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
    public function destination()
    {
        return $this->belongsTo(MyContacts::class);
    }
    public function agent()
    {
        return $this->belongsTo(User::class,'postAgent','id');
    }
    // user

}
