@extends('layout.admin.index')

@section('title', 'EDIT PRODUK | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-start align-items-center pt-3 pb-3">
                        <h3 class="fw-bold">Edit Data Produk</h3>
                    </div>
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Form Edit Data Produk</h4>
                        </div>
                        <div class="card-body">
                            <form id="formEditProduk" method="POST"
                                action="{{ route('dashboard.products.update', $product->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="namaProduk">Nama Produk</label>
                                            <input type="text" class="form-control" id="namaProduk" name="nama"
                                                value="{{ old('nama', $product->nama) }}" placeholder="Masukkan nama produk"
                                                required />
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="category_id">Kategori Produk</label>
                                            <select class="form-control" id="category_id" name="category_id" required>
                                                <option value="" disabled selected>Pilih Kategori</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}"
                                                        {{ $category->id == $product->category_id ? 'selected' : '' }}>
                                                        {{ $category->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="stok">Stok</label>
                                            <input type="number" class="form-control" id="stok" name="stok"
                                                value="{{ old('stok', $product->stok) }}" placeholder="Masukkan jumlah stok"
                                                required />
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="harga">Harga</label>
                                            <input type="number" class="form-control" id="harga" name="harga"
                                                value="{{ old('harga', $product->harga) }}"
                                                placeholder="Masukkan harga produk" required />
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="deskripsi">Deskripsi Produk</label>
                                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5">{{ $product->deskripsi }}</textarea>
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="gambar">Gambar Produk</label>
                                            <input type="file" class="form-control" id="gambar" name="gambar_produk"
                                                accept="image/*" onchange="previewImage(event)" />
                                            <div class="mt-3">
                                                <!-- Preview Image -->
                                                <img id="imgPreview"
                                                    src="{{ asset('storage/uploads/produk/' . $product->gambar_produk) }}"
                                                    alt="{{ $product->nama }}" style="max-width: 150px;" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 text-center mt-4">
                                        <button type="submit" class="btn btn-primary mx-2">Update Data</button>
                                        <a href="{{ route('dashboard.products.index') }}"
                                            class="btn btn-danger mx-2">Kembali</a>
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

@include('includes.admin.myScripts.produk.editScripts') <!-- Mengimpor Script untuk Image Preview -->
