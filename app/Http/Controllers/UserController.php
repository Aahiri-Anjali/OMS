<?php

namespace App\Http\Controllers;

use App\DataTables\UserDatatable;
use App\Models\Admin;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:user-view|user-create|user-update|user-delete', ['only' => ['create', 'store', 'edit', 'destroy']]);
        $this->middleware('permission:user-view', ['only' => ['create']]);
        $this->middleware('permission:user-create', ['only' => ['store']]);
        $this->middleware('permission:user-update', ['only' => ['edit']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function create(UserDatatable $datatable)
    {
        $roles = Role::all();
        return $datatable->render('admin.user.list', compact('roles'));
    }

    public function store(Request $request)
    {
        if (isset($request->id) && !empty($request->id)) {
            $user = Admin::where('id', $request->id)->first();
            $user->update([
                'email' => $user->email,
                'password' => $user->password,
                'name' => $request->name,
            ]);
            DB::table('model_has_roles')->where('model_id', $request->id)->delete();
            $user->assignRole($request->input('role'));

            if ($user) {
                return response()->json(['status' => 200, 'data' => 'user updated']);
            } else {
                return response()->json(['status' => 500, 'data' => 'Something went wrong']);
            }
        } else {
            $user = Admin::Create([
                'email' => $request->email,
                'name' => $request->name,
                'password' => Hash::make($request->password),
            ]);
            $user->assignRole($request->input('role'));

            if ($user) {
                return response()->json(['status' => 200, 'data' => 'user inserted']);
            } else {
                return response()->json(['status' => 500, 'data' => 'Something went wrong']);
            }
        }
    }

    public function edit($id)
    {
        if (isset($id) && !empty($id)) {
            $id = Crypt::decryptString($id);
            $user = Admin::find($id);
            $roles = Role::pluck('name', 'name')->all();
            $userRole = $user->roles;
            if ($user) {
                return response()->json(['status' => 200, 'data' => $user, 'roles' => $roles, 'userRole' => $userRole]);
            } else {
                return response()->json(['status' => 500, 'data' => 'Something went wrong']);
            }
        } else {
            return response()->json(['status' => 500, 'data' => 'ID is not correct']);
        }
    }

    public function destroy($id)
    {
        if (isset($id) && !empty($id)) {
            $id = Crypt::decryptString($id);
            $user = Admin::where('id', $id)->first();
            if ($user) {
                $delete = $user->delete();
                if ($delete) {
                    return response()->json(['status' => 200, 'data_table_id' => 'userdatatable-table']);
                } else {
                    return response()->json(['status' => 500, 'data' => 'Something went wrong']);
                }
            } else {
                return response()->json(['status' => 500, 'data' => 'ID is not correct']);
            }
        } else {
            return response()->json(['status' => 500, 'data' => 'ID is not correct']);
        }
    }
}
