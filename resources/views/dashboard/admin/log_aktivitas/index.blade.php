@extends('layout.admin.index')

@section('title', 'DAFTAR LOG AKTIVITAS | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <!-- Title Section -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold">Data Log Aktivitas</h3>
                        </div>

                        <!-- Table -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-center mt-3">Daftar Log Aktivitas</h4>
                            </div>
                            <div class="card-body">
                                <table id="dataTable" class="table table-striped table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Pengguna</th>
                                            <th>Tabel</th>
                                            <th>Keterangan</th>
                                            <th>Waktu</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($activityLogs as $log)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <!-- Menggunakan relasi user untuk mendapatkan nama pengguna -->
                                                <td>{{ $log->user->name ?? 'Tidak Diketahui' }}</td>
                                                <!-- Pastikan 'name' adalah kolom nama pengguna -->
                                                <td>{{ $log->tabel_referensi }}</td>
                                                <td>{{ $log->deskripsi }}</td>
                                                <td>
                                                    @if ($log->created_at)
                                                        {{ $log->created_at->format('d F Y H:i:s') }}
                                                        <!-- Memformat dengan tanggal dan waktu -->
                                                    @else
                                                        Tanggal Tidak Tersedia
                                                    @endif
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

    @include('includes.admin.myScripts.produk.indexScripts')

@endsection
