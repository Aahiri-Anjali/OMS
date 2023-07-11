<?php

namespace App\Http\Controllers\Role_Permission;

use App\DataTables\RolePermissionDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:role-view|role-create|role-update|role-delete', ['only' => ['create', 'store', 'edit', 'delete']]);
        $this->middleware('permission:role-view', ['only' => ['index']]);
        $this->middleware('permission:role-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:role-update', ['only' => ['edit', 'update']]);
        $this->middleware('permission:role-delete', ['only' => ['delete']]);
    }

    public function index(RolePermissionDatatable $datatable)
    {
        return $datatable->render('role.index');
    }


    public function create()
    {
        $permission_modules = Permission::select('module')
            ->groupBy('module')->get();
        return view('role.create', compact('permission_modules'));
    }

    public function store(RoleRequest $request)
    {
        $role = Role::create(['name' => $request['name']]);
        $permissions = $role->syncPermissions($request['permissions']);
        if (!isset($request['permissions'])) {
            return response()->json(['status' => 400, 'data' => 'Please select at least one permission']);
        }
        if ($role && $permissions) {
            return response()->json(['status' => 200, 'data' => 'Role Created']);
        }
    }

    public function edit($id)
    {
        if (isset($id) && !empty($id)) {
            $id = Crypt::decryptString($id);
            $role = Role::find($id);
            $permission_modules = Permission::select('module')
                ->groupBy('module')->get();
            $permissions = Role::where('id', $id)->first()->permissions;
            $permission_ids = [];
            foreach ($permissions as $permission) {
                array_push($permission_ids, $permission->id);
            }
            return view('role.edit', compact('role', 'permission_modules', 'permission_ids'));
        }
    }

    public function update(RoleRequest $request, $id)
    {
        $id = Crypt::decryptString($id);
        $role = Role::find($id);
        $role->name = $request->input('name');
        $role->save();
        $permissions = $role->syncPermissions($request->permissions);
        if (!isset($request['permissions'])) {
            return response()->json(['status' => 400, 'data' => 'Please select at least one permission']);
        }
        if ($role && $permissions) {
            return response()->json(['status' => 200, 'data' => 'Role Updated']);
        }
    }

    public function delete($id)
    {
        if (isset($id) && !empty($id)) {
            $id = Crypt::decryptString($id);
            $role = Role::where('id', $id)->delete();
            if ($role) {
                return response()->json(['status' => 200, 'data_table_id' => 'rolepermissiondatatable-table']);
            } else {
                return response()->json(['status' => 500, 'data' => 'ID is not correct']);
            }
        } else {
            return response()->json(['status' => 500, 'data' => 'ID is not correct']);
        }
    }
}
