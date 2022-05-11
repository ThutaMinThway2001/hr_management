<x-app-layout>
    @section('title')
    <h4>HR_MANAGEMENT</h4>
    @endsection

    <div class="card">
        <div class="card-body">
            <div class="row">

                <div class="col-md-12">
                    <div class="text-center">
                        <img src="{{$employee->profile_img_path()}}" alt="" style="width:100px; height: 100px; border-radius: 100%; border: 1px solid green; padding: 3px; display:inline;" />
                        <div class="py-3 px-2">
                            <h2><span>{{$employee->name}}</span> | <span class="text-success" style="font-size: 20px;">{{$employee->phone}}</span></h2>
                            <p class="text-muted mb-1">{{$employee->employee_id}}</p>
                            <p class="text-muted mb-1"><span class="badge rounded-pill badge-dark">{{$employee->department? $employee->department->title : '-'}}</span></p>

                        </div>
                    </div>

                </div>

            </div>
        </div>
    </div>
</x-app-layout>