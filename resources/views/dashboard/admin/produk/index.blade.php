@extends('layout.admin.index')

@section('title', 'DAFTAR PRODUK | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <!-- Title Section -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold">Manajemen Produk</h3>
                        </div>


                        <!-- Menampilkan pesan sukses atau gagal -->
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible fade show" role="alert">
                                {{ session('success') }}
                                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
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
                                <div class="d-flex justify-content-start align-items-center">
                                    @can('akses_tambah_produk')
                                        <!-- Button to add a new product -->
                                        <a href="{{ route('dashboard.products.create') }}" class="btn btn-success">
                                            <i class="fas fa-plus"></i> Tambah Produk
                                        </a>
                                    @endcan
                                </div>

                                <h4 class="text-center mt-3">Daftar Produk</h4>
                            </div>
                            <div class="card-body">
                                <table id="dataTable" class="table table-striped table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID</th>
                                            <th>Nama</th>
                                            <th>Gambar</th>
                                            <th>Stok</th>
                                            <th>Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($products as $key => $product)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td>{{ 'PRD-' . str_pad($product->id, 3, '0', STR_PAD_LEFT) }}</td>
                                                <td>{{ $product->nama }}</td>
                                                <td>
                                                    @if ($product->gambar_produk)
                                                        <img src="{{ asset('storage/uploads/produk/' . $product->gambar_produk) }}" alt="Product Image" style="width: 100px; height: 100px; object-fit: cover; border-radius: 8px; margin: 5px;">
                                                    @else
                                                        <span class="text-muted">Tidak ada gambar</span>
                                                    @endif
                                                </td>

                                                <td>{{ $product->stok }}</td>
                                                <td>Rp {{ number_format($product->harga, 0, ',', '.') }}</td>
                                                <td>
                                                    @can('akses_edit_produk')
                                                        <a href="{{ route('dashboard.products.edit', $product->id) }}"
                                                            class="btn btn-sm btn-warning"
                                                            style="padding: 5px 10px; border-radius: 5px; margin-right: 5px;">
                                                            <i class="fas fa-edit"></i> Edit
                                                        </a>
                                                    @endcan

                                                    @can('akses_tampil_produk')
                                                        <a href="{{ route('dashboard.products.show', $product->id) }}"
                                                            class="btn btn-sm btn-primary"
                                                            style="padding: 5px 10px; border-radius: 5px; margin-right: 5px;">
                                                            <i class="fas fa-eye"></i> Detail
                                                        </a>
                                                    @endcan

                                                    @can('akses_hapus_produk')
                                                        <form action="{{ route('dashboard.products.destroy', $product->id) }}"
                                                            method="POST" style="display:inline-block;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                style="padding: 5px 10px; border-radius: 5px;"
                                                                onclick="return confirm('Hapus produk ini?')">
                                                                <i class="fas fa-trash"></i> Hapus
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="7" class="text-center">Tidak ada produk</td>
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

    @include('includes.admin.myScripts.produk.indexScripts')

@endsection
