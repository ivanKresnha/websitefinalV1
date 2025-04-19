@extends('layout.admin.index')

@section('title', 'Kelola Peran User | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <!-- Title Section -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold">Kelola Peran User</h3>
                            @can('akses_tambah_role')
                                <!-- Button to add a new role -->
                                <a href="{{ route('dashboard.roles.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Tambah Peran
                                </a>
                            @endcan
                        </div>
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
                                <h4 class="text-center mt-3">Daftar Peran</h4>
                            </div>
                            <div class="card-body">
                                <table id="dataTable" class="table table-striped table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Peran</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $role->name }}</td>
                                                <td>
                                                    @can('akses_tampil_role')
                                                        <a href="{{ route('dashboard.roles.show', $role->id) }}"
                                                            class="btn btn-sm btn-primary"
                                                            style="padding: 5px 10px; border-radius: 5px; margin-right: 5px;">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </a>
                                                    @endcan

                                                    @can('akses_edit_role')
                                                        <a href="{{ route('dashboard.roles.edit', $role->id) }}"
                                                            class="btn btn-sm btn-warning"
                                                            style="padding: 5px 10px; border-radius: 5px; margin-right: 5px;">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    @endcan

                                                    @can('akses_hapus_role')
                                                        <form action="{{ route('dashboard.roles.destroy', $role->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                style="padding: 5px 10px; border-radius: 5px;"
                                                                onclick="return confirm('Hapus peran ini?')">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
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

@include('includes.admin.myScripts.peran_user.indexScripts')
