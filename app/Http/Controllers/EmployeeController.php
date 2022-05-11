<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables as Databases;

class EmployeeController extends Controller
{
    public function index()
    {
        return view('employee.index');
    }

    public function ssd()
    {
        $employees = User::with('department');
        return Databases::of($employees)
            ->filterColumn('department_name', function($query, $search){
                $query->whereHas('department', function($query) use($search) {
                    $query->where('title', 'LIKE', '%'.$search.'%');
                });
            })
            ->editColumn('profile_img', function($employee){
                return '<img src="'. $employee->profile_img_path() .'" alt="" class="profile-thumbnail"><p class="mb-1">'.$employee->name.'</p>';
            })
            ->addColumn('department_name', function ($employee) {
                return $employee->department ? $employee->department->title : '-';
            })
            ->editColumn('is_present', function ($employee) {
                if ($employee->is_present === 1) {
                    return '<span class="badge badge-success rounded-pill p-2">Present</span>';
                } else {
                    return '<span class="badge rounded-pill badge-danger p-2">Absent</span>';
                }
            })
            ->editColumn('updated_at', function ($employee) {
                return Carbon::parse($employee->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('fas fa-plus', function ($employee) {
                return null;
            })
            ->addColumn('action', function ($employee) {
                $edit_icon = '<a href="' . route('employee.edit', $employee->id) . '" class="text-warning"><i class="far fa-edit"></i></a>';
                $info_icon = '<a href="' . route('employee.show', $employee->id) . '" class="text-primary"><i class="fas fa-info-circle"></i></a>';
                $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="'.$employee->id.'"><i class="fas fa-trash-alt"></i></a>';
                return '<div class="action-icon">' . $edit_icon . $info_icon . $delete_icon .'</div>';
            })
            ->rawColumns(['profile_img','is_present', 'action'])
            ->make(true);
    }

    public function create()
    {
        $departments = Department::orderBy('title')->get();

        return view('employee.create', compact('departments'));
    }

    public function store(EmployeeRequest $request)
    {
        $attributes = $request->validated();
        $attributes['profile_img'] = $request->file('profile_img')->store('employee');
        User::create($attributes);

        return redirect()->route('employee.index')->with('create', 'Employee created successfully');
    }

    public function edit(User $employee)
    {
        $departments = Department::orderBy('title')->get();
        return view('employee.edit', compact('employee', 'departments'));
    }

    public function update(EmployeeUpdateRequest $request, User $employee)
    {
        $attributes = $request->validated();

        if($request->hasFile('profile_img')){
            Storage::delete('storage/' .$employee->profile_img);

            $attributes['profile_img'] = $request->file('profile_img')->store('employee');
        }

        $employee->update($attributes);
        return redirect()->route('employee.index')->with('updated', 'Updated At Successfully');

    }

    public function show(User $employee)
    {
        return view('employee.show', compact('employee'));
    }

    public function destroy(User $employee){
        $employee->delete();

        return 'success';
    }
}
