<x-app-layout>
    @section('title')
    <h4>Profile</h4>
    @endsection

    <div class="card">
        <div class="card-body">
            <div class="row">

                <div class="col-md-6">
                    <div class="text-center">
                        <img src="{{$employee->profile_img_path()}}" alt="" style="width:100px; height: 100px; border-radius: 100%; border: 1px solid green; padding: 3px; display:inline;" />
                        <div class="py-3 px-2">
                            <h2><span>{{$employee->name}}</span> | <span class="text-success" style="font-size: 20px;">{{$employee->phone}}</span></h2>
                            <p class="text-muted mb-1">{{$employee->employee_id}}</p>
                            <p class="text-muted mb-1"><span class="badge rounded-pill badge-dark">{{$employee->department? $employee->department->title : '-'}}</span></p>
                            <p class="text-muted mb-1">
                                @foreach ($employee->roles as $role)
                                <span class="badge badge-primary">
                                    {{$role->name}}
                                </span>
                                @endforeach
                            </p>
                        </div>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="dash-border px-4">
                        <p class="mb-1"><strong>Email</strong> : <span class="text-muted">{{$employee->email}}</span></p>
                        <p class="mb-1"><strong>Phone</strong> : <span class="text-muted">{{$employee->phone}}</span></p>
                        <p class="mb-1"><strong>NRC Number</strong> : <span class="text-muted">{{$employee->nrc_number}}</span></p>
                        <p class="mb-1"><strong>Birthday</strong> : <span class="text-muted">{{$employee->birthday}}</span></p>
                        <p class="mb-1"><strong>Gender</strong> : <span class="text-muted">{{$employee->gender}}</span></p>
                        <p class="mb-1"><strong>Address</strong> : <span class="text-muted">{{$employee->address}}</span></p>
                        <p class="mb-1"><strong>Date of join</strong> : <span class="text-muted">{{$employee->date_of_join}}</span></p>
                        <p class="mb-0"><strong> Is Present </strong> : <span class="text-muted">@if ($employee->is_present === 1)
                            <span class="badge badge-pill badge-success">Present</span>
                            @else
                            <span class="badge badge-pill badge-danger">Leave</span>
                            @endif</span></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <h4>Biometric Authentication</h4>
            <form id="biometric-register-form">
                <button type="submit" class="biometric-register-btn">
                    <i class="fas fa-fingerprint"></i>
                    <i class="fas fa-plus-circle"></i>
                </button>
            </form>
        </div>
    </div>

    <div class="card mt-3">
        <div class="card-body">
            <a href="#" class="btn btn-danger btn-block logout-btn " id="#logout-btn">
                Logout
            </a >
        </div>
    </div>
 
    @section('scripts')
        <script>
            $(document).ready(function(){

                const register = (event) => {
                    event.preventDefault()
                    new Larapass({
                        register: 'webauthn/register',
                        registerOptions: 'webauthn/register/options'
                    }).register()
                    .then(function(response){
                        Swal.fire(
                        'Updated Successfully',
                        'You clicked the button!',
                        'success'
                        )
                    })
                    .catch(function(response){
                        console.log(response)
                    })
                }

                document.getElementById('biometric-register-form').addEventListener('submit', register)

                $(document).on('click', '.logout-btn', function(event){
                    event.preventDefault();

                    swal({
                    title: "Are you sure?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                        url: '/logout',
                        type: 'POST'
                    }).done(function(response){
                        window.location.replace('/profile');
                    })
                    }
                    });


                })
        });
        </script>
    @endsection

</x-app-layout>