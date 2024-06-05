<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VirtualBox extends Model
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
        'pob_type',
        'amount',
        'year',
        'available',
        'attachment',
        'customer_id',
    ];
}
