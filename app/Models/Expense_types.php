<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense_types extends Model
{
    use HasFactory;
    protected $table = 'expense_types';
    protected $primaryKey = 'et_id';
    protected $fillable = [
        'et_name',
    ];
}
