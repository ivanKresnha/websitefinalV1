@extends('layout.admin.index')

@section('title', 'DETAIL USER | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-start align-items-center pt-3 pb-3">
                        <h3 class="fw-bold">Detail User</h3>
                    </div>
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Detail Data User</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Nama User -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="name">Nama</label>
                                        <input type="text" class="form-control" id="name" value="{{ $user->name }}" disabled />
                                    </div>
                                </div>

                                <!-- Email -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" value="{{ $user->email }}" disabled />
                                    </div>
                                </div>

                                <!-- Role -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="role_id">Role</label>
                                        <input type="text" class="form-control" value="{{ $user->role->name }}" disabled />
                                    </div>
                                </div>

                                <!-- Gambar Profil -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="gambar_profil">Gambar Profil</label>
                                        <div>
                                            @if($user->gambar_profil)
                                                <img src="{{ asset('storage/uploads/user/' . $user->gambar_profil) }}" alt="Gambar Profil" style="max-width: 150px;">
                                            @else
                                                <p>Gambar tidak tersedia</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <!-- Umur -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="umur">Umur</label>
                                        <input type="number" class="form-control" id="umur" value="{{ $user->umur }}" disabled />
                                    </div>
                                </div>

                                <!-- Jenis Kelamin -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="jenis_kelamin">Jenis Kelamin</label>
                                        <input type="text" class="form-control" value="{{ $user->jenis_kelamin }}" disabled />
                                    </div>
                                </div>

                                <!-- Alamat -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="alamat">Alamat</label>
                                        <textarea class="form-control" id="alamat" disabled>{{ $user->alamat }}</textarea>
                                    </div>
                                </div>

                                <!-- Tombol Kembali -->
                                <div class="col-md-12 text-center mt-4">
                                    <a href="{{ route('dashboard.users.index') }}" class="btn btn-danger mx-2">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
