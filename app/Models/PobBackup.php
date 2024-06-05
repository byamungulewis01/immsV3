<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PobBackup extends Model
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
        'pob_category',
        'serviceType',
        'pob_type',
        'amount',
        'year',
        'available',
        'profile',
        'visible',
        'homeAddress',
        'homePhone',
        'homeLocation',
        'officeAddress',
        'officePhone',
        'officeLocation',
    ];
}
