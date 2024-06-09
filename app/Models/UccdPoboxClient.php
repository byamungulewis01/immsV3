<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UccdPoboxClient extends Model
{
    use HasFactory;
    protected $fillable = ['phone', 'box_id'];

    public function box()
    {
        return $this->belongsTo(Box::class);
    }

}
