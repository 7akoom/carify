<form method="POST" action="{{ route('fuel_requests.update',$row->id) }}" class="submit-form">
    @csrf
    <div id="vehicle-forms-container">
        <div class="vehicle-form">
            <div class="row">
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="number">الرقم</label>
                        <input type="text" name="number" id="number" class="form-control number"
                            value="{{ $row->number }}" readonly>
                        <span class="text-danger" id="number-error"></span>
                    </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                    <label for="date">التاريخ</label>
                    <div class="input-group">
                        <input type="date" name="date" class="date form-control" value="{{ $row->date }}">
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
                        <input type="time" name="time" id="task_start_time" value="{{ $row->time }}"
                                class="task_start_time form-control">
                        <span class="text-danger" id="time-error"></span>
                    </div>
                </div>
                <div class="form-group col-md-4 mb-3">
                    <label for="driver_id">السائق</label>
                    <select class="form-control" name="driver_id" id="driver_id" name="driver_id">
                        <option value="" disabled selected>اختر السائق</option>
                        @foreach($drivers as $driver)
                            <option value="{{ $driver->id }}" {{ $driver->id == $row->driver_id ? 'selected':'' }}>{{ $driver->first_name . ' '.  $driver->last_name }}</option>
                        @endforeach
                    </select>
                    <span class="text-danger" id="driver_id-error"></span>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="truck_id">رقم السيارة</label>
                        <select name="truck_id" id="truck_id"   class="form-control" data-live-search="true">
                             <option value="" disabled selected>اختر السيارة</option>
                          @foreach ($trucks as $truck)
                          <option value="{{ $truck->id }}" {{ $truck->id == $row->truck_id ? 'selected':'' }}>{{ $truck->plate_number }}</option>
                          @endforeach
                          </select>
                        <span class="text-danger" id="truck_id-error"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="amount">الكمية</label>
                        <input type="number" value="{{$row->amount}}" name="amount" id="amount"
                            class="form-control initial_odometer_number_0">
                        <span class="text-danger" id="amount-error"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="prev_odometer_number">رقم العداد السابق</label>
                        <input type="number" value="{{$row->prev_odometer_number}}" name="prev_odometer_number" id="prev_odometer_number"
                            class="form-control prev_odometer_number_0">
                        <span class="text-danger" id="prev_odometer_number-error"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="curr_odometer_number">رقم العداد الحالي</label>
                        <input type="number" value="{{$row->curr_odometer_number}}" name="curr_odometer_number" id="curr_odometer_number"
                            class="form-control curr_odometer_number_0">
                        <span class="text-danger" id="curr_odometer_number-error"></span>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group mb-3">
                        <label for="distance">المسافة المقطوعة</label>
                        <input type="number" name="distance" id="distance" value="{{$row->distance}}"
                            class="form-control distance_0">
                        <span class="text-danger" id="distance-error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="distance_ratio">نسبة المسير</label>
                        <input type="number" name="distance_ratio" id="distance_ratio" value="{{$row->distance_ratio}}"
                            class="form-control distance_0">
                        <span class="text-danger" id="distance_ratio-error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="estimated_distance_ratio">نسبة المسير المقدرة</label>
                        <input type="number" name="estimated_distance_ratio" id="estimated_distance_ratio" value="{{$row->estimated_distance_ratio}}"
                            class="form-control estimated_distance_ratio_0">
                        <span class="text-danger" id="estimated_distance_ratio-error"></span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group mb-3">
                        <label for="notes">ملاحظات</label>
                        <textarea class="form-control" id="notes" name="notes" rows="4">{{$row->notes}}</textarea>
                        <span class="text-danger" id="notes-error"></span>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary rounded-btn" data-dismiss="modal">إغلاق</button>
                <button type="submit" class="btn btn-success rounded-btn">حفظ</button>
            </div>
        </div>
    </div>
</form>

<script>
    $('.selectpicker').selectpicker('render');
</script>  
  <script>
   $(document).on('click', '#modal', function (e) {
   e.preventDefault()

   var href = $(this).attr('href')
   $.ajax({
       url: href,
       type: "GET",
       dataType: "json",
       success: function (response) {
           var escorts = response.row.escort;
           var ids = []
           escorts.forEach(element => {
               ids.push(element.id)
             
             
               $('.selectpicker').val(ids);

           });


       },

   })
})

</script> 


<script>
    for(let i=0; i<=100; i++){
        $(document).on('input',`.final_odometer_number_${i}`,function(e){
            $(`.distance_${i}`).val(0)
            let distance = $(`.final_odometer_number_${i}`).val()-$(`.initial_odometer_number_${i}`).val()
            $(`.distance_${i}`).val(distance)  
        })
    }
</script>