@extends('layout.admin.index')

@section('title', 'DETAIL PRODUK | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-start align-items-center pt-3 pb-3">
                        <h3 class="fw-bold">Detail Data Produk</h3>
                    </div>
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Detail Produk</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Nama Produk -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="namaProduk">Nama Produk</label>
                                        <input type="text" class="form-control" id="namaProduk" name="nama"
                                            value="{{ $product->nama }}" disabled />
                                    </div>
                                </div>

                                <!-- Kategori Produk -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="category_id">Kategori Produk</label>
                                        <select class="form-control" id="category_id" name="category_id" disabled>
                                            <option value="" disabled>Pilih Kategori</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                    {{ $category->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Stok -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="stok">Stok</label>
                                        <input type="number" class="form-control" id="stok" name="stok"
                                            value="{{ $product->stok }}" disabled />
                                    </div>
                                </div>

                                <!-- Harga -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="harga">Harga</label>
                                        <input type="number" class="form-control" id="harga" name="harga"
                                            value="{{ $product->harga }}" disabled />
                                    </div>
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="deskripsi">Deskripsi Produk</label>
                                    <textarea class="form-control" id="deskripsi" rows="5" disabled>{{ $product->deskripsi }}</textarea>
                                </div>


                                <!-- Gambar Produk -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="gambar">Gambar Produk</label>
                                        <div>
                                            <img src="{{ asset('storage/uploads/produk/' . $product->gambar_produk) }}"
                                                alt="{{ $product->nama }}" alt="Preview Gambar" style="max-width: 150px;" />
                                        </div>
                                    </div>
                                </div>

                                <!-- Tombol Kembali -->
                                <div class="col-md-12 text-center mt-4">
                                    <a href="{{ route('dashboard.products.index') }}"
                                        class="btn btn-danger mx-2">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@include('includes.admin.myScripts.produk.createScript')
