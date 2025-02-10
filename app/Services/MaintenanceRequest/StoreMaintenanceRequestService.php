<?php

namespace App\Services\MaintenanceRequest;

use App\Models\MaintenanceRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class StoreMaintenanceRequestService
{
    public function store(array $orders)
    {
        DB::beginTransaction();
        try {
            foreach ($orders['number'] as $key => $value) {
                $row = MaintenanceRequest::create([
                    'number' => $value,
                    'date' => $orders['date'][$key],
                    'start_date' => $orders['start_date'][$key],
                    'end_date' => $orders['end_date'][$key],
                    'time' => $orders['time'][$key],
                    'start_time' => $orders['start_time'][$key],
                    'end_time' => $orders['end_time'][$key],
                    'reference' => $orders['reference'][$key],
                    'type' => $orders['type'][$key],
                    'truck_id' => $orders['truck_id'][$key],
                    'driver_id' => $orders['driver_id'][$key],
                    'odometer_number' => $orders['odometer_number'][$key],
                    'created_by' => $orders['created_by'][$key],
                    'total' => 0,
                    'notes' => $orders['notes'][$key],
                ]);

                if (isset($orders['product_id']) && is_array($orders['product_id'])) {
                    foreach ($orders['product_id'] as $k => $prod) {
                        if ($orders['number'][$k] == $value) {
                            $total_price = $orders['quantity'][$k] * $orders['unit_price'][$k];
                            DB::table('request_product')->insert([
                                'request_id' => $row->id,
                                'procedure_id' => $orders['procedure_id'][$k],
                                'product_id' => $prod,
                                'quantity' => $orders['quantity'][$k],
                                'unit_price' => $orders['unit_price'][$k],
                                'total_price' => $total_price,
                                'created_at' => Carbon::now(),
                            ]);
                        }
                    }
                }

                $calculatedTotal = $row->calculateTotal();
                $row->total = $calculatedTotal;
                $row->save();
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
