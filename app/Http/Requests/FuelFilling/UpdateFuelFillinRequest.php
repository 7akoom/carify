<?php

namespace App\Http\Requests\FuelFilling;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFuelFillinRequest extends FormRequest
{

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'number' => 'required',
            'date' => 'required',
            'truck_id' => 'required',
            'driver_id' => 'required',
            'prev_odometer_number' => 'nullable',
            'curr_odometer_number' => 'required',
            'amount' => 'required',
            'distance' => 'nullable',
            'distance_ratio' => 'nullable',
            'estimated_distance_ratio' => 'nullable',
            'time' => 'required',
            'notes' => 'nullable',
        ];
    }

    public function messages()
    {
        return [
            'number.required' => 'الرقم مطلوب',
            'date.required' => 'التاريخ',
            'truck_id.required' => 'رقم السيارة مطلوب',
            'driver_id.required' => ' السائق مطلوب',
            'curr_odometer_number.required' => 'رقم العداد الحالي',
            'amount.required' => 'الكمية',
            'time.required' => 'التوقيت',
        ];
    }
}
