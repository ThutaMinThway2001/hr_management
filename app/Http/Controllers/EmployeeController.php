<?php

namespace App\Http\Controllers;

use App\Http\Requests\EmployeeRequest;
use App\Http\Requests\EmployeeUpdateRequest;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables as Databases;

class EmployeeController extends Controller
{
    public function index()
    {
        if(!User::find(auth()->user())->can('view_employee')) {
            abort(403, 'message');
        }
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
            ->addColumn('role_name', function ($employee) {
                $output = '';

                foreach($employee->roles as $role){
                    $output .= '<span class="badge rounded-pill badge-primary">'.$role->name.'</span>';
                }
                return $output;
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
                $edit_icon = '';
                $info_icon = '';
                $delete_icon = '';

                if(User::find(auth()->user())->can('edit_employee')) {
                    $edit_icon = '<a href="' . route('employee.edit', $employee->id) . '" class="text-warning"><i class="far fa-edit"></i></a>';
                }

                if(User::find(auth()->user())->can('view_employee')) {
                    $info_icon = '<a href="' . route('employee.show', $employee->id) . '" class="text-primary"><i class="fas fa-info-circle"></i></a>';
                }

                if(User::find(auth()->user())->can('delete_employee')) {
                    $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="'.$employee->id.'"><i class="fas fa-trash-alt"></i></a>';
                }

                return '<div class="action-icon">' . $edit_icon . $info_icon . $delete_icon .'</div>';
            })
            ->rawColumns(['profile_img','is_present', 'action', 'role_name'])
            ->make(true);
    }

    public function create()
    {
        if(!User::find(auth()->user())->can('create_employee')) {
            abort(403, 'message');
        }
        $departments = Department::orderBy('title')->get();
        $roles = Role::all();

        return view('employee.create', compact('departments', 'roles'));
    }

    public function store(EmployeeRequest $request)
    {
        // dd(request()->all());
        $attributes = $request->validated();
        $attributes['profile_img'] = $request->file('profile_img')->store('employee');
        $user = User::create($attributes);

        $user->syncRoles($request->roles);

        return redirect()->route('employee.index')->with('create', 'Employee created successfully');
    }

    public function edit(User $employee)
    {
        if(!User::find(auth()->user())->can('edit_department')) {
            abort(403, 'message');
        }
        $departments = Department::orderBy('title')->get();
        $old_roles = $employee->roles->pluck('id')->toArray();
        $roles = Role::all();
        return view('employee.edit', compact('employee', 'departments', 'old_roles', 'roles'));
    }

    public function update(EmployeeUpdateRequest $request, User $employee)
    {
        // dd(request()->all());
        $attributes = $request->validated();

        if($request->hasFile('profile_img')){
            Storage::delete('storage/' .$employee->profile_img);

            $attributes['profile_img'] = $request->file('profile_img')->store('employee');
        }
        $employee->update($attributes);
        
        $employee->syncRoles($request->roles);

        return redirect()->route('employee.index')->with('updated', 'Updated At Successfully');

    }

    public function show(User $employee)
    {
        if(!User::find(auth()->user())->can('edit_employee')) {
            abort(403, 'message');
        }
        return view('employee.show', compact('employee'));
    }

    public function destroy(User $employee){
        if(!User::find(auth()->user())->can('delete_employee')) {
            abort(403, 'message');
        }
        $employee->delete();

        return 'success';
    }
}
