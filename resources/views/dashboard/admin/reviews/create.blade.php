@extends('layout.admin.index')

@section('title', 'TAMBAH ULASAN PRODUK | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-start align-items-center pt-3 pb-3">
                        <h3 class="fw-bold">Tambah Ulasan Produk</h3>
                    </div>
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Form Tambah Ulasan Produk</h4>
                        </div>
                        <div class="card-body">
                            <form id="formTambahUlasan" method="POST" action="{{ route('dashboard.reviews.store') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <!-- Dropdown Transaksi Atas Nama -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="transaction_id">Transaksi Atas Nama</label>
                                        <select class="form-control" id="transaction_id" name="transaction_id" required>
                                            <option value="" disabled selected>Pilih Transaksi</option>
                                            @if (Auth::user()->role_id == 1)
                                                @foreach ($transactions as $transaction)
                                                    <option value="{{ $transaction->id }}">
                                                        {{ $transaction->user->name }} {{ $transaction->id }}
                                                    </option>
                                                @endforeach
                                            @else
                                                @foreach (Auth::user()->transactions as $transaction)
                                                    <option value="{{ $transaction->id }}">
                                                        TRX {{ $transaction->id }} - {{ $transaction->user->name }}
                                                    </option>
                                                @endforeach
                                                <input type="hidden" name="user_id" value="{{ Auth::user()->id }}">
                                            @endif
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="product_id">Pilih Produk</label>
                                        <select class="form-control" id="product_id" name="product_id" required>
                                            <option value="" disabled selected>Pilih Produk</option>
                                            <!-- Produk akan dimuat dinamis dengan JavaScript -->
                                        </select>
                                    </div>
                                    <!-- Preview Gambar Produk -->
                                    <div id="product-image-preview" class="mt-3 text-center">
                                        <p class="text-muted">Pilih produk untuk melihat gambar.</p>
                                    </div>
                                </div>

                                <!-- Input Rating -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="rating">Rating (1-5)</label>
                                        <input type="number" class="form-control" id="rating" name="rating"
                                            min="1" max="5" required />
                                    </div>
                                </div>

                                <!-- Input Ulasan -->
                                <div class="col-md-12 mb-3">
                                    <label for="ulasan">Ulasan</label>
                                    <textarea class="form-control" name="ulasan" id="ulasan" rows="5" placeholder="Tulis ulasan produk" required></textarea>
                                </div>

                                <!-- Input Status Ulasan (Hidden jika bukan admin) -->
                                @if (Auth::user()->role_id == 1)
                                    <div class="col-md-12 mb-3">
                                        <div class="form-group">
                                            <label for="status_ulasan">Status Ulasan</label>
                                            <select class="form-control" id="status_ulasan" name="status_ulasan" required>
                                                <option value="" disabled selected>Pilih Status</option>
                                                <option value="sudah divalidasi">Sudah Divalidasi</option>
                                                <option value="belum divalidasi">Belum Divalidasi</option>
                                            </select>
                                        </div>
                                    </div>
                                @else
                                    <input type="hidden" name="status_ulasan" value="belum divalidasi" />
                                @endif

                                <!-- Input Gambar Ulasan -->
                                <div class="col-md-12 mb-3">
                                    <label for="gambar_ulasan">Gambar Ulasan</label>
                                    <input type="file" class="form-control" id="gambar_ulasan" name="gambar_ulasan"
                                        accept="image/*" />
                                    <div id="ulasan-image-preview" class="mt-3 text-center">
                                        @if (isset($review) && $review->gambar_ulasan)
                                            <img src="{{ asset('storage/uploads/ulasan/' . $review->gambar_ulasan) }}"
                                                alt="Preview Gambar Ulasan" class="img-fluid rounded"
                                                style="max-width: 200px;">
                                        @else
                                            <p class="text-muted">Upload gambar untuk melihat preview.</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Tombol Submit -->
                                <div class="col-md-12 text-center mt-4">
                                    <button type="submit" class="btn btn-success mx-2">Kirim Ulasan</button>
                                    <a href="{{ route('dashboard.transactions.index') }}"
                                        class="btn btn-danger mx-2">Kembali</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Input dan Preview Gambar Ulasan
        const ulasanImageInput = document.getElementById('gambar_ulasan');
        const ulasanImagePreview = document.getElementById('ulasan-image-preview');

        // Cek apakah elemen ditemukan
        if (ulasanImageInput && ulasanImagePreview) {
            ulasanImageInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        ulasanImagePreview.innerHTML = `
                            <img src="${e.target.result}" alt="Preview Gambar Ulasan" 
                                 class="img-fluid rounded" style="max-width: 200px;">
                        `;
                    };
                    reader.readAsDataURL(file);
                } else {
                    ulasanImagePreview.innerHTML = `
                        <p class="text-muted">Upload gambar untuk melihat preview.</p>
                    `;
                }
            });
        } else {
            console.error('Elemen gambar ulasan atau preview tidak ditemukan.');
        }

        // Dropdown Produk Berdasarkan Transaksi
        const transactionSelect = document.getElementById('transaction_id');
        const productSelect = document.getElementById('product_id');
        const productImagePreview = document.getElementById('product-image-preview');

        if (transactionSelect && productSelect && productImagePreview) {
            transactionSelect.addEventListener('change', function() {
                const transactionId = this.value;

                if (transactionId) {
                    fetch(`/transactions/${transactionId}/products`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Gagal memuat data produk');
                            }
                            return response.json();
                        })
                        .then(products => {
                            // Reset dan isi dropdown produk
                            productSelect.innerHTML =
                                '<option value="" disabled selected>Pilih Produk</option>';
                            products.forEach(product => {
                                productSelect.innerHTML += `
                                    <option value="${product.id}" data-image="${product.image}">
                                        ${product.nama}
                                    </option>`;
                            });

                            // Reset preview gambar produk
                            productImagePreview.innerHTML = `
                                <p class="text-muted">Pilih produk untuk melihat gambar.</p>`;
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Gagal memuat data produk. Silakan coba lagi.');
                        });
                }
            });

            // Preview gambar produk saat produk dipilih
            productSelect.addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const imageUrl = selectedOption.getAttribute('data-image');

                if (imageUrl) {
                    productImagePreview.innerHTML = `
                        <img src="${imageUrl}" alt="Gambar Produk" 
                             class="img-fluid rounded" style="max-width: 200px;">
                    `;
                } else {
                    productImagePreview.innerHTML = `
                        <p class="text-muted">Pilih produk untuk melihat gambar.</p>`;
                }
            });
        }
    });
</script>
