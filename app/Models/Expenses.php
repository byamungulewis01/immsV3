<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use HasFactory;
    protected $table = 'expenses';
    protected $primaryKey = 'e_id';
    protected $fillable = [
        'et_id',
        'e_name',
        'e_description',
        'e_amount',
        'branch_id',
        'e_file',
        'e_status',
    ];

    public function expense_type()
    {
        return $this->belongsTo(Expense_types::class, 'et_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class,);
    }

}
