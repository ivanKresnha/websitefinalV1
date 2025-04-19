@extends('layout.admin.index')

@section('title', 'Tambah Peran User | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-start align-items-center pt-3 pb-3">
                        <h3 class="fw-bold">Tambah Peran User</h3>
                    </div>
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Form Tambah Peran User</h4>
                        </div>
                        <div class="card-body">
                            <form method="POST" action="{{ route('dashboard.roles.store') }}">
                                @csrf
                                <div class="row">
                                    <!-- Nama Peran -->
                                    <div class="col-md-12 mb-3">
                                        <label for="name">Nama Peran</label>
                                        <input type="text" class="form-control" name="name" id="name"
                                            placeholder="Nama Peran" required />
                                    </div>

                                    <!-- Permissions -->
                                    <div class="col-md-12 mb-3">
                                        <label for="permissions">Hak Akses</label>
                                        <select id="permissions" name="permissions[]" class="selectpicker" multiple
                                            data-actions-box="true" data-live-search="true" title="Pilih Hak Akses">
                                            @foreach ($permissions as $permission)
                                                <option value="{{ $permission->id }}">{{ $permission->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Tabel Permissions -->
                                    <div class="col-md-12 mt-3">
                                        <h5>Daftar Permissions Terpilih:</h5>
                                        <table class="table table-bordered" id="permissionsTable">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Hak Akses</th>
                                                    <th>Aksi</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <!-- Data akan diisi secara dinamis -->
                                            </tbody>
                                        </table>
                                    </div>

                                    <div class="col-md-12 text-center mt-4">
                                        <button type="submit" class="btn btn-success mx-2">Tambah Peran</button>
                                        <a href="{{ route('dashboard.roles.index') }}"
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
 
 @push('scripts')
    @include('includes.admin.myScripts.peran_user.create')
@endpush


@endsection 