<x-app-layout>
    @section('title')
    <h4>Update Attendances</h4>
    @endsection

    <div class="card">
        <div class="card-body">
            @foreach ($errors->all() as $error)
                <div class="alert alert-danger">
                    {{$error}}
                </div>
            @endforeach

            <form action="{{route('attendances.update', $attendance->id)}}" method="POST" id="update">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-12 pt-4">
                        <!-- Name input -->
                        <div class="form-group mb-4">
                            <label class="form-label mb-4" for="form4Example2">Role</label>
                            <select name="user_id" class="form-control select-multiple">
                                <option selected disabled>Choose An Option</option>
                                @foreach ($employees as $employee)
                                <option value="{{$employee->id}}"
                                @if(old('user_id',$attendance->user_id) == $employee->id)
                                    selected
                                @endif>{{$employee->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="form4Example2">Date</label>
                            <input type="text" name="date" class="form-control date" value="{{old('date', $attendance->date)}}"/>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="form4Example1">Checkin Time</label>
                            <input type="text" name="checkin_time" id="form4Example1" class="form-control timepicker" value="{{old('checkin_time', Carbon\Carbon::parse($attendance->checkin_time)->format('H:i:s'))}}" />
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="form4Example1">Checkout Time</label>
                            <input type="text" name="checkout_time" id="form4Example1" class="form-control timepicker" value="{{old('checkout_time', Carbon\Carbon::parse($attendance->checkout_time)->format('H:i:s'))}}"  />
                        </div>
                    </div>
                </div>
                <button type="submit" class="btn-theme btn-block mb-4 p-2">Update</button>
            </form>
        </div>
    </div>

    @section('scripts')
    {!!JsValidator::formRequest('App\Http\Requests\UpdateAttendance', '#update');!!}
    <script>
        $(document).ready(function(){
            $('.date').daterangepicker({
                    "alwaysShowCalendars": true,
                    "singleDatePicker": true,
                    "locale": {
                        "format": "YYYY-MM-DD",
                    },
                    "autoApply": true,
                    "maxDate" : moment(),
                    "showDropdowns": true,
                });

                $('.timepicker').daterangepicker({
                    "autoApply": true,
                    "timePicker": true,
                    "timePicker24Hour": true,
                    "timePickerSeconds": true,
                    "singleDatePicker": true,
                    "locale": {
                        "format": "HH:mm:ss",
                    },
                }).on('show.daterangepicker', function(ev, picker) {
                    $('.calendar-table').hide();
                });
            })
    </script>
    @endsection

</x-app-layout>