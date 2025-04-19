@extends('layout.admin.index')

@section('title', 'DAFTAR TRANSAKSI | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <!-- Data Tables -->
            <div class="container mt-5">
                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <!-- Title Section -->
                        <div class="d-flex justify-content-between align-items-center mb-4">
                            <h3 class="fw-bold">Manajemen Transaksi</h3>
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
                                <div class="d-flex justify-content-start align-items-center">
                                    @can('akses_tambah_transaksi')
                                        <!-- Button to add a new transaction -->
                                        <a href="{{ route('dashboard.transactions.create') }}" class="btn btn-success">
                                            <i class="fas fa-plus"></i> Tambah Transaksi
                                        </a>
                                    @endcan
                                </div>
                                <h4 class="text-center mt-3">Daftar Transaksi</h4>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
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
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($transactions as $index => $transaction)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td>TRS-{{ $transaction->id }}</td>
                                                    <td>{{ $transaction->user->name }}</td>
                                                    <td>
                                                        @foreach ($transaction->details as $detail)
                                                            {{ $detail->product->nama ?? 'Produk tidak ditemukan' }}<br>
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($transaction->details as $detail)
                                                            @if ($detail->product && $detail->product->gambar_produk)
                                                                <img src="{{ asset('storage/uploads/produk/' . $detail->product->gambar_produk) }}"
                                                                    alt="{{ $detail->product->nama }}"
                                                                    style="width: 100px; height: 100px; object-fit: cover; margin-bottom: 10px; display: block;">
                                                            @else
                                                                <span class="text-muted">Tidak ada gambar</span>
                                                            @endif
                                                        @endforeach
                                                    </td>
                                                    <td>
                                                        @foreach ($transaction->details as $detail)
                                                            {{ $detail->jmlh_pesan }}<br>
                                                        @endforeach
                                                    </td>
                                                    <td>Rp{{ number_format($transaction->total_bayar, 0, ',', '.') }}</td>
                                                    <td>
                                                        @if ($transaction->status_transaksi === 'Belum Diproses')
                                                            <span class="btn btn-sm btn-danger"
                                                                style="padding: 5px 10px; border-radius: 5px; cursor: default;">
                                                                {{ $transaction->status_transaksi }}
                                                            </span>
                                                        @else
                                                            <span class="btn btn-sm btn-success"
                                                                style="padding: 5px 10px; border-radius: 5px; cursor: default;">
                                                                {{ $transaction->status_transaksi }}
                                                            </span>
                                                        @endif
                                                    </td>

                                                    <td>
                                                        @if ($transaction->status_pengiriman === 'Belum Dikirim')
                                                            <span class="btn btn-sm btn-danger"
                                                                style="padding: 5px 10px; border-radius: 5px; cursor: default;">
                                                                {{ $transaction->status_pengiriman }}
                                                            </span>
                                                        @else
                                                            <span class="btn btn-sm btn-success"
                                                                style="padding: 5px 10px; border-radius: 5px; cursor: default;">
                                                                {{ $transaction->status_pengiriman }}
                                                            </span>
                                                        @endif
                                                    </td>

                                                    <td>{{ $transaction->tgl_transaksi }}</td>
                                                    <td>
                                                        <!-- Tombol Aksi -->
                                                        @can('akses_tampil_transaksi')
                                                            <a href="{{ route('dashboard.transactions.show', $transaction->id) }}"
                                                                class="btn btn-sm btn-primary"
                                                                style="padding: 5px 10px; border-radius: 5px; margin-right: 5px;">
                                                                <i class="fas fa-eye"></i> Detail
                                                            </a>
                                                        @endcan

                                                        @can('akses_edit_transaksi')
                                                            <a href="{{ route('dashboard.transactions.edit', $transaction->id) }}"
                                                                class="btn btn-sm btn-warning"
                                                                style="padding: 5px 10px; border-radius: 5px; margin-right: 5px;">
                                                                <i class="fas fa-edit"></i> Edit
                                                            </a>
                                                        @endcan

                                                        @if (auth()->user()->role_id == 1 ||
                                                                (auth()->user()->can('akses_print_transaksi') && $transaction->status_transaksi === 'Sudah Diproses'))
                                                            <a href="{{ route('dashboard.transactions.print', $transaction->id) }}"
                                                                class="btn btn-sm btn-danger"
                                                                style="padding: 5px 10px; border-radius: 5px; margin-right: 5px;">
                                                                <i class="fas fa-print"></i> Print
                                                            </a>
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
    </div>

    @include('includes.admin.myScripts.transaksi.indexScripts')

@endsection
