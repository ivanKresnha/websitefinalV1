<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\ActivityLog;  // Pastikan model ActivityLog sudah dibuat
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{ 
    // Menampilkan daftar semua user
    public function index()
    {
        $users = User::with('role')->get(); // Mengambil semua user dengan relasi role
        return view('dashboard.admin.user.index', compact('users'));
    }

    // Menampilkan form untuk menambah user
    public function create()
    {
        $roles = Role::all(); // Menampilkan daftar roles
        return view('dashboard.admin.user.create', compact('roles'));
    }

    // Menyimpan user baru
    public function store(Request $request)
    {
        // Validasi input
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id', // Validasi role
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'umur' => 'required|integer',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'gambar_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi file gambar
        ]);

        // Handle file upload
        if ($request->hasFile('gambar_profil')) {
            $originalFileName = $request->file('gambar_profil')->getClientOriginalName();
            $filePath = $request->file('gambar_profil')->storeAs('uploads/user', $originalFileName, 'public');
            $validated['gambar_profil'] = $originalFileName;
        }

        // Menambahkan user baru
        $validated['password'] = Hash::make($validated['password']);
        $user = User::create($validated);

        // Menambahkan log aktivitas
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'users',
            'id_referensi' => $user->id,
            'deskripsi' => 'User baru ditambahkan: ' . $user->name,
        ]);

        return redirect()->route('dashboard.users.index')->with('success', 'User berhasil ditambahkan.');
    }

    // Menampilkan form untuk mengedit user
    public function edit(User $user)
    {
        $roles = Role::all(); // Menampilkan daftar roles
        return view('dashboard.admin.user.edit', compact('user', 'roles'));
    }

    // Memperbarui data user
    public function update(Request $request, User $user)
    {
        // Validasi input
        $validated = $request->validate([
            'role_id' => 'required|exists:roles,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'umur' => 'required|integer',
            'jenis_kelamin' => 'required|in:Laki-laki,Perempuan',
            'alamat' => 'required|string',
            'gambar_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048', // Validasi file gambar
        ]);

        // Handle file upload untuk gambar
        if ($request->hasFile('gambar_profil')) {
            // Menghapus gambar lama jika ada
            if ($user->gambar_profil && Storage::exists('public/uploads/user/' . $user->gambar_profil)) {
                Storage::delete('public/uploads/user/' . $user->gambar_profil);
            }

            $originalFileName = $request->file('gambar_profil')->getClientOriginalName();
            $filePath = $request->file('gambar_profil')->storeAs('uploads/user', $originalFileName, 'public');
            $validated['gambar_profil'] = $originalFileName;
        }

        // Jika password diisi, hash dan simpan
        if ($request->filled('password')) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            // Jika password tidak diisi, kita biarkan nilai password lama tetap
            $validated['password'] = $user->password;
        }

        // Memperbarui data user
        $user->update($validated);

        // Menambahkan log aktivitas
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'users',
            'id_referensi' => $user->id,
            'deskripsi' => 'User diperbarui: ' . $user->name,
        ]);

        return redirect()->route('dashboard.users.index')->with('success', 'User berhasil diperbarui.');
    }

    // Menampilkan detail user
    public function show(User $user)
    {
        return view('dashboard.admin.user.show', compact('user'));
    }

    // Menghapus user
    public function destroy(User $user)
{
    // Cek apakah user terkait dengan data transaksi
    if ($user->transactions()->exists()) {
        // Jika ada transaksi terkait, tampilkan pesan error
        return redirect()->route('dashboard.users.index')
            ->with('error', 'User tidak dapat dihapus karena memiliki transaksi terkait.');
    }

    // Menyimpan log aktivitas sebelum menghapus user
    ActivityLog::create([
        'user_id' => auth()->id(),
        'tabel_referensi' => 'users',
        'id_referensi' => $user->id,
        'deskripsi' => 'User dihapus: ' . $user->name,
    ]);

    // Menghapus user (pastikan jika perlu, hapus data terkait transaksi terlebih dahulu)
    // Jika ingin menghapus transaksi terkait, Anda bisa melakukannya di sini
    // $user->transactions()->delete();

    // Hapus user
    $user->delete();

    return redirect()->route('dashboard.users.index')
        ->with('success', 'User berhasil dihapus.');
}

}
