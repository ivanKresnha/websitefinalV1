@extends('layout.admin.index')

@section('title', 'DETAIL ULASAN PRODUK | RFF')

@section('content')
    <div class="container py-5">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10 col-sm-12">
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h3 class="fw-bold text-center w-100">Detail Ulasan Produk</h3>
                    </div>
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="text-center mb-0">Detail Ulasan</h4>
                        </div>
                        <div class="card-body">
                            <!-- Tabel Detail Ulasan -->
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                        <tr>
                                            <td><strong>Transaksi:</strong></td>
                                            <td>{{ $review->transaction->user->name }} - Transaksi
                                                #{{ $review->transaction_id }}</td>
                                            <td><strong>Rating:</strong></td>
                                            <td>{{ $review->rating }} / 5</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Produk:</strong></td>
                                            <td>{{ $review->product->nama }}</td>
                                            <td><strong>Ulasan:</strong></td>
                                            <td>{{ $review->ulasan }}</td>
                                        </tr>
                                        <tr>
                                            <td><strong>Status:</strong></td>
                                            <td>{{ $review->status_ulasan }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>

                            <!-- Gambar Produk dan Ulasan -->
                            <div class="row text-center mt-4">
                                <div class="col-md-6">
                                    <h6><strong>Gambar Produk</strong></h6>
                                    @if ($review->product->gambar_produk)
                                        <img src="{{ asset('storage/uploads/produk/' . $review->product->gambar_produk) }}"
                                            alt="Gambar Produk" class="img-fluid rounded shadow-sm"
                                            style="max-width: 200px; height: auto;">
                                    @else
                                        <p class="text-muted">Tidak ada gambar produk.</p>
                                    @endif
                                </div>
                                <div class="col-md-6">
                                    <h6><strong>Gambar Ulasan</strong></h6>
                                    @if ($review->gambar_ulasan)
                                        <img src="{{ asset('storage/uploads/ulasan/' . $review->gambar_ulasan) }}"
                                            alt="Gambar Ulasan" class="img-fluid rounded shadow-sm"
                                            style="max-width: 200px; height: auto;">
                                    @else
                                        <p class="text-muted">Tidak ada gambar ulasan.</p>
                                    @endif
                                </div>

                            </div>

                            <!-- Tombol Kembali -->
                            <div class="text-center mt-4">
                                <a href="{{ route('dashboard.reviews.index') }}" class="btn btn-primary">Kembali ke Daftar
                                    Ulasan</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
