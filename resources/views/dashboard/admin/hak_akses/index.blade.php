@extends('layout.admin.index')

@section('title', 'Kelola Hak Akses | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <!-- Title Section -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold">Kelola Hak Akses</h3>
                        </div>

                        <!-- Table -->
                        <div class="card">
                            <div class="card-header"> 
                                <h4 class="text-center mt-3">Daftar Hak Akses</h4>
                            </div>
                            <div class="card-body">
                                <table id="dataTable" class="table table-striped table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Hak Akses</th> 
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($permissions as $permission)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $permission->name }}</td> 
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
