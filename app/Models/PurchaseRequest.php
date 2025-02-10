<?php

namespace App\Models;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequest extends Model
{
    protected $guarded = [];

    public function calculateTotal($requestId)
    {
        return DB::table('purchase_request_product')
            ->where('request_id', $requestId)
            ->sum('total_price');
    }
}
