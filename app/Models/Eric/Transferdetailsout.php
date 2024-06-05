<?php

namespace App\Models\Eric;

use App\Models\OutboxingMail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transferdetailsout extends Model
{
    use HasFactory;
    protected $fillable = [
        'trid',  'out_id',
    ];
    public function outbox()
    {
        return $this->belongsTo(OutboxingMail::class, 'out_id');
    }
}
