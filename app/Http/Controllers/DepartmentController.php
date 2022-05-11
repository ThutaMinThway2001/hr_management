<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDepartment;
use App\Http\Requests\UpdateDepartment;
use App\Models\Department;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Yajra\Datatables\Datatables as Databases;

class DepartmentController extends Controller
{
    public function index()
    {
        return view('department.index');
    }

    public function ssd()
    {
        $departments = Department::query();
        return Databases::of($departments)
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('fas fa-plus', function ($each) {
                return null;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="' . route('departments.edit', $each->id) . '" class="text-warning"><i class="far fa-edit"></i></a>';
                $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="'.$each->id.'"><i class="fas fa-trash-alt"></i></a>';
                return '<div class="action-icon">' . $edit_icon . $delete_icon .'</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('department.create');
    }

    public function store(StoreDepartment $request)
    {
        $attributes = $request->validated();
        Department::create($attributes);

        return redirect()->route('departments.index')->with('create', 'Department created successfully');
    }

    public function edit(Department $department)
    {
        return view('department.edit', compact('department'));
    }

    public function update(UpdateDepartment $request, Department $department)
    {
        $attributes = $request->validated();
        $department->update($attributes);

        return redirect()->route('departments.index')->with('updated', 'Department Updated Successfully');

    }

    // public function show(Department $department)
    // {
    //     return view('departments.show', compact('department'));
    // }

    public function destroy(Department $department){
        $department->delete();

        return 'success';
    }
}
