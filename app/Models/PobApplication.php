<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PobApplication extends Model
{
    use HasFactory;
    #table
    protected $table = 'applications';
    protected $fillable = [
        'pob',
        'branch_id',
        'status',
        'name',
        'phone',
        'email',
        'pob_category',
        'serviceType',
        'pob_type',
        'amount',
        'year',
        'attachment',
        'is_new_customer',
        'aprooved',
        'customer_id',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

}
