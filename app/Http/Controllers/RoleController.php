<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRole;
use App\Http\Requests\UpdateRole;

use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
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
            ->addColumn('permissions', function ($each) {
                $output = '';

                foreach($each->permissions as $permission){
                    $output .= '<span class="badge rounded-pill badge-primary">'.$permission->name.'</span>';
                }

                return $output;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="' . route('roles.edit', $each->id) . '" class="text-warning"><i class="far fa-edit"></i></a>';
                $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="'.$each->id.'"><i class="fas fa-trash-alt"></i></a>';
                return '<div class="action-icon">' . $edit_icon . $delete_icon .'</div>';
            })
            ->rawColumns(['action', 'permissions'])
            ->make(true);
    }

    public function create()
    {
        $permissions = Permission::all();
        return view('role.create', compact('permissions'));
    }

    public function store(StoreRole $request)
    {
        $attributes = $request->validated();
        $role = Role::create($attributes);
        $role->givePermissionTo($request->permissions);

        return redirect()->route('roles.index')->with('create', 'Role created successfully');
    }

    public function edit(Role $role)
    {
        $old_permissions = $role->permissions->pluck('id')->toArray();
        $permissions = Permission::all();
        return view('role.edit', compact('role', 'permissions', 'old_permissions'));
    }

    public function update(UpdateRole $request, Role $role)
    {
        $old_permissions = $role->permissions->pluck('id');
        
        $role->revokePermissionTo($old_permissions);
        
        $attributes = $request->validated();
        $role->update($attributes);

        $role->givePermissionTo($request->permissions);

        return redirect()->route('roles.index')->with('updated', 'Role Updated Successfully');

    }

    public function destroy(Role $role){
        $role->delete();

        return 'success';
    }
}
