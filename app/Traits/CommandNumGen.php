<?php

namespace App\Traits;

use Carbon\Carbon;
use App\Models\FuelRequest;
use App\Models\MovementCommand;
use App\Models\MaintenanceOrder;
use App\Models\MaintenanceRequest;
use App\Models\PurchaseRequest;
use App\Models\TruckDeliverCard;
use Illuminate\Support\Facades\Log;

trait CommandNumGen
{
    public function generateCustomNumber()
    {
        $date = Carbon::now()->format('dmy');

        $lastCommand = MovementCommand::where('number', 'like', 'os' . $date . '%')
            ->orderBy('number', 'desc')
            ->first();

        $increment = 1;
        if ($lastCommand) {
            $lastNumber = substr($lastCommand->number, 8);

            if (is_numeric($lastNumber)) {
                $increment = (int)$lastNumber + 1;
            }
        }

        $newNumber = 'os' . $date . sprintf('%04d', $increment);

        return $newNumber;
    }

    public function generateMaintenanceOrderNumber()
    {
        $date = Carbon::now()->format('dmy');

        $lastCommand = MaintenanceRequest::where('number', 'like', 'mo' . $date . '%')
            ->orderBy('number', 'desc')
            ->first();

        $increment = 1;
        if ($lastCommand) {
            $lastNumber = substr($lastCommand->number, 8);

            if (is_numeric($lastNumber)) {
                $increment = (int)$lastNumber + 1;
            }
        }

        $newNumber = 'mo' . $date . sprintf('%04d', $increment);

        return $newNumber;
    }

    public function generateFuleRequestNumber()
    {
        $date = Carbon::now()->format('dmy');
        $lastCommand = FuelRequest::where('number', 'like', 'ff' . $date . '%')
            ->orderBy('number', 'desc')
            ->first();

        $increment = 1;
        if ($lastCommand) {
            $lastNumber = substr($lastCommand->number, 8);

            if (is_numeric($lastNumber)) {
                $increment = (int)$lastNumber + 1;
            }
        }

        $newNumber = 'ff' . $date . sprintf('%04d', $increment);

        return $newNumber;
    }

    public function generatePurchaseRequestNumber()
    {
        $date = Carbon::now()->format('dmy');
        $lastCommand = PurchaseRequest::where('number', 'like', 'pr' . $date . '%')
            ->orderBy('number', 'desc')
            ->first();

        $increment = 1;
        if ($lastCommand) {
            $lastNumber = substr($lastCommand->number, 8);

            if (is_numeric($lastNumber)) {
                $increment = (int)$lastNumber + 1;
            }
        }

        $newNumber = 'pr' . $date . sprintf('%04d', $increment);

        return $newNumber;
    }

    public function generateCardDeliverNumber()
    {
        $date = Carbon::now()->format('dmy');
        $lastCommand = TruckDeliverCard::where('number', 'like', 'dc' . $date . '%')
            ->orderBy('number', 'desc')
            ->first();

        $increment = 1;
        if ($lastCommand) {
            $lastNumber = substr($lastCommand->number, 8);

            if (is_numeric($lastNumber)) {
                $increment = (int)$lastNumber + 1;
            }
        }

        $newNumber = 'dc' . $date . sprintf('%04d', $increment);

        return $newNumber;
    }
}
