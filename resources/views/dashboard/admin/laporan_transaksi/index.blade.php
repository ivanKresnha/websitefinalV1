@extends('layout.admin.index')

@section('title', 'LAPORAN TRANSAKSI BULANAN | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <!-- Title Section -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold">Laporan Transaksi Bulanan</h3>
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
                                <h4 class="text-center mt-3">Daftar Laporan Transaksi</h4>
                                <div class="d-flex justify-content-start align-items-center mt-3">
                                    <!-- Button to print report -->
                                    <a href="{{ route('dashboard.laporan_transaksi.print-laporan-form') }}"
                                        class="btn btn-danger">
                                        <i class="fas fa-print"></i> Cetak Laporan
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <table id="dataTable" class="table table-striped table-bordered" style="width: 100%">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>ID Transaksi</th>
                                            <th>Nama Customer</th>
                                            <th>Produk</th>
                                            <th>Gambar Produk</th>
                                            <th>Jmlh Pesan</th>
                                            <th>Total Harga</th>
                                            <th>Status Transaksi</th>
                                            <th>Status Pengiriman</th>
                                            <th>Tanggal Transaksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($transactions as $transaction)
                                            @foreach ($transaction->details as $detail)
                                                <tr>
                                                    <td>{{ $loop->parent->iteration }}</td>
                                                    <td>{{ 'TRX-' . str_pad($transaction->id, 4, '0', STR_PAD_LEFT) }}</td>
                                                    <td>{{ $transaction->user?->name }}</td>
                                                    <td>{{ $detail->product->nama ?? '-' }}</td>
                                                    <td>
                                                        @if ($detail->product->gambar_produk)
                                                            <img src="{{ asset('storage/uploads/produk/' . $detail->product->gambar_produk) }}"
                                                                alt="{{ $detail->product->nama }}"
                                                                style="width: 50px; height: 50px; object-fit: cover;">
                                                        @else
                                                            <span class="text-muted">Tidak ada gambar</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $detail->jmlh_pesan }}</td>
                                                    <td>Rp{{ number_format($detail->total_harga_produk, 2, ',', '.') }}
                                                    </td>
                                                    <td>
                                                        @if ($transaction->status_transaksi == 'Sudah Diproses')
                                                            <span
                                                                class="badge bg-success">{{ $transaction->status_transaksi }}</span>
                                                        @else
                                                            <span
                                                                class="badge bg-danger">{{ $transaction->status_transaksi }}</span>
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if ($transaction->status_pengiriman == 'Sudah Dikirim')
                                                            <span
                                                                class="badge bg-success">{{ $transaction->status_pengiriman }}</span>
                                                        @else
                                                            <span
                                                                class="badge bg-warning">{{ $transaction->status_pengiriman }}</span>
                                                        @endif
                                                    </td>
                                                    <td>{{ $transaction->tgl_transaksi }}</td>
                                                </tr>
                                            @endforeach
                                        @empty
                                            <tr>
                                                <td colspan="10" class="text-center">Tidak ada transaksi</td>
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
@endsection

@include('includes.admin.myScripts.laporan.indexScripts')
