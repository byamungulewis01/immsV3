<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchOrder extends Model
{
    use HasFactory;
    protected $table = 'branchorder';
    protected $primaryKey = 'order_id';
    protected $fillable = [
        'order_id',
        'item_id',
        'bid',
        'user_id',
        'quantity',
        'regnumber',
        'inStore',
    ];
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'bid');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'bid');
    }
}
