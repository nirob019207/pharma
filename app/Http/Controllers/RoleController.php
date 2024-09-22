<?php
namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use DB;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function index()
    {
        $roles = Role::all();
        return view('roles-permission.role.index', compact('roles'));
    }

    public function create()
    {
        return view('roles-permission.role.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => ['required', 'string', 'unique:roles,name']]);
        Role::create([
            "name" => $request->name
        ]);
        return redirect('roles')->with('status', "Role created successfully");
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);
        return view('roles-permission.role.edit', compact('role'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => ['required', 'string', 'unique:roles,name,' . $id]]);
        $role = Role::findOrFail($id);
        $role->update([
            "name" => $request->name
        ]);
        return redirect('roles')->with('status', "Role updated successfully");
    }

    public function destroy($id)
    {
        $role = Role::findOrFail($id);
        $role->delete();
        return redirect('roles')->with('status', "Role deleted successfully");
    }

    public function givePermission($roleId)
    {
        $permissions = Permission::get();
        $role = Role::findOrFail($roleId);
        $rolePermissions = DB::table('role_has_permissions')
            ->where('role_has_permissions.role_id', $role->id)
            ->pluck('role_has_permissions.permission_id')
            ->toArray();

        return view('roles-permission.role.add-permission', [
            'role' => $role,
            'permissions' => $permissions,
            'rolePermissions' => $rolePermissions
        ]);
    }

    public function updatePermissions(Request $request, $roleId)
    {
        $role = Role::findOrFail($roleId);
        $role->syncPermissions($request->permission);
        return redirect()->back()->with('status', "Permission updated successfully");
    }
}
