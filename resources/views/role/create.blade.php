<x-app-layout>
    @section('title')
    <h4>Create Role</h4>
    @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{route('roles.store')}}" method="POST" id="create">
                @csrf
                <div class="row">              
                    <div class="col-md-12 pt-4">
                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <input type="text" name="name" id="form4Example1" class="form-control" />
                            <label class="form-label" for="form4Example1">Role</label>
                        </div>                             

                    </div>

                    <div class="row"> 
                        <label for="">Permissions</label>
                        @foreach ($permissions as $permission)
                        <div class="col-md-4 p-3">          
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="permissions[]" id="permission_{{$permission->id}}" value="{{$permission->name}}" />
                                <label class="form-check-label" for="permission_{{$permission->id}}">{{$permission->name}}</label>
                            </div>
                        </div>
                        @endforeach
                    </div>      
                </div>
                <!-- Submit button -->
                <button type="submit" class="btn-theme btn-block mb-4 p-2">Create</button>
            </form>
        </div>
    </div>

    @section('scripts')
    {!!JsValidator::formRequest('App\Http\Requests\StoreRole', '#create');!!}
    <script>
        $(document).ready(function(){

            })
    </script>
    @endsection

</x-app-layout>