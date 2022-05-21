<x-app-layout>
    @section('title')
    <h4>Update Company Setting</h4>
    @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{route('company-settings.update', $company_setting->id)}}" method="POST" id="edit">
                @csrf
                @method('PUT')
                <div class="row">
                    <div class="col-md-6 pt-4">
                        <div class="form-outline mb-4">
                            <input type="text" name="company_name" id="form4Example1" class="form-control"
                                value="{{$company_setting->company_name}}" />
                            <label class="form-label" for="form4Example1">Company Name</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" name="company_email" id="form4Example1" class="form-control"
                                value="{{$company_setting->company_email}}" />
                            <label class="form-label" for="form4Example1">Company Email</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="number" name="company_phone" id="form4Example1" class="form-control"
                                value="{{$company_setting->company_phone}}" />
                            <label class="form-label" for="form4Example1">Company Phone</label>
                        </div>

                        <div class="form-outline mb-4">
                            <textarea name="company_address" id="" cols="10" rows="3" class="form-control">{{$company_setting->company_address}}</textarea>
                            <label class="form-label" for="form4Example1">Company Address</label>
                        </div>
                    </div>

                    <div class="col-md-6 pt-4">
                        <div class="form-outline mb-4">
                            <input type="text" name="office_start_time" id="form4Example1" class="form-control timepicker"
                                value="{{$company_setting->office_start_time}}" />
                            <label class="form-label" for="form4Example1">Office First Time</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" name="office_end_time" id="form4Example1" class="form-control timepicker"
                                value="{{$company_setting->office_end_time}}" />
                            <label class="form-label" for="form4Example1">Office End Time</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" name="break_start_time" id="form4Example1" class="form-control timepicker"
                                value="{{$company_setting->break_start_time}}" />
                            <label class="form-label" for="form4Example1">Break Start Time</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" name="break_end_time" id="form4Example1" class="form-control timepicker"
                                value="{{$company_setting->break_end_time}}" />
                            <label class="form-label" for="form4Example1">Break End Time</label>
                        </div>
                    </div>
                </div>
                <!-- Submit button -->
                <button type="submit" class="btn-theme btn-block mb-4 p-2">Update</button>
            </form>
        </div>
    </div>

    @section('scripts')
    {!!JsValidator::formRequest('App\Http\Requests\UpdateCompanySetting', '#edit');!!}
    <script>
        $(document).ready(function(){
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