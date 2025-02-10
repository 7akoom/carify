<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MaintenanceRequest extends Model
{
    protected $casts = [
        'type' => 'string',
    ];

    protected $guarded = [];

    public function product()
    {
        return $this->belongsToMany(Product::class, 'request_product', 'request_id', 'product_id')
            ->withPivot('procedure_id', 'quantity', 'unit_price', 'total_price');
    }

    public function truck()
    {
        return $this->belongsTo(Truck::class);
    }


    public function driver()
    {
        return $this->belongsTo(Driver::class);
    }

    public function calculateTotal()
    {
        $total = 0;

        foreach ($this->product as $product) {
            $quantity = (int) $product->pivot->quantity;
            $unitPrice = (float) $product->pivot->unit_price;

            $productTotal = $quantity * $unitPrice;



            $total += $productTotal;
        }

        return $total;
    }
}
