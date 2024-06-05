<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ptarifcontinet extends Model
{
    use HasFactory;
    protected $table = 'ptarifcontinet';
    protected $primaryKey = 'pcon_id';
    protected $fillable = ['pcon_id', 'minweight', 'maxweight', 'cont_id', 'amount', 'type', 'servty_id'];
}
