<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRole;
use App\Http\Requests\UpdateRole;

use Carbon\Carbon;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables as Databases;

class RoleController extends Controller
{
    public function index()
    {
        return view('role.index');
    }

    public function ssd()
    {
        $roles = Role::query();
        return Databases::of($roles)
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('fas fa-plus', function ($each) {
                return null;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="' . route('roles.edit', $each->id) . '" class="text-warning"><i class="far fa-edit"></i></a>';
                $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="'.$each->id.'"><i class="fas fa-trash-alt"></i></a>';
                return '<div class="action-icon">' . $edit_icon . $delete_icon .'</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('role.create');
    }

    public function store(StoreRole $request)
    {
        $attributes = $request->validated();
        Role::create($attributes);

        return redirect()->route('roles.index')->with('create', 'Role created successfully');
    }

    public function edit(Role $role)
    {
        return view('role.edit', compact('role'));
    }

    public function update(UpdateRole $request, Role $role)
    {
        $attributes = $request->validated();
        $role->update($attributes);

        return redirect()->route('roles.index')->with('updated', 'Role Updated Successfully');

    }

    // public function show(Department $department)
    // {
    //     return view('departments.show', compact('department'));
    // }

    public function destroy(Role $role){
        $role->delete();

        return 'success';
    }
}
