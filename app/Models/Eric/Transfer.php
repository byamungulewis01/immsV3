<?php

namespace App\Models\Eric;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transfer extends Model
{
    protected $fillable = [
        'fromuserid', 'status', 'rvdate', 'touserid', 'mnumber',
        'mailtype',
    ];
    public function branches()
    {
        return $this->belongsTo(Branch::class,'touserid');
    }
    public function emplo()
    {
        return $this->belongsTo(User::class,'fromuserid');
    }
    use HasFactory;

}
