<?php

namespace App\Services\Driver;

use Carbon\Carbon;
use App\Models\Truck;
use App\Models\Driver;
use Illuminate\Support\Facades\DB;
use App\Services\Card\StoreDeliverCardService;
use App\Traits\CommandNumGen;

class StoreDriverService
{
    use CommandNumGen;

    protected $storeDeliverCardService;

    public function __construct(StoreDeliverCardService $storeDeliverCardService)
    {
        $this->storeDeliverCardService = $storeDeliverCardService;
    }

    public function storeDrivers(array $driversData)
    {
        DB::beginTransaction();
        try {
            foreach ($driversData['first_name'] as $index => $firstName) {
                $number = $this->generateCardDeliverNumber();
                $row = Driver::create([
                    'first_name' => $firstName,
                    'last_name' => $driversData['last_name'][$index],
                    'birth_date' => $driversData['birth_date'][$index],
                    'phone' => $driversData['phone'][$index],
                    'address' => $driversData['address'][$index],
                    'license_type' => $driversData['license_type'][$index],
                    'license_expiration_date' => $driversData['license_expiration_date'][$index],
                ]);

                if (isset($driversData['truck_id'][$index]) && !empty($driversData['truck_id'][$index])) {
                    $truck = Truck::where('id', $driversData['truck_id'][$index])->first();

                    if ($truck) {
                        $year = Carbon::createFromFormat('Y', $truck->year)->format('Y');
                        $model = Carbon::createFromFormat('Y', $truck->model)->format('Y');
                        $register = Carbon::createFromFormat('Y', $truck->register)->format('Y');
                        $demarcation_date = Carbon::createFromFormat('Y-m-d', $truck->demarcation_date)->format('Y-m-d');
                        $receipt_date = Carbon::createFromFormat('Y-m-d', $driversData['receipt_date'][$index])->format('Y-m-d');
                        $deliver_date = Carbon::createFromFormat('Y-m-d', $driversData['deliver_date'][$index])->format('Y-m-d');

                        $this->storeDeliverCardService->store([
                            'number' => $number,
                            'type' => $truck->type,
                            'manufacturer' => $truck->manufacturer,
                            'plate_number' => $truck->plate_number,
                            'chassis_number' => $truck->chassis_number,
                            'engine_number' => $truck->engine_number,
                            'traffic_license_number' => $truck->traffic_license_number,
                            'legal_status' => $truck->legal_status,
                            'fuel_type' => $truck->fuel_type,
                            'year' => $year,
                            'model' => $model,
                            'passengers_number' => $truck->passengers_number,
                            'gross_weight' => $truck->gross_weight,
                            'empty_weight' => $truck->empty_weight,
                            'load' => $truck->load,
                            'kilometer_number' => $truck->kilometer_number,
                            'technical_status' => $truck->technical_status,
                            'color' => $truck->color,
                            'register' => $register,
                            'demarcation_date' => $demarcation_date,
                            'receipt_date' => $receipt_date,
                            'deliver_date' => $deliver_date,
                            'driver_id' => $row->id,
                            'truck_id' => $truck->id,
                        ]);
                    }
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
