<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    public function index()
    {
        $permissions = Permission::all();
        return view('roles-permission.permission.index', compact('permissions'));
    }

    public function create()
    {
        return view('roles-permission.permission.create');
    }

    public function store(Request $request)
    {
        $request->validate(['name' => ['required', 'string', 'unique:permissions,name']]);
        Permission::create([
            "name" => $request->name
        ]);
        return redirect('permissions')->with('status', "Permission created successfully");
    }

    public function edit($id)
    {
        $permission = Permission::findOrFail($id);
        return view('roles-permission.permission.edit', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate(['name' => ['required', 'string', 'unique:permissions,name,' . $id]]);
        $permission = Permission::findOrFail($id);
        $permission->update([
            "name" => $request->name
        ]);
        return redirect('permissions')->with('status', "Permission updated successfully");
    }

    public function destroy($id)
    {
        $permission = Permission::findOrFail($id);
        $permission->delete();
        return redirect('permissions')->with('status', "Permission deleted successfully");
    }
}
