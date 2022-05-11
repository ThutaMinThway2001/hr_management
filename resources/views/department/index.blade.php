<x-app-layout>
    @section('title')
    <h4>Employee</h4>
    @endsection

    <div class="mb-4">
        <a href="{{route('departments.create')}}" class="btn-theme btn-sm p-2">
            <i class="fas fa-plus"></i> Create Department
        </a>
    </div>

    <div class="card ">
        <div class="card-body ">
            <table class="table table-bordered Datatable " style="width:100%;">
                <thead>
                    <th class="text-center no-order no-search"></th>
                    <th class="text-center">Title</th>
                    <th class="text-center no-order no-search">Action</th>
                    <th class="text-center hidden no-sort no-search ">Updated at</th>
                </thead>

            </table>
        </div>
    </div>
    @section('scripts')
    <script>

        $(document).ready(function(){
            
            var table = $('.Datatable').DataTable({
                    processing: true,
                    serverSide: true,
                    responsive: true,
                    ajax: 'department/datatable/ssd',
                    columns: [
                        { data: 'fas fa-plus', name: 'fas fa-plus', class: 'text-center'},
                        { data: 'title', name: 'title', class: 'text-center' },
                        { data: 'action', name: 'action', class: 'text-center' },
                        { data: 'updated_at', name: 'updated_at', class: 'text-center'}

                ],
                order: [[3, 'desc']],
                "columnDefs": [
                    {
                        "targets": [ 3 ],
                        "visible": false
                    },
                    {
                        'targets': [0],
                        'class': 'control'
                    },
                    {
                        'targets': 'no-order',
                        'orderable': false
                    },
                    {
                        "targets": 'no-search',
                        'searchable': false
                    },
                    {
                        "targets": 'hidden',
                        'visible': false
                    }
                ],
                "language": {
                    "paginate": {
                    "previous": "<i class='fas fa-angle-left'></i>",
                    "next": "<i class='fas fa-angle-right'></i>"
                    },
                    "processing": "<img src='/image/loading.gif' style='width: 50%; height: 50%;  text-align: center;' />"
                }
            });

            $(document).on('click', '.delete-btn', function(event){
                event.preventDefault();
                var id = $(this).data('id');
                

                swal({
                    title: "Are you sure?",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    })
                    .then((willDelete) => {
                    if (willDelete) {
                        $.ajax({
                            method: "DELETE",
                            url: `/departments/${id}`,
                            data: { name: "John", location: "Boston" }
                            })
                            .done(function( response ) {
                                table.ajax.reload();
                            });
                    }
                    });
            })

        })
    </script>
    @endsection

</x-app-layout>