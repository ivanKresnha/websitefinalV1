@extends('layout.admin.index')

@section('title', 'DAFTAR ULASAN PRODUK | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <!-- Data Tables -->
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <!-- Title Section -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold">Manajemen Ulasan Produk</h3>
                            @can('akses_tambah_ulasan')
                                <!-- Button to add a new review -->
                                <a href="{{ route('dashboard.reviews.create') }}" class="btn btn-success">
                                    <i class="fas fa-plus"></i> Tambah Ulasan
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
                                <h4 class="text-center mt-3">Daftar Ulasan Produk</h4>
                            </div>
                            <div class="card-body">
                                <table id="dataTable" class="table table-striped table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Produk</th>
                                            <th>Nama Produk</th>
                                            <th>Rating</th>
                                            <th>Ulasan</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($reviews as $review)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ 'PRD-' . str_pad($review->product->id, 3, '0', STR_PAD_LEFT) }}</td>
                                                <td>{{ $review->product->nama }}</td>
                                                <td>{{ $review->rating }}</td>
                                                <td>{{ $review->ulasan }}</td>
                                                <td>
                                                    @can('akses_edit_ulasan')
                                                        <a href="{{ route('dashboard.reviews.edit', $review->id) }}"
                                                            class="btn btn-sm btn-warning">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    @endcan

                                                    @can('akses_tampil_ulasan')
                                                        <a href="{{ route('dashboard.reviews.show', $review->id) }}"
                                                            class="btn btn-sm btn-primary">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </a>
                                                    @endcan

                                                    @can('akses_hapus_ulasan')
                                                        <form action="{{ route('dashboard.reviews.destroy', $review->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Hapus ulasan ini?')">
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

    @include('includes.admin.myScripts.reviews.indexScripts')
@endsection
