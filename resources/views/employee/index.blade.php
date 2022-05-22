<x-app-layout>
    @section('title')
    <h4>Employee</h4>
    @endsection

    <div class="mb-4">
        <a href="{{route('employee.create')}}" class="btn-theme btn-sm p-2">
            <i class="fas fa-plus"></i> Create Employee
        </a>
    </div>

    <div class="card ">
        <div class="card-body ">
            <table class="table table-bordered Datatable " style="width:100%;">
                <thead>
                    <th class="text-center no-order no-search"></th>
                    <th class="text-center no-order no-search"></th>
                    <th class="text-center">Employee ID</th>
                    <th class="text-center">Phone</th>
                    <th class="text-center">Email</th>
                    <th class="text-center">Department</th>
                    <th class="text-center">Role</th>
                    <th class="text-center">Is_Present?</th>
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
                    ajax: 'employee/datatable/ssd',
                    columns: [
                        { data: 'fas fa-plus', name: 'fas fa-plus', class: 'text-center'},
                        { data: 'profile_img', name: 'profile_img', class: 'text-center' },
                        { data: 'employee_id', name: 'employee_id', class: 'text-center' },
                        { data: 'phone', name: 'phone', class: 'text-center' },
                        { data: 'email', name: 'email', class: 'text-center' },
                        { data: 'department_name', name: 'department_name', class: 'text-center' },
                        { data: 'role_name', name: 'role_name', class: 'text-center' },
                        { data: 'is_present', name: 'is_present', class: 'text-center' },
                        { data: 'action', name: 'action', class: 'text-center' },
                        { data: 'updated_at', name: 'updated_at', class: 'text-center'}

                ],
                order: [[8, 'desc']],
                "columnDefs": [
                    {
                        "targets": [ 9, 7 ],
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
                            url: `/employee/${id}`,
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