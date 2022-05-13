<x-app-layout>
    @section('title')
    <h4>Create Employee</h4>
    @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{route('employee.store')}}" method="POST" id="create" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-6 pt-4">
                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <input type="text" name="employee_id" id="form4Example1" class="form-control" />
                            <label class="form-label" for="form4Example1">Employee ID</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="text" id="form4Example1" name="name" class="form-control" />
                            <label class="form-label" for="form4Example1">Name</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="number" id="form4Example1" name="phone" class="form-control" />
                            <label class="form-label" for="form4Example1">Phone No</label>
                        </div>

                        <div class="form-outline mb-4">
                            <input type="email" id="form4Example2" name="email" class="form-control" />
                            <label class="form-label" for="form4Example2">Email address</label>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="customFile">Profile Image</label>
                            <input type="file" class="form-control p-2" id="profile_img" name="profile_img" />
                            <div class="preview_img my-2">

                            </div>
                        </div>


                        <div class="form-outline mb-4">
                            <input type="text" id="form4Example2" name="nrc_number" class="form-control" />
                            <label class="form-label" for="form4Example2">NRC number</label>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="form4Example2">Birthday</label>
                            <input type="text" name="birthday" class="form-control birthday" />
                        </div>

                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-4">
                            <label class="form-label" for="form4Example2">Gender</label>
                            <select name="gender" class="form-control">
                                <option value="male">Male</option>
                                <option value="female">Female</option>
                            </select>
                        </div>

                        <div class="form-outline mb-4">
                            <textarea class="form-control" id="form4Example3" name="address" rows="1"></textarea>
                            <label class="form-label" for="form4Example3">Address</label>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="form4Example2">Department</label>
                            <select name="department_id" class="form-control">
                                <option value="" selected disabled>Select Department</option>
                                @foreach ($departments as $id => $department)
                                <option value="{{$department->id}}">{{$department->title}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="form4Example2">Role</label>
                            <select name="roles[]" class="form-control select-multiple" multiple>
                                @foreach ($roles as $role)
                                <option value="{{$role->id}}">{{$role->name}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="form4Example2">Date of join</label>
                            <input type="text" name="date_of_join" class="form-control date_of_join" />
                        </div>

                        <div class="form-group mb-4">
                            <label class="form-label" for="form4Example2">Password</label>
                            <input type="password" name="password" class="form-control" />
                        </div>



                        <div class="form-group mb-4">
                            <label class="form-label" for="form4Example2">Is Present</label>
                            <select name="is_present" class="form-control">
                                <option value="1">YES</option>
                                <option value="0">NO</option>
                            </select>
                        </div>
                    </div>
                </div>
                <!-- Submit button -->
                <button type="submit" class="btn-theme btn-block mb-4 p-2">Create</button>
            </form>
        </div>
    </div>

    @section('scripts')
    {!!JsValidator::formRequest('App\Http\Requests\EmployeeRequest', '#create');!!}
    <script>
        $(document).ready(function(){
                $('.birthday').daterangepicker({
                    "alwaysShowCalendars": true,
                    "singleDatePicker": true,
                    "locale": {
                        "format": "YYYY-MM-DD",
                    },
                    "autoApply": true,
                    "maxDate" : moment(),
                    "showDropdowns": true,
                });

                $('.date_of_join').daterangepicker({
                    "singleDatePicker": true,
                    "locale": {
                        "format": "YYYY-MM-DD",
                    },
                    "autoApply": true,
                    "maxDate" : moment(),
                    "showDropdowns": true,
                });

                $('#profile_img').on('change', function(){
                    var file_length = document.getElementById('profile_img').files.length;
                    $('.preview_img').html('');
                    for(var i = 0; i < file_length; i++){
                        $('.preview_img').append(`<img src='${URL.createObjectURL(event.target.files[i])}' />`)
                    }
                })
            })
    </script>
    @endsection

</x-app-layout>