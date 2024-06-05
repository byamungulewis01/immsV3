<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class temble_items extends Model
{
    use HasFactory;
    protected $table = 'temble_items';
    protected $fillable = [
        'out_id',
        'item_id',
        'quantity',
    ];
}
