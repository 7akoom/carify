<?php

namespace App\Services\FuelRequest;

use App\Models\FuelRequest;

class StoreFuelRequestService
{
    public function store(array $fuel)
    {
        $fillingData = [];
        foreach ($fuel['number'] as $key => $value) {
            $fillingData[] = [
                'number' => $value,
                'date' => $fuel['date'][$key],
                'truck_id' => $fuel['truck_id'][$key],
                'driver_id' => $fuel['driver_id'][$key],
                'prev_odometer_number' => $fuel['prev_odometer_number'][$key],
                'curr_odometer_number' => $fuel['curr_odometer_number'][$key],
                'amount' => $fuel['amount'][$key],
                'distance' => $fuel['distance'][$key],
                'distance_ratio' => $fuel['distance_ratio'][$key],
                'estimated_distance_ratio' => $fuel['estimated_distance_ratio'][$key],
                'time' => $fuel['time'][$key],
                'notes' => $fuel['notes'][$key],
            ];
        }

        FuelRequest::insert($fillingData);
    }
}
