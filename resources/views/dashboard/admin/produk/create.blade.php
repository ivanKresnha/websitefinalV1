@extends('layout.admin.index')

@section('title', 'TAMBAH PRODUK | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-start align-items-center pt-3 pb-3">
                        <h3 class="fw-bold">Tambah Data Produk</h3>
                    </div>
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Form Tambah Data Produk</h4>
                        </div>
                        <div class="card-body">
                            <form id="formTambahProduk" method="POST" action="{{ route('dashboard.products.store') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="namaProduk">Nama Produk</label>
                                            <input type="text" class="form-control" id="namaProduk" name="nama"
                                                placeholder="Masukkan nama produk" required />
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="category_id">Kategori Produk</label>
                                            <select class="form-control" id="category_id" name="category_id" required>
                                                <option value="" disabled selected>Pilih Kategori</option>
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}">{{ $category->nama }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="stok">Stok</label>
                                            <input type="number" class="form-control" id="stok" name="stok"
                                                placeholder="Masukkan jumlah stok" required />
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-3">
                                        <div class="form-group">
                                            <label for="harga">Harga</label>
                                            <input type="number" class="form-control" id="harga" name="harga"
                                                placeholder="Masukkan harga produk" required />
                                        </div>
                                    </div>

                                    <div class="col-md-12 mb-3">
                                        <label for="deskripsi">Deskripsi Produk : (max 255 kata)</label>
                                        <textarea class="form-control" name="deskripsi" id="deskripsi" rows="5" placeholder="Tulis deskripsi produk"></textarea>
                                    </div>


                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="gambar">Gambar Produk</label>
                                            <input type="file" class="form-control" id="gambar" name="gambar_produk"
                                                accept="image/*" onchange="previewImage(event)" required />
                                            <div class="mt-3">
                                                <img id="imgPreview" src="" alt="Preview Gambar"
                                                    style="max-width: 150px; display: none" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-12 text-center mt-4">
                                        <button type="submit" class="btn btn-success mx-2">Tambah Data</button>
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

@include('includes.admin.myScripts.produk.createScript')
