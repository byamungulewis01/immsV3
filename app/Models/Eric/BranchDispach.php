<?php

namespace App\Models\Eric;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchDispach extends Model
{
    use HasFactory;
    protected $fillable = [
        'dispacher_id','branch_id','weights'
    ];
}
