<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */
    public function showRegistrationForm()
    {
        return view('auth.register'); // Sesuaikan dengan nama view register yang Anda buat
    }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
  
     
     public function register(Request $request)
{
    // Validasi input
    $validated = $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'umur' => 'required|integer',
        'jenis_kelamin' => 'required|string',
        'alamat' => 'required|string',
        'gambar_profil' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048', // Max size 2MB
    ]);

    // Menyimpan gambar profil jika ada
    $imagePath = null;
    if ($request->hasFile('gambar_profil')) {
        // Dapatkan nama asli file gambar
        $imageName = $request->file('gambar_profil')->getClientOriginalName();
        
        // Simpan gambar dengan nama asli di folder 'uploads/user' dalam 'public/storage'
        $imagePath = $request->file('gambar_profil')->storeAs('uploads/user', $imageName, 'public');
    }

    // Menyimpan data pengguna
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'umur' => $request->umur,
        'jenis_kelamin' => $request->jenis_kelamin,
        'alamat' => $request->alamat,
        'gambar_profil' => $imagePath,
        'role_id' => Role::where('name', 'user')->first()->id, // Sesuaikan dengan role yang Anda miliki
    ]);

    // Mengirimkan email verifikasi jika Anda ingin menggunakan verifikasi email
    // $user->sendEmailVerificationNotification();

    // Redirect ke halaman login setelah berhasil register
    return redirect()->route('login')->with('success', 'Pendaftaran berhasil, silakan login!');
}

    

    /**
     * Show the login form after successful registration.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('auth.login'); // Sesuaikan dengan nama view login yang Anda buat
    }
}
