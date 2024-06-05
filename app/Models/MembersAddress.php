<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MembersAddress extends Model
{
    use HasFactory;
    // fillable
    protected $fillable = [
        'name',
        'phone',
        'email',
        'photo',
        'post',
        'description',
        'visible',
        'box_id',
    ];
}
