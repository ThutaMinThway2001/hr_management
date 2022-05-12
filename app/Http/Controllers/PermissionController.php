<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePermission;
use App\Http\Requests\StoreRole;
use App\Http\Requests\UpdatePermission;
use App\Http\Requests\UpdateRole;

use Carbon\Carbon;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Yajra\Datatables\Datatables as Databases;

class PermissionController extends Controller
{
    public function index()
    {
        return view('permission.index');
    }

    public function ssd()
    {
        $permissions = Permission::query();
        return Databases::of($permissions)
            ->editColumn('updated_at', function ($each) {
                return Carbon::parse($each->updated_at)->format('Y-m-d H:i:s');
            })
            ->addColumn('fas fa-plus', function ($each) {
                return null;
            })
            ->addColumn('action', function ($each) {
                $edit_icon = '<a href="' . route('permissions.edit', $each->id) . '" class="text-warning"><i class="far fa-edit"></i></a>';
                $delete_icon = '<a href="#" class="text-danger delete-btn" data-id="'.$each->id.'"><i class="fas fa-trash-alt"></i></a>';
                return '<div class="action-icon">' . $edit_icon . $delete_icon .'</div>';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create()
    {
        return view('permission.create');
    }

    public function store(StorePermission $request)
    {
        $attributes = $request->validated();
        Permission::create($attributes);

        return redirect()->route('permissions.index')->with('create', 'Permission created successfully');
    }

    public function edit(Permission $permission)
    {
        return view('permission.edit', compact('permission'));
    }

    public function update(UpdatePermission $request, Permission $permission)
    {
        $attributes = $request->validated();
        $permission->update($attributes);

        return redirect()->route('permissions.index')->with('updated', 'Permission Updated Successfully');

    }

    public function destroy(Permission $permission){
        $permission->delete();

        return 'success';
    }
}
