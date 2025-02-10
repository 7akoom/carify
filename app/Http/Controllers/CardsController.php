<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Enums\Color;
use App\Models\Truck;
use App\Models\Driver;
use App\Enums\FuelTypes;
use App\Models\TruckDeliverCard;
use Illuminate\Support\Facades\Log;
use App\Services\Card\StoreDeliverCardService;
use App\Http\Requests\Cards\StoreDeliverCardRequest;
use App\Traits\CommandNumGen;

class CardsController extends Controller
{
    use CommandNumGen;

    protected $storeDeliverCardService;

    public function __construct(StoreDeliverCardService $storeDeliverCardService)
    {
        $this->storeDeliverCardService = $storeDeliverCardService;
    }

    public function index()
    {
        $cards = TruckDeliverCard::with(['truck', 'driver'])->get();
        return view('cards.index', \compact('cards'));
    }
    public function create($id)
    {
        $drivers = Driver::select('id', 'first_name', 'last_name')->get();
        $colors = Color::values();
        $fuelTypes = FuelTypes::values();
        $truck = Truck::findOrFail($id);
        $number = $this->generateCardDeliverNumber();

        return view('trucks.deliver_order', \compact('colors', 'fuelTypes', 'drivers', 'truck', 'number'));
    }

    public function store(StoreDeliverCardRequest $request)
    {
        Log::info(['request', $request->all()]);
        try {
            Log::info(['validated request', $request->validated()]);
            $this->storeDeliverCardService->store($request->validated());
            return response()->json([
                'message' => 'تم إضافة بطاقة التسليم بنجاح.',
                'redirect' => route('trucks.index')
            ]);
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return response()->json([
                'message' => 'حدث خطأ أثناء إضافة البطاقة:',
                'redirect' => route('trucks.index')
            ]);
        }
    }

    public function show($id)
    {
        $row = TruckDeliverCard::with(['truck', 'driver'])->where('id', $id)->first();

        return response()->json([
            'html' => view('cards.show', ['row' => $row])->render(),
        ]);
    }
}
