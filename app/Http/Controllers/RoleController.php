<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use App\Models\ActivityLog;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $roles = Role::all();

        // Log aktivitas: Melihat daftar role
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'roles',
            'id_referensi' => null, // Tidak ada referensi ID karena ini hanya melihat daftar
            'deskripsi' => 'Melihat daftar peran user',
        ]);

        return view('dashboard.admin.peran_user.index', compact('roles'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $permissions = Permission::all(); // Ambil semua permissions
        return view('dashboard.admin.peran_user.create', compact('permissions'));
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id', // Validasi permission
        ]);

        // Buat role baru
        $role = Role::create(['name' => strtolower($validated['name'])]);

        // Sinkronisasi permissions ke role yang baru
        $role->permissions()->sync($validated['permissions']);

        // Log aktivitas: Menambahkan role baru
        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'tabel_referensi' => 'roles',
            'id_referensi' => $role->id,
            'deskripsi' => 'Menambahkan Peran User Baru: ' . $role->name,
            'created_at' => now(),
        ]);

        Alert::success('Success', 'Tambah Data Peran Berhasil');
        return redirect()->route('dashboard.roles.index')->with('status', 'Data Peran User Berhasil Di Tambah!');
    }



    /**
     * Display the specified resource.
     */
    public function show(Role $role)
    {
        $user = User::all();
        return view('dashboard.admin.peran_user.show', compact('role', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Role $role)
    {
        $permissions = Permission::all();
        return view('dashboard.admin.peran_user.edit', compact('permissions', 'role'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'permissions' => 'required|array',
            'permissions.*' => 'exists:permissions,id', // Validasi permission
        ]);
    
        // Update role name
        $role->update(['name' => strtolower($validated['name'])]);
    
        // Sinkronisasi permissions ke role
        $role->permissions()->sync($validated['permissions']);
    
        // Log aktivitas: Memperbarui role
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'roles',
            'id_referensi' => $role->id,
            'deskripsi' => 'Memperbarui Peran User: ' . $role->name,
            'created_at' => now(),
        ]);
    
        Alert::success('Success', 'Edit Data Peran Berhasil');
        return redirect()->route('dashboard.roles.index')->with('status', 'Data Peran User Berhasil Di Update!');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Role $role)
    {
        // Pastikan tidak ada peran user yang masih terkait dengan penghuni
        $activeRoles = User::where('role_id', $role->id)->get();

        if ($activeRoles->isNotEmpty()) {
            Alert::error('Error', 'Peran User ini masih bersangkutan dengan data pengguna aktif.');
            return redirect()->route('dashboard.roles.index')->with('Error', 'Data Peran User Gagal Di Hapus!');
        }

        // Hapus role
        $role->delete();

        ActivityLog::create([
            'user_id' => auth()->user()->id,
            'tabel_referensi' => 'roles',
            'id_referensi' => $role->id,
            'deskripsi' => 'Hapus Data Peran User',
            'created_at' => now(),
        ]);

        Alert::success('Success', 'Data Peran User Berhasil Dihapus');
        return redirect()->route('dashboard.roles.index')->with('status', 'Data Peran User Berhasil Di Hapus!');
    }
}
