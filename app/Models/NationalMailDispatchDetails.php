<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Customer\CustomerDispatchDetails;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class NationalMailDispatchDetails extends Model
{
    use HasFactory;
    // fillable
    protected $fillable = [
        'dispatch',
        'customerMail',
        'status',
        'dateReceived',
        'weight',
        'price',
        'customer_id',
    ];

    // belongs to customer dispatch details
    public function details()
    {
        return $this->belongsTo(CustomerDispatchDetails::class, 'customerMail', 'id');
    }

}
