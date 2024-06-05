<?php

namespace App\Models\Eric;

use App\Models\Country;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AirportDispach extends Model
{
    use HasFactory;
    protected $fillable = [
        'dispatchNumber', 'cntp_id', 'transfer_date', 'received_by', 'status', 'created_at', 'updated_at',
        'grossweight', 'currentweight', 'wtype', 'comment', 'token', 'cntppickupdate', 'mailtype', 'sorted_by','sorting_date',
        'dispachetype', 'mailweight', 'numberitem', 'mailnumber', 'mailstypes', 'orgincountry', 'cntpweight',
        'omweight', 'olweight', 'rmweight', 'rlweight', 'regstatus', 'opened_by','opened_date',
        'mstatus', 'cntpcomment', 'packagecomment', 'jurweight', 'prmweight', 'gadeight', 'pcardeight', 'rpcomment', 'mailnumberreg',
    ];
    public function country()
    {
        return $this->belongsTo(Country::class, 'orgincountry', 'c_id');
    }
    public function ctnp()
    {
        return $this->belongsTo(User::class, 'cntp_id','id');
    }
    public function receiver()
    {
        return $this->belongsTo(User::class, 'received_by','id');
    }
    public function opener()
    {
        return $this->belongsTo(User::class, 'opened_by','id');
    }
    public function sorter()
    {
        return $this->belongsTo(User::class, 'sorted_by','id');
    }
}
