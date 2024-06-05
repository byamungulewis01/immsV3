<?php

namespace App\Models\Eric;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transferdatails extends Model
{
    protected $fillable = [
        'trid',  'inid',
    ];
    use HasFactory;
}
