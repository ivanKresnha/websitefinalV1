@extends('layout.admin.index')

@section('title', 'Kelola Kategori | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <!-- Title Section -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold">Manajemen Kategori</h3>
                            @can('akses_tambah_kategori_produk')
                                <!-- Button to add a new category -->
                                <a href="{{ route('dashboard.categories.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Tambah Kategori
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
                                <h4 class="text-center mt-3">Daftar Kategori</h4>
                            </div>
                            <div class="card-body">
                                <table id="dataTable" class="table table-striped table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Kategori</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($categories as $key => $category)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ $category->nama }}</td>
                                                <td>
                                                    @can('akses_edit_kategori_produk')
                                                        <a href="{{ route('dashboard.categories.edit', $category->id) }}"
                                                            class="btn btn-sm btn-warning"
                                                            style="padding: 5px 10px; border-radius: 5px; margin-right: 5px;">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    @endcan

                                                    @can('akses_hapus_kategori_produk')
                                                        <form
                                                            action="{{ route('dashboard.categories.destroy', $category->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                style="padding: 5px 10px; border-radius: 5px;"
                                                                onclick="return confirm('Hapus kategori ini?')">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="3" class="text-center">Tidak ada kategori</td>
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

@include('includes.admin.myScripts.kategori.indexScripts')
