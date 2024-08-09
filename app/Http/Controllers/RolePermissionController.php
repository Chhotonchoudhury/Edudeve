<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionController extends Controller
{
  public function index(Request $request)
  {
    $search = $request->query('search');

    $roles = Role::with('permissions')
      ->where('name', 'LIKE', "%{$search}%")
      ->orWhereHas('permissions', function ($query) use ($search) {
        $query->where('name', 'LIKE', "%{$search}%");
      })
      ->paginate(10);
    $permissions = Permission::all();
    return view('roles-permissions.index', compact('roles', 'permissions'));

    // $search = $request->input('search');
    // $roles = Role::where('name', 'like', "%{$search}%")
    //   ->with('permissions')
    //   ->paginate(10); // Number of items per page

    // return view('roles-permissions.index', compact('roles'));

    // $roles = Role::paginate(10);
    // return view('roles-permissions.index', compact('roles'));
  }

  public function edit($id)
  {
    $role = Role::with('permissions')->findOrFail($id);
    $permissions = Permission::all(); // Fetch all permissions

    return response()->json([
      'role' => $role,
      'permissions' => $permissions,
    ]);
  }

  public function update(Request $request, $id)
  {
    $role = Role::findOrFail($id);
    $role->name = $request->input('role_name');
    $role->permissions()->sync($request->input('permissions', [])); // Sync permissions with the role

    return response()->json(['success' => true]);
  }
}
