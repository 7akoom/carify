<?php

namespace App\Services\FuelRequest;

use App\Models\FuelRequest;

class UpdateFuelRequestService
{
    public function update(array $data, $id)
    {
        $row = FuelRequest::findOrFail($id);

        $row->update([
            'number' => $data['number'],
            'date' => $data['date'],
            'truck_id' => $data['truck_id'],
            'driver_id' => $data['driver_id'],
            'prev_odometer_number' => $data['prev_odometer_number'],
            'curr_odometer_number' => $data['curr_odometer_number'],
            'amount' => $data['amount'],
            'distance' => $data['distance'],
            'distance_ratio' => $data['distance_ratio'],
            'estimated_distance_ratio' => $data['estimated_distance_ratio'],
            'time' => $data['time'],
            'notes' => $data['notes'],
        ]);
    }
}
