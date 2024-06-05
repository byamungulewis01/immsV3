<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NationalMailInvoice extends Model
{
    use HasFactory;
    // fillable
    protected $fillable = [
        'invoice_number',
        'invoice_month',
        'invoice_year',
        'invoice_status',
        'invoice_total',
        'invoice_ibm_attachment',
        'invoice_payment_date',
        'invoice_payment_status',
        'invoice_payment_attachment',
        'customer',
    ];

    // customer
    public function customerName()
    {
        return $this->belongsTo(Customer::class, 'customer');
    }

}
