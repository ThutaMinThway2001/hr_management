<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttendance;
use App\Http\Requests\StoreDepartment;
use App\Http\Requests\UpdateAttendance;
use App\Http\Requests\UpdateDepartment;
use App\Models\CheckinCheckout;
use App\Models\CompanySetting;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Http\Request;
use Yajra\Datatables\Datatables as Databases;

class AttendanceController extends Controller
{
    public function index()
    {
        if(!auth()->user()->can('view_attendance')) {
            abort(403, 'message');
        }

        return view('attendance.index');
    }

    public function ssd()
    {
        $attendances = CheckinCheckout::with('employee');
        return Databases::of($attendances)
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('fas fa-plus', function ($each) {
                return null;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="' . route('attendances.edit', $each->id) . '" class="text-warning"><i class="far fa-edit"></i></a>';
                $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="'.$each->id.'"><i class="fas fa-trash-alt"></i></a>';
                return '<div class="action-icon">' . $edit_icon . $delete_icon .'</div>';
            })
            ->addColumn('employee_name',function($each){
                return $each->employee ? $each->employee->name : '-';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        if(!auth()->user()->can('create_attendance')) {
            abort(403, 'message');
        }
        $employees = User::orderBy('employee_id')->get()->pluck('name','id');
        
        return view('attendance.create', compact('employees'));
    }

    public function store(StoreAttendance $request)
    {
        if(!auth()->user()->can('create_attendance')) {
            abort(403, 'message');
        }
        
        if(CheckinCheckout::where('user_id', $request->user_id)->where('date', $request->date)->exists())
        {
            return back()->withErrors(['failed'=> 'Already Defined'])->withInput();
        }

        $attributes = $request->validated();


        $attributes['checkin_time'] = $attributes['date'] . ' ' . $attributes['checkin_time'];
        $attributes['checkout_time'] = $attributes['date'] . ' ' . $attributes['checkout_time'];

        CheckinCheckout::create($attributes);

        return redirect()->route('attendances.index')->with('create', 'Attendance created successfully');
    }

    public function edit($id)
    {
        if(!auth()->user()->can('edit_attendance')) {
            abort(403, 'message');
        }

        $attendance = CheckinCheckout::findOrFail($id);
        $employees = User::orderBy('employee_id')->get();

        return view('attendance.edit', compact('attendance', 'employees'));
    }

    public function update(UpdateAttendance $request, $id)
    {
        $attendance = CheckinCheckout::findOrFail($id);

        if(CheckinCheckout::where('user_id', $request->user_id)->where('date', $request->date)->where('id', '!=', $attendance->id)->exists())
        {
            return back()->withErrors(['failed'=> 'Already Defined'])->withInput();
        }

        $attributes = $request->validated();
        $attributes['checkin_time'] = $attributes['date'] . ' ' . $attributes['checkin_time'];
        $attributes['checkout_time'] = $attributes['date'] . ' ' . $attributes['checkout_time'];

        $attendance->update($attributes);

        return redirect()->route('attendances.index')->with('updated', 'Attendances Updated Successfully');

    }

    public function destroy(Department $department){
        if(!auth()->user()->can('delete_department')) {
            abort(403, 'message');
        }
        $department->delete();

        return 'success';
    }

    public function overview(Request $request)
    {
        return view('attendance.overview');
    }

    public function overviewTable(Request $request)
    {
        $month = $request->month;
        $year = $request->year;
        $name = $request->employeeName;

        //2022-1-1
        $start_month = $year. '-' .$month. '-' .'01';
        $end_month = Carbon::parse($start_month)->endOfMonth()->format('Y-m-d');

        $periods = new CarbonPeriod($start_month,$end_month);
        $employees = User::orderBy('employee_id')->where('name','LIKE','%'. $name .'%')->get();
        $attendances = CheckinCheckout::whereMonth('date',$month)->whereYear('date',$year)->get();
        $company_setting = CompanySetting::findOrFail(1);


        return view('components.overview-table', compact('periods', 'employees', 'attendances', 'company_setting'));
    }
}
