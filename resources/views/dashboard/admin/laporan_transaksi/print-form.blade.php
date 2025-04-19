@extends('layout.admin.index')

@section('title', 'Cetak Laporan Transaksi | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-8">
                        <!-- Title Section -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold">Cetak Laporan Transaksi</h3>
                        </div>

                        <!-- Form -->
                        <div class="card">
                            <div class="card-header">
                                <h4 class="text-center mt-3">Pilih Rentang Tanggal</h4>
                            </div>
                            <div class="card-body">
                                <form action="{{ route('dashboard.laporan_transaksi.print-data-laporan-pertanggal') }}" method="POST">
                                    @csrf
                                    <div class="form-group mb-3">
                                        <label for="tgl_awal" class="form-label">Tanggal Awal</label>
                                        <input type="date" name="tgl_awal" id="tgl_awal" class="form-control" required>
                                        @error('tgl_awal')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="tgl_akhir" class="form-label">Tanggal Akhir</label>
                                        <input type="date" name="tgl_akhir" id="tgl_akhir" class="form-control" required>
                                        @error('tgl_akhir')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="d-flex justify-content-center">
                                        <button type="submit" class="btn btn-danger">
                                            <i class="fas fa-print"></i> Cetak Laporan
                                        </button>
                                    </div>
                                    <input type="hidden" name="view_data" value="1">
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
