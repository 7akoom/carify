<?php

namespace App\Http\Controllers;

use App\Models\Truck;
use App\Models\Driver;
use Illuminate\Http\Request;
use App\Traits\CommandNumGen;
use Illuminate\Support\Facades\Log;
use App\Services\FuelRequest\StoreFuelRequestService;
use App\Http\Requests\FuelFilling\StoreFuelFillingRequest;
use App\Http\Requests\FuelFilling\UpdateFuelFillinRequest;
use App\Models\FuelRequest;
use App\Services\FuelRequest\UpdateFuelRequestService;

class FuelRequestController extends Controller
{
    use CommandNumGen;

    protected $storeFuelRequestService;
    protected $updateFuelRequestService;

    public function __construct(
        StoreFuelRequestService $storeFuelRequestService,
        UpdateFuelRequestService $updateFuelRequestService
    ) {
        $this->storeFuelRequestService = $storeFuelRequestService;
        $this->updateFuelRequestService = $updateFuelRequestService;
    }

    public function index()
    {
        $filling = FuelRequest::select('id', 'number', 'date', 'amount', 'distance', 'truck_id', 'driver_id')
            ->with([
                'truck:id,plate_number',
                'driver:id,first_name,last_name'
            ])
            ->get();
        return view('fuel_requests.index', compact('filling'));
    }



    public function create()
    {
        $trucks = Truck::select('id', 'plate_number')->get();
        $drivers = Driver::select('id', 'first_name', 'last_name')->get();
        $number = $this->generateFuleRequestNumber();

        return view('fuel_requests.create', \compact('trucks', 'drivers', 'number'));
    }

    public function store(StoreFuelFillingRequest $request)
    {
        try {
            $data = $request->validated();

            $this->storeFuelRequestService->store($data);
            return response()->json([
                'message' => 'تم إضافة الطلب بنجاح.',
                'redirect' => route('fuel_requests.index')
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'حدث خطأ أثناء إضافة الطلب:',
                'redirect' => route('fuel_requests.index')
            ]);
        }
    }

    public function edit($id)
    {
        $trucks = Truck::select('id', 'plate_number')->get();
        $drivers = Driver::select('id', 'first_name', 'last_name')->get();
        $row = FuelRequest::with(['truck', 'driver'])->where('id', $id)->first();

        return response()->json([
            'html' => view('fuel_requests.edit', [
                'row' => $row,
                'trucks' => $trucks,
                'drivers' => $drivers
            ])->render(),
        ]);
    }

    public function update(UpdateFuelFillinRequest $request, $id)
    {
        try {
            $this->updateFuelRequestService->update($request->validated(), $id);
            return response()->json([
                'message' => 'تم تعديل الطلب بنجاح.',
                'redirect' => route('fuel_requests.index')
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'حدث خطأ أثناء تعديل الطلب:',
                'redirect' => route('fuel_requests.index')
            ]);
        }
    }

    public function destroy($id)
    {
        try {
            FuelRequest::where('id', $id)->delete();
            return response()
                ->json([
                    'message' => 'تم حذف الطلب بنجاح',
                    'redirect' => route('fuel_requests.index')
                ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()
                ->json([
                    'message' => 'حدث خطأ أثناء حذف الطلب',
                    'redirect' => route('fuel_requests.index')
                ]);
        }
    }

    public function MultiDelete(Request $request)
    {
        try {

            FuelRequest::whereIn('id', (array) $request['ids'])->delete();
            return response()->json([
                'message' => 'تم حذف الطلبات بنجاح',
                'redirect' => route('fuel_requests.index')
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'حدث خطأ أثناء حذف الطلبات:',
                'redirect' => route('fuel_requests.index')
            ]);
        }
    }
}
