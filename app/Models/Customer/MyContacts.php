<?php

namespace App\Models\Customer;

use App\Models\Box;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MyContacts extends Model
{
    use HasFactory;
    protected $fillable = [
        'name','email','phone','address','customer_id','owner_id','address_type'
    ];

    // box
    public function box()
    {
        return $this->belongsTo(Box::class,'owner_id');
    }

}
