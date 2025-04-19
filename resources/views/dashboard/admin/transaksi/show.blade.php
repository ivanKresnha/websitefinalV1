@extends('layout.admin.index')

@section('title', 'Detail Transaksi | RFF')

@section('content')
    <div class="container mt-30">
        <div class="row justify-content-center">
            <div class="col-md-10">
                <!-- Card Detail Transaksi -->
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4 class="text-center">Detail Transaksi</h4>
                    </div>
                    <div class="card-body">
                        <!-- Informasi Transaksi -->
                        <h5 class="mb-3">Informasi Transaksi</h5>
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>ID Transaksi:</strong>
                                <p>TRS-{{ $transaction->id }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Nama Customer:</strong>
                                <p>{{ $transaction->user->name }}</p>
                            </div>
                        </div>
                        <div class="row mb-3">

                            <div class="col-md-6">
                                <strong>Status Transaksi:</strong>
                                <p>
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
                                </p>
                            </div>
                            <div class="col-md-6">
                                <strong>Status Pengiriman:</strong>
                                <p>
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
                                </p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Tanggal Transaksi:</strong>
                                <p>{{ $transaction->tgl_transaksi }}</p>
                            </div>
                            <div class="col-md-6">
                                <strong>Catatan Tambahan:</strong>
                                <p>{{ $transaction->catatan_tambahan ?? 'Tidak ada catatan tambahan.' }}</p>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-6">
                                <strong>Alamat Pengiriman:</strong>
                                <p>{{ $transaction->alamat }}</p>
                            </div>

                            <div class="col-md-6">
                                <strong>Bukti Bayar Transaksi:</strong>
                                @if ($transaction->gambar_bukti_bayar)
                                    <p>
                                        <img src="{{ asset('storage/uploads/transaksi/' . $transaction->gambar_bukti_bayar) }}"
                                            alt="Bukti Bayar"
                                            style="width: 100%; max-width: 200px; height: 100%; max-height: 200px; object-fit: cover; border-radius: 5px;">
                                    </p>
                                @else
                                    <p class="text-muted">Tidak ada bukti bayar.</p>
                                @endif
                            </div>
                        </div>

                        <!-- Tabel Produk yang Dibeli -->
                        <h5 class="mb-3">Produk yang Dibeli</h5>
                        <div class="table-responsive">
                            <table class="table table-bordered text-center">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Produk</th>
                                        <th>Gambar</th>
                                        <th>Jumlah Pesan</th>
                                        <th>Harga Satuan</th>
                                        <th>Total Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($transaction->details as $index => $detail)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $detail->product->nama ?? 'Produk tidak ditemukan' }}</td>
                                            <td>
                                                @if ($detail->product && $detail->product->gambar_produk)
                                                    <img src="{{ asset('storage/uploads/produk/' . $detail->product->gambar_produk) }}"
                                                        alt="{{ $detail->product->nama }}"
                                                        style="width: 100px; height: 100px; object-fit: cover; border-radius: 5px;">
                                                @else
                                                    <span class="text-muted">Tidak ada gambar</span>
                                                @endif
                                            </td>
                                            <td>{{ $detail->jmlh_pesan }}</td>
                                            <td>Rp{{ number_format($detail->product->harga, 0, ',', '.') }}</td>
                                            <td>Rp{{ number_format($detail->total_harga_produk, 0, ',', '.') }}</td>
                                        </tr>
                                    @endforeach
                                    <!-- Jika tidak ada detail -->
                                    @if ($transaction->details->isEmpty())
                                        <tr>
                                            <td colspan="6" class="text-center">Tidak ada produk dalam transaksi ini.
                                            </td>
                                        </tr>
                                    @endif
                                </tbody>

                                <tfoot>
                                    <!-- Total Harga Barang -->
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Total Seluruh Harga Barang:</strong>
                                        </td>
                                        <td>Rp{{ number_format($total_harga_produk, 0, ',', '.') }}</td>
                                    </tr>

                                    <!-- Ongkos Kirim -->
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Total Ongkos Kirim (10%):</strong></td>
                                        <td>Rp{{ number_format($ongkosKirim, 0, ',', '.') }}</td>
                                    </tr>

                                    <!-- Total Harga Seluruh -->
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Total Harga Seluruh:</strong></td>
                                        <td>Rp{{ number_format($total_harga_seluruh, 0, ',', '.') }}</td>
                                    </tr>

                                    <!-- Total Bayar -->
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Total Bayar:</strong></td>
                                        <td>Rp{{ number_format($total_bayar, 0, ',', '.') }}</td>
                                    </tr>

                                    <!-- Kembalian -->
                                    <tr>
                                        <td colspan="5" class="text-end"><strong>Kembalian:</strong></td>
                                        <td>Rp{{ number_format($transaction->kembalian, 0, ',', '.') }}</td>
                                    </tr>
                                </tfoot>


                            </table>
                        </div>

                        <!-- Tombol Aksi -->
                        <div class="mt-4 text-center">
                            @can('akses_tampil_transaksi')
                                <a href="{{ route('dashboard.transactions.index') }}" class="btn btn-secondary"
                                    style="padding: 10px 20px; border-radius: 5px; margin-right: 10px;">
                                    <i class="fas fa-arrow-left"></i> Kembali
                                </a>
                            @endcan 
                        </div>



                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
