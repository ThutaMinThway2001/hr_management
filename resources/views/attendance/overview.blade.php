<x-app-layout>
    @section('title')
    <h4>Attendance Overview</h4>
    @endsection

    <div class="card ">
        <div class="card-body ">
            <div class="row mb-4 d-flex justify-content-center align-items-end">
                <div class="col-md-3">
                    <label for="">Name</label>
                    <input type="text" class="form-control employee-name" name="employee_name">
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Month</label>
                        <select name="month" id="" class="form-control select-multiple select-month">
                            <option selected disabled>Choose An Option</option>
                            <option value="01" @if(now()->format('m') == '01') selected @endif>JAN</option>
                            <option value="02" @if(now()->format('m') == '02') selected @endif>FEB</option>
                            <option value="03" @if(now()->format('m') == '03') selected @endif>MAR</option>
                            <option value="04" @if(now()->format('m') == '04') selected @endif>APR</option>
                            <option value="05" @if(now()->format('m') == '05') selected @endif>MAY</option>
                            <option value="06" @if(now()->format('m') == '06') selected @endif>JUN</option>
                            <option value="07" @if(now()->format('m') == '07') selected @endif>JULY</option>
                            <option value="08" @if(now()->format('m') == '08') selected @endif>AGU</option>
                            <option value="09" @if(now()->format('m') == '09') selected @endif>SEP</option>
                            <option value="10" @if(now()->format('m') == '10') selected @endif>OCT</option>
                            <option value="11" @if(now()->format('m') == '11') selected @endif>NOV</option>
                            <option value="12" @if(now()->format('m') == '12') selected @endif>DEC</option>
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label for="">Year</label>
                        <select name="year" id="" class="form-control select-multiple select-year">
                            <option selected disabled>Choose An Option</option>
                            @for($i = 0; $i < 5; $i++)
                                <option value="{{now()->subYear($i)->format('Y')}}" @if(now()->format('Y') == now()->subYear($i)->format('Y')) selected @endif>{{now()->subYear($i)->format('Y')}}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="col-md-3">
                    <button class="btn btn-success btn-block btn-sm search-btn">Search</button>
                </div>
            </div>

            <div class="attendance-overview-table"></div>
        </div>
    </div>
    @section('scripts')
    <script>
        
        overViewTable();
        function overViewTable(month,year,employeeName)
        {
            $.ajax({
                url: `/attendance-overview-table?employeeName=${employeeName}&month=${month}&year=${year}`,
                type: 'GET',
                success: function(response){
                    $('.attendance-overview-table').html(response);
                }
            });
        }

        $('.search-btn').on('click',function(e){
            e.preventDefault();

            var employeeName = $('.employee-name').val();
            console.log(employeeName);
            var month = $('.select-month').val();
            var year = $('.select-year').val();

            overViewTable(month,year,employeeName);
        })
    </script>
    @endsection

</x-app-layout>