<x-app-layout>
    @section('title')
    <h4>Create Permissions</h4>
    @endsection

    <div class="card">
        <div class="card-body">
            <form action="{{route('permissions.store')}}" method="POST" id="create">
                @csrf
                <div class="row">
                    <div class="col-md-12 pt-4">
                        <!-- Name input -->
                        <div class="form-outline mb-4">
                            <input type="text" name="name" id="form4Example1" class="form-control" />
                            <label class="form-label" for="form4Example1">Permissions</label>
                        </div>
                    </div>
                </div>
                <!-- Submit button -->
                <button type="submit" class="btn-theme btn-block mb-4 p-2">Create</button>
            </form>
        </div>
    </div>

    @section('scripts')
    {!!JsValidator::formRequest('App\Http\Requests\StorePermission', '#create');!!}
    <script>
        $(document).ready(function(){

            })
    </script>
    @endsection

</x-app-layout>