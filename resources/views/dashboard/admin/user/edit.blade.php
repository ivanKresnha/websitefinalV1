@extends('layout.admin.index')

@section('title', 'EDIT USER | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-start align-items-center pt-3 pb-3">
                        <h3 class="fw-bold">Edit User</h3>
                    </div>
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Form Edit Data User</h4>
                        </div>
                        <div class="card-body">
                            <form id="formEditUser" method="POST" action="{{ route('dashboard.users.update', $user->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <!-- Nama User -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="name">Nama</label>
                                            <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $user->name) }}" placeholder="Masukkan nama user" required />
                                        </div>
                                    </div>

                                    <!-- Email -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email', $user->email) }}" placeholder="Masukkan email user" required />
                                        </div>
                                    </div>

                                    <!-- Role -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="role_id">Role</label>
                                            <select class="form-control" id="role_id" name="role_id" required>
                                                <option value="" disabled selected>Pilih Role</option>
                                                @foreach ($roles as $role)
                                                    <option value="{{ $role->id }}" {{ $role->id == $user->role_id ? 'selected' : '' }}>{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Umur -->
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="umur">Umur</label>
                                            <input type="number" class="form-control" id="umur" name="umur" value="{{ old('umur', $user->umur) }}" placeholder="Masukkan umur user" required />
                                        </div>
                                    </div>

                                    <!-- Jenis Kelamin -->
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="jenis_kelamin">Jenis Kelamin</label>
                                            <select class="form-control" id="jenis_kelamin" name="jenis_kelamin" required>
                                                <option value="Laki-Laki" {{ $user->jenis_kelamin == 'Laki-Laki' ? 'selected' : '' }}>Laki-Laki</option>
                                                <option value="Perempuan" {{ $user->jenis_kelamin == 'Perempuan' ? 'selected' : '' }}>Perempuan</option>
                                            </select>
                                        </div>
                                    </div>

                                    <!-- Alamat -->
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="alamat">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" placeholder="Masukkan alamat user" required>{{ old('alamat', $user->alamat) }}</textarea>
                                        </div>
                                    </div>

                                  <!-- Gambar Profil -->
<div class="col-md-12 mb-3">
    <div class="form-group">
        <label for="gambar_profil">Gambar Profil</label>
        <input type="file" class="form-control" id="gambar_profil" name="gambar_profil" accept="image/*" onchange="previewImage(event)" />

        <div class="mt-3">
            <!-- Menampilkan gambar lama jika ada -->
            @if($user->gambar_profil)
                <img src="{{ asset('storage/uploads/user/' . $user->gambar_profil) }}" alt="Gambar Profil" style="max-width: 150px;" />
            @else
                <p>Gambar tidak tersedia</p>
            @endif

            <!-- Preview gambar setelah dipilih -->
            <img id="imgPreview" src="" alt="Preview Gambar" style="max-width: 150px; display: none" />
        </div>
    </div>
</div>


                                    <!-- Password -->
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control" id="password" name="password" placeholder="Masukkan password jika ingin mengubahnya" />
                                        </div>
                                    </div>

                                    <!-- Konfirmasi Password -->
                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="password_confirmation">Konfirmasi Password</label>
                                            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" placeholder="Konfirmasi password" />
                                        </div>
                                    </div>

                                    <!-- Tombol Submit -->
                                    <div class="col-md-12 text-center mt-4">
                                        <button type="submit" class="btn btn-primary mx-2">Update Data</button>
                                        <a href="{{ route('dashboard.users.index') }}" class="btn btn-danger mx-2">Kembali</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('includes.admin.myScripts.user.editScripts')
