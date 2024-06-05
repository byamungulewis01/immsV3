<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NationalMailDispatch extends Model
{
    use HasFactory;
    // fillable
    protected $fillable = [
        'branch',
        'weight',
        'mailsNumber',
        'status',
        'sentDate',
        'receivedBy',
    ];
    // relations of branch
    public function branchName()
    {
        return $this->belongsTo(Branch::class, 'branch', 'id');
    }
    // agent
    public function user()
    {
        return $this->belongsTo(User::class, 'receivedBy', 'id');
    }
}
