<?php

namespace App\Services\MaintenanceRequest;

use Carbon\Carbon;
use App\Models\MaintenanceRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class UpdateMaintenanceRequestService
{
    public function update(array $orders, $maintenanceRequestId)
    {
        DB::beginTransaction();
        try {
            $maintenanceRequest = MaintenanceRequest::findOrFail($maintenanceRequestId);

            $maintenanceRequest->update([
                'number' => $orders['number'],
                'date' => $orders['date'],
                'start_date' => $orders['start_date'],
                'end_date' => $orders['end_date'],
                'time' => $orders['time'],
                'start_time' => $orders['start_time'],
                'end_time' => $orders['end_time'],
                'reference' => $orders['reference'],
                'type' => $orders['type'],
                'truck_id' => $orders['truck_id'],
                'driver_id' => $orders['driver_id'],
                'odometer_number' => $orders['odometer_number'],
                'created_by' => $orders['created_by'],
                'total' => $orders['total'],
                'notes' => $orders['notes'],
            ]);

            if (isset($orders['product_id']) && is_array($orders['product_id'])) {
                DB::table('request_product')->where('request_id', $maintenanceRequest->id)->delete();
                foreach ($orders['product_id'] as $k => $prod) {
                    $total_price = $orders['quantity'][$k] * $orders['unit_price'][$k];

                    DB::table('request_product')->insert([
                        'request_id' => $maintenanceRequest->id,
                        'procedure_id' => $orders['procedure_id'][$k],
                        'product_id' => $prod,
                        'quantity' => $orders['quantity'][$k],
                        'unit_price' => $orders['unit_price'][$k],
                        'total_price' => $total_price,
                    ]);
                }
                $calculatedTotal = $maintenanceRequest->calculateTotal();
                $maintenanceRequest->total = $calculatedTotal;
                $maintenanceRequest->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
