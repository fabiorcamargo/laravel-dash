<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'dateCreated',
        'customer',
        'paymentLink',
        'installment',
        'dueDate',
        'value',
        'netValue',
        'billingType',
        'status',
        'description',
        'externalReference',
        'installmentNumber',
        'invoiceUrl',
        'bankSlipUrl',
        'invoiceNumber',
    ];



    public function user()
    {
        return $this->hasOne(Gateway_Customer::class);
    }
}
