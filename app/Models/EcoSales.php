<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EcoSales extends Model
{
    use HasFactory;

    protected $fillable = [
        'id',
        'product_id',
        'user_id',
        'customer_id',
        'codesale',
        'seller',
        'pay_id',
        'status',
        'type',
        'installmentCount',
        'installmentValue',
        'installment',
        'body',
    ];

    public function getSales(string|null $search = null)
    {
        $sales = $this->where(function ($query) use ($search) {
            if ($search) {
                $query->where('user_id', $search);
                $query->orWhere('codesale', 'LIKE', "%{$search}%");
                $query->orWhere('seller', 'LIKE', "%{$search}%");
                $query->orWhere('status', 'LIKE', "%{$search}%");
                $query->orWhere('body', 'LIKE', "%{$search}%");
            }
        })
        ->paginate();

        return $sales;
    }

}
