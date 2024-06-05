<?php

namespace App\Models\Customer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerDispatchDetails extends Model
{
    use HasFactory;
    protected $fillable = [
        'dispatch_id',
        'dispatchNumber',
        'refNumber',
        'weight',
        'price',
        'observation',
        'status',
        'pickUpDate',
        'logisticDate',
        'emsDate',
        'branchManagerDate',
        'deliveredDate',
        'pob',
        'customer_id',
        'destination_id',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->refNumber = 'NP-' . str_pad(static::getNextRefNumber(), 4, '0', STR_PAD_LEFT);
            CustomerDispatch::findorfail($model->dispatch_id)->increment('mailsNumber');

        });
        static::deleting(function ($model) {
            CustomerDispatch::findorfail($model->dispatch_id)->decrement('mailsNumber');
        });
    }

    protected static function getNextRefNumber()
    {
        $lastRecord = static::orderByDesc('id')->first();
        if (!$lastRecord) {
            return 1;
        }
        $lastRefNumber = (int)substr($lastRecord->refNumber, 3);
        return $lastRefNumber >= 9999 ? 1 : $lastRefNumber + 1;
    }
    public function destination()
    {
        return $this->belongsTo(MyContacts::class);
    }
    // dispatch
    public function dispatch()
    {
        return $this->belongsTo(CustomerDispatch::class);
    }
}
