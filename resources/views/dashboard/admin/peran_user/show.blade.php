@extends('layout.admin.index')

@section('title', 'Detail Peran User | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-start align-items-center pt-3 pb-3">
                        <h3 class="fw-bold">Detail Peran User</h3>
                    </div>
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Detail Data Peran User</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <!-- Nama Peran -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="name">Nama Peran</label>
                                        <input type="text" class="form-control" id="name" value="{{ $role->name }}" disabled />
                                    </div>
                                </div>

                                <!-- Hak Akses -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="permissions">Hak Akses</label>
                                        <table class="table table-bordered">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th>Nama Hak Akses</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($role->permissions as $index => $permission)
                                                    <tr>
                                                        <td>{{ $index + 1 }}</td>
                                                        <td>{{ $permission->name }}</td>
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                                <!-- Tombol Kembali -->
                                <div class="col-md-12 text-center mt-4">
                                    <a href="{{ route('dashboard.roles.index') }}" class="btn btn-danger mx-2">Kembali</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
