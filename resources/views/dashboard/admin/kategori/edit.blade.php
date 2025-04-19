@extends('layout.admin.index')

@section('title', 'Edit Kategori | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-start align-items-center pt-3 pb-3">
                        <h3 class="fw-bold">Edit Kategori</h3>
                    </div>
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Form Edit Kategori</h4>
                        </div>
                        <div class="card-body">
                            <form action="{{ route('dashboard.categories.update', $category->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label for="nama">Nama Kategori</label>
                                    <input type="text" class="form-control" id="nama" name="nama" value="{{ $category->nama }}" placeholder="Masukkan nama kategori" required />
                                </div>
                                <div class="mt-3 text-center">
                                    <button type="submit" class="btn btn-primary">Update Kategori</button>
                                    <a href="{{ route('dashboard.categories.index') }}" class="btn btn-danger">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
