<?php

namespace App\Models\Eric;

use App\Models\User;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Transferout extends Model
{
    use HasFactory;
    protected $fillable = [
        'fromuserid', 'status', 'rvdate', 'touserid', 'mnumber',
        'mailtype','bid','weight','pdate'
    ];
    public function branches()
    {
        return $this->belongsTo(Branch::class,'touserid');
    }
    public function emplo()
    {
        return $this->belongsTo(User::class,'fromuserid');
    }
}
