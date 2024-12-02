<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    use HasFactory;

    protected $fillable = [
        'pob',
        'branch_id',
        'size',
        'status',
        'name',
        'email',
        'phone',
        'available',
        'date',
        'box_category_id',
        'serviceType',
        'pob_type',
        'amount',
        'year',
        'attachment',
        'customer_id',
        'aprooved',
        'booked',
        'cotion',
        'hasAddress',
        'profile',
        'homeAddress',
        'homePhone',
        'homeEmail',
        'homeVisible',
        'homeLocation',
        'officeAddress',
        'officePhone',
        'officeLocation',
        'officeEmail',
        'officeVisible',
        'officeAddressCode',
        'homeAddressCode',
    ];

    public function homeDelivery()
    {
        return $this->hasMany(HomeDelivery::class, 'customer_id', 'customer_id');
    }


    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    public function category()
    {
        return $this->belongsTo(BoxCategory::class, 'box_category_id');
    }
}

