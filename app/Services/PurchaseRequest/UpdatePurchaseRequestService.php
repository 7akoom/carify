<?php

namespace App\Services\PurchaseRequest;

use Carbon\Carbon;
use App\Models\PurchaseRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdatePurchaseRequestService
{
    public function update(array $orders, $id)
    {
        DB::beginTransaction();
        try {

            $purchaseRequest = PurchaseRequest::findOrFail($id);


            if (!$purchaseRequest) {
                Log::error('PurchaseRequest with ID ' . $id . ' not found.');
                return response()->json(['error' => 'PurchaseRequest not found'], 404);
            }

            $purchaseRequest->update([
                'number' => $orders['number'],
                'date' => $orders['date'],
                'reference' => $orders['reference'],
                'responsible' => $orders['responsible'],
                'purchase_justifications' => $orders['purchase_justifications'],
                'total' => $orders['total'],
                'notes' => $orders['notes'],
            ]);

            if (isset($orders['product_id']) && is_array($orders['product_id'])) {
                DB::table('purchase_request_product')->where('request_id', $purchaseRequest->id)->delete();
                foreach ($orders['product_id'] as $k => $prod) {
                    $total_price = $orders['quantity'][$k] * $orders['price'][$k];

                    DB::table('purchase_request_product')->insert([
                        'request_id' => $purchaseRequest->id,
                        'product_id' => $prod,
                        'quantity' => $orders['quantity'][$k],
                        'price' => $orders['price'][$k],
                        'description' => $orders['description'][$k],
                        'product_responsible' => $orders['product_responsible'][$k],
                        'total_price' => $total_price,
                    ]);
                }
                $purchaseRequest->total = $purchaseRequest->calculateTotal($purchaseRequest->id);

                DB::table('purchase_requests')
                    ->where('id', $purchaseRequest->id)
                    ->update(['total' => $purchaseRequest->total]);
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
