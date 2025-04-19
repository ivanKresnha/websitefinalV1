<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

use App\Models\ActivityLog;  // Pastikan model ActivityLog sudah dibuat

class AuthController extends Controller
{
    /**
     * Tampilkan form login.
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Tangani proses login.
     */
    public function login(Request $request)
{
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();

        // Menambahkan log aktivitas setelah login berhasil
        ActivityLog::create([
            'user_id' => auth()->id(),
            'tabel_referensi' => 'users',
            'id_referensi' => auth()->id(),
            'deskripsi' => 'User login berhasil: ' . auth()->user()->name,
        ]);

        return redirect()->intended('dashboard')->with('success', 'Login berhasil!');
    }

    return back()->withErrors([
        'email' => 'Email atau password salah.',
    ])->onlyInput('email');
}

    

    /**
     * Logout pengguna.
     */
    public function logout(Request $request)
    {
        $user = auth()->user(); // Mendapatkan user yang sedang logout
    
        Auth::logout(); // Menghapus session user
    
        // Menambahkan log aktivitas saat logout
        ActivityLog::create([
            'user_id' => $user->id,
            'tabel_referensi' => 'users',
            'id_referensi' => $user->id,
            'deskripsi' => 'User logout: ' . $user->name,
        ]);
    
        return redirect()->route('landingpage');
    }
    

    /**
     * Tampilkan form register.
     */
    public function showRegistrationForm()
    {
        return view('auth.register'); // Menampilkan form registrasi
    }

    /**
     * Tangani proses registrasi.
     */
    public function register(Request $request)
    {
        // Validasi data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'umur' => 'required|integer|min:18',
            'jenis_kelamin' => 'required|string',
            'alamat' => 'required|string',
            'gambar_profil' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        // Menangani upload gambar profil
        $gambarProfilPath = null;
        if ($request->hasFile('gambar_profil')) {
            $imageName = $request->file('gambar_profil')->getClientOriginalName();
            $gambarProfilPath = $request->file('gambar_profil')->storeAs('uploads/user', $imageName, 'public');
        }
    
        // Membuat pengguna baru dengan role_id = 2 (customer)
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => 2, // Role customer
            'umur' => $validated['umur'],
            'jenis_kelamin' => $validated['jenis_kelamin'],
            'alamat' => $validated['alamat'],
            'gambar_profil' => $imageName,
        ]);
    
        // Login otomatis setelah registrasi
        Auth::login($user);
    
        // Menambahkan log aktivitas setelah registrasi
        ActivityLog::create([
            'user_id' => $user->id,
            'tabel_referensi' => 'users',
            'id_referensi' => $user->id,
            'deskripsi' => 'User registrasi baru: ' . $user->name,
        ]);
    
        return redirect()->route('admin.dashboard')->with('success', 'Akun berhasil dibuat!');
    }
    
    
}
