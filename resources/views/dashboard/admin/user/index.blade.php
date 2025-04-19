@extends('layout.admin.index')

@section('title', 'KELOLA USER | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <!-- Title Section -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold">Manajemen User</h3>
                            @can('akses_tambah_user')
                                <!-- Button to add a new user -->
                                <a href="{{ route('dashboard.users.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Tambah User
                                </a>
                            @endcan
                        </div>

                        {{-- tambahkan disini untuk succes atau gagal nya menggunakan aksi --}}
                        <!-- Menampilkan pesan sukses atau gagal -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @elseif(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                            </div>
                        @endif

                        <!-- Table -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-center mt-3">Daftar User</h4>
                            </div>
                            <div class="card-body">
                                <table id="dataTable" class="table table-striped table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($users as $key => $user)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $user->name }}</td>
                                                <td>{{ $user->email }}</td>
                                                <td>{{ $user->role->name }}</td>
                                                <td>
                                                    @can('akses_tampil_user')
                                                        <a href="{{ route('dashboard.users.show', $user->id) }}"
                                                            class="btn btn-sm btn-info"
                                                            style="padding: 5px 10px; border-radius: 5px; margin-right: 5px;">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </a>
                                                    @endcan

                                                    @can('akses_edit_user')
                                                        <a href="{{ route('dashboard.users.edit', $user->id) }}"
                                                            class="btn btn-sm btn-warning"
                                                            style="padding: 5px 10px; border-radius: 5px; margin-right: 5px;">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    @endcan

                                                    @if ($user->role_id != 1)
                                                        <!-- Kondisi: Hanya tampilkan tombol hapus jika role_id bukan 1 -->
                                                        @can('akses_hapus_user')
                                                            <!-- Pastikan user memiliki izin akses hapus -->
                                                            <form action="{{ route('dashboard.users.destroy', $user->id) }}"
                                                                method="POST" style="display:inline-block;">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    style="padding: 5px 10px; border-radius: 5px;"
                                                                    onclick="return confirm('Hapus user ini?')">
                                                                    <i class="fas fa-trash"></i> Hapus
                                                                </button>
                                                            </form>
                                                        @endcan
                                                    @endif

                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5" class="text-center">Tidak ada user</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('includes.admin.myScripts.user.indexScripts')
