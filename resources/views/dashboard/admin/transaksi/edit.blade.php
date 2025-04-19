@extends('layout.admin.index')

@section('title', 'Edit Transaksi')

@section('content')
    <div class="container mt-20">
        <div class="card shadow-sm p-3 mb-5 bg-body rounded">
            <div class="card-header bg-dark text-white">
                <h4 class="text-center mb-0">Form Edit Transaksi</h4>
            </div>
            <div class="card-body">
                <div class="row">
                    @if (session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <!-- Form Edit -->
                    <div class="col-lg-4 col-md-12">
                        <div class="card">
                            <div class="card-header bg-info text-white">
                                <h5 class="text-center mb-0">Form Edit Data</h5>
                            </div>
                            <div class="card-body">
                                <form id="editOrderForm"
                                    action="{{ route('dashboard.transactions.update', $transaction->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    <div class="mb-3">
                                        <label for="user_id" class="form-label">Nama Customer</label>
                                        <input type="text" id="user_id" class="form-control"
                                            value="{{ $transaction->user->name }}" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea id="alamat" class="form-control" rows="3" readonly>{{ $transaction->alamat }}</textarea>
                                    </div>

                                    <div class="mb-3">
                                        <label for="status_transaksi" class="form-label">Status Transaksi</label>
                                        <select id="status_transaksi" name="status_transaksi" class="form-select">
                                            <option value="Belum Diproses"
                                                {{ $transaction->status_transaksi == 'Belum Diproses' ? 'selected' : '' }}>
                                                Belum Diproses</option>
                                            <option value="Sudah Diproses"
                                                {{ $transaction->status_transaksi == 'Sudah Diproses' ? 'selected' : '' }}>
                                                Sudah Diproses</option>
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="status_pengiriman" class="form-label">Status Pengiriman</label>
                                        <select id="status_pengiriman" name="status_pengiriman" class="form-select">
                                            <option value="Belum Dikirim"
                                                {{ $transaction->status_pengiriman == 'Belum Dikirim' ? 'selected' : '' }}>
                                                Belum Dikirim</option>
                                            <option value="Sudah Dikirim"
                                                {{ $transaction->status_pengiriman == 'Sudah Dikirim' ? 'selected' : '' }}>
                                                Sudah Dikirim</option>
                                        </select>
                                    </div>

                            </div>
                        </div>
                    </div>


                    <!-- Keranjang Pesanan -->
                    <div class="col-lg-8 col-md-12">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                <h5 class="text-center mb-0">Keranjang Pesanan</h5>
                            </div>
                            <div class="card-body" style="max-height: 400px; overflow-y: auto;">
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Total Harga</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($transaction->details as $index => $detail)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $detail->product->nama }}</td>
                                                <td>Rp{{ number_format($detail->product->harga, 0, ',', '.') }}</td>
                                                <td>{{ $detail->jmlh_pesan }}</td>
                                                <td>Rp{{ number_format($detail->total_harga_produk, 0, ',', '.') }}</td>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="card-footer">
                                <div class="mt-3">
                                    <strong>Total Harga Barang:</strong>
                                    <span
                                        id="totalHargaBarang">Rp{{ number_format($transaction->details->sum('total_harga_produk'), 0, ',', '.') }}</span>
                                </div>

                                <div class="mt-3">
                                    <strong>Total Ongkos Kirim (10%):</strong>
                                    @php
                                        $totalBarang = $transaction->details->sum('total_harga_produk');
                                        $ongkosKirim = $totalBarang * 0.1;
                                    @endphp
                                    <span id="totalOngkosKirim">Rp{{ number_format($ongkosKirim, 0, ',', '.') }}</span>
                                </div>

                                <div class="mt-3">
                                    <strong>Total Harga Seluruh:</strong>
                                    @php
                                        $totalHargaSeluruh = $totalBarang + $ongkosKirim;
                                    @endphp
                                    <span
                                        id="totalHargaSeluruh">Rp{{ number_format($totalHargaSeluruh, 0, ',', '.') }}</span>
                                </div>

                                <div class="mt-3">
                                    <label for="total_bayar" class="form-label">Total Bayar</label>
                                    <input type="text" id="total_bayar" name="total_bayar" class="form-control"
                                        value="{{ $transaction->total_bayar }}" readonly>
                                </div>

                                <div class="mt-3">
                                    <label for="kembalian" class="form-label">Kembalian</label>
                                    @php
                                        $kembalian = max($transaction->total_bayar - $totalHargaSeluruh, 0);
                                    @endphp
                                    <input type="text" id="kembalian" class="form-control"
                                        value="Rp{{ number_format($kembalian, 0, ',', '.') }}" readonly>
                                </div>

                                <!-- Upload Bukti Bayar -->
                                <div class="mb-3 mt-4">
                                    <label for="gambar_bukti_bayar" class="form-label">Upload Bukti Bayar</label>
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

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-primary">Edit Data</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
