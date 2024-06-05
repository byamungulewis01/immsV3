<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Incomes extends Model
{
    use HasFactory;

    protected $table = 'income';
    protected $primaryKey = 'e_id';
    protected $fillable = [
        'e_type',
        'e_amount',
        'branch_id',
        'e_status',
        'pdate'
    ];

    public function income_type()
    {
        return $this->belongsTo(Income_types::class, 'et_id');
    }
    public function branch()
    {
        return $this->belongsTo(Branch::class,);
    }
}
