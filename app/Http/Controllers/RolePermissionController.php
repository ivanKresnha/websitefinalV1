<?php

namespace App\Http\Controllers;

use App\Models\RolePermission;
use Illuminate\Http\Request;

class RolePermissionController extends Controller
{
    public function index()
    {
        $rolePermissions = RolePermission::all();
        return response()->json($rolePermissions);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'permission_id' => 'required|exists:permissions,id',
        ]);
        $rolePermission = RolePermission::create($validated);
        return response()->json($rolePermission, 201);
    }

    public function destroy(RolePermission $rolePermission)
    {
        $rolePermission->delete();
        return response()->json(['message' => 'RolePermission deleted successfully']);
    }
}
