@extends('layouts.app')

@section('content')

<div class="col-12">
    <h2 class="page-title mb-3">أمر تعبئة وقود</h2>
    <div class="card shadow mb-4">
        <div class="card-body">
            @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <form method="POST" action="{{route('fuel_requests.store')}}" class="submit-form">
                @csrf
                <div id="vehicle-forms-container">
                    <div class="vehicle-form">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="number">الرقم</label>
                                    <input type="text" name="number[]" id="number" class="form-control number"
                                        value="{{ $number }}" readonly>
                                    <span class="text-danger" id="number-error"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="date">التاريخ</label>
                                <div class="input-group">
                                    <input type="date" name="date[]" class="date form-control" value="{{ date('Y-m-d') }}">
                                    <div class="input-group-append">
                                        <div class="input-group-text" id="button-addon-date">
                                            <span class="fe fe-calendar fe-16">
                                            </span>
                                        </div>
                                    </div>
                                    <span class="text-danger" id="date-error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="time">التوقيت</label>
                                    <input type="time" name="time[]" id="task_start_time" value="{{ date("H:i") }}"
                                         class="task_start_time form-control">
                                    <span class="text-danger" id="time-error"></span>
                                </div>
                            </div>
                            <div class="form-group col-md-4 mb-3">
                                <label for="driver_id">السائق</label>
                                <select class="form-control" id="driver_id" name="driver_id[]">
                                    <option value="" disabled selected>اختر السائق</option>
                                    @foreach($drivers as $driver)
                                    <option value="{{ $driver->id }}">{{ $driver->first_name . ' '. $driver->last_name }}</option>
                                    @endforeach
                                </select>
                                <span class="text-danger" id="driver_id-error"></span>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="truck_id">رقم السيارة</label>
                                    <select name="truck_id[]" id="truck_id"
                                        class="selectpicker form-control" data-live-search="true">
                                        <option value="" disabled selected>اختر السيارة</option>
                                        @foreach ($trucks as $truck)
                                        <option value="{{ $truck->id }}" @if(request('truck_id')){{  $truck->id == request('truck_id') ? 'selected':'' }}@endif>{{ $truck->plate_number }}</option>
                                        @endforeach
                                    </select>
                                    <span class="text-danger" id="truck_id-error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="amount">الكمية</label>
                                    <input type="number" value="" name="amount[]" id="amount"
                                        class="form-control initial_odometer_number_0">
                                    <span class="text-danger" id="amount-error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="prev_odometer_number">رقم العداد السابق</label>
                                    <input type="number" value="" name="prev_odometer_number[]" id="prev_odometer_number"
                                        class="form-control prev_odometer_number_0">
                                    <span class="text-danger" id="prev_odometer_number-error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="curr_odometer_number">رقم العداد الحالي</label>
                                    <input type="number" value="" name="curr_odometer_number[]" id="curr_odometer_number"
                                        class="form-control curr_odometer_number_0">
                                    <span class="text-danger" id="curr_odometer_number-error"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group mb-3">
                                    <label for="distance">المسافة المقطوعة</label>
                                    <input type="number" name="distance[]" id="distance" value=""
                                        class="form-control distance_0">
                                    <span class="text-danger" id="distance-error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="distance_ratio">نسبة المسير</label>
                                    <input type="number" name="distance_ratio[]" id="distance_ratio" value=""
                                        class="form-control distance_0">
                                    <span class="text-danger" id="distance_ratio-error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="estimated_distance_ratio">نسبة المسير المقدرة</label>
                                    <input type="number" name="estimated_distance_ratio[]" id="estimated_distance_ratio" value=""
                                        class="form-control estimated_distance_ratio_0">
                                    <span class="text-danger" id="estimated_distance_ratio-error"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="notes">ملاحظات</label>
                                    <textarea class="form-control" id="notes" name="notes[]" rows="4"></textarea>
                                    
                                    <span class="text-danger" id="notes-error"></span>
                                </div>
                            </div>
                        </div>

                        <div class="col mr-auto mb-5 mt-5">
                            <div class="dropdown">
                                <button type="submit" class="btn btn-success rounded-btn">حفظ</button>
                                <button type="button" id="add-form-btn" class="btn rounded-btn btn-primary">
                                    أمر تعبئة جديد
                                </button>
                                <button type="button" class="btn btn-danger rounded-btn delete-form-btn">
                                    إلغاء هذا الأمر
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>



@endsection

@section('scripts')
<script src="{{ asset('js/form-repeater.js') }}"></script>

<script>
    for(let i=0; i<=100; i++){
        $(document).on('input',`.curr_odometer_number_${i}`,function(e){
            let distance = $(`.final_odometer_number_${i}`).val()-$(`.prev_odometer_number_${i}`).val()
            $(`.distance_${i}`).val(distance)  
        })
    }
</script>
@endsection