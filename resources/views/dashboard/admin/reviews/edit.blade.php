@extends('layout.admin.index')

@section('title', 'EDIT ULASAN PRODUK | RFF')

@section('content')
    <div class="container">
        <div class="page-inner">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="d-flex justify-content-start align-items-center pt-3 pb-3">
                        <h3 class="fw-bold">Edit Ulasan Produk</h3>
                    </div>
                    <div class="card">
                        <div class="card-header text-center">
                            <h4>Form Edit Ulasan Produk</h4>
                        </div>
                        <div class="card-body">
                            <form id="formEditUlasan" method="POST"
                                action="{{ route('dashboard.reviews.update', $review->id) }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Dropdown Transaksi Atas Nama -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="transaction_id">Transaksi Atas Nama</label>
                                        <select class="form-control" id="transaction_id" name="transaction_id" required>
                                            @foreach ($transactions as $transaction)
                                                <option value="{{ $transaction->id }}"
                                                    {{ $transaction->id == $review->transaction_id ? 'selected' : '' }}>
                                                    {{ $transaction->user->name }} - Transaksi #{{ $transaction->id }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <!-- Dropdown Pilih Produk -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="product_id">Pilih Produk</label>
                                        <select class="form-control" id="product_id" name="product_id" required>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}"
                                                    {{ $product->id == $review->product_id ? 'selected' : '' }}>
                                                    {{ $product->nama }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <!-- Preview Gambar Produk -->
                                    <div id="product-image-preview" class="mt-3 text-center">
                                        @if ($review->product->gambar_produk)
                                            <img src="{{ asset('storage/uploads/produk/' . $review->product->gambar_produk) }}"
                                                alt="Gambar Produk" class="img-fluid rounded" style="max-width: 200px;">
                                        @else
                                            <p class="text-muted">Pilih produk untuk melihat gambar.</p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Input Rating -->
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <label for="rating">Rating (1-5)</label>
                                        <input type="number" class="form-control" id="rating" name="rating"
                                            min="1" max="5" value="{{ $review->rating }}" required />
                                    </div>
                                </div>

                                <!-- Input Ulasan -->
                                <div class="col-md-12 mb-3">
                                    <label for="ulasan">Ulasan</label>
                                    <textarea class="form-control" name="ulasan" id="ulasan" rows="5" placeholder="Tulis ulasan produk" required>{{ $review->ulasan }}</textarea>
                                </div>

                                <!-- Input Status Ulasan -->
                                <div class="col-md-12 mb-3">
                                    <div class="form-group">
                                        <label for="status_ulasan">Status Ulasan</label>
                                        <select id="status_ulasan" name="status_ulasan" class="form-select">
                                            <option value="Sudah Divalidasi"
                                                {{ $review->status_ulasan == 'Sudah Divalidasi' ? 'selected' : '' }}>
                                                Sudah Divalidasi
                                            </option>
                                            <option value="Belum Divalidasi"
                                                {{ $review->status_ulasan == 'Belum Divalidasi' ? 'selected' : '' }}>
                                                Belum Divalidasi
                                            </option>
                                        </select>
                                    </div>
                                </div>


                                <!-- Preview Gambar Ulasan -->
                                <div class="col-md-12 mb-3">
                                    <label for="gambar_ulasan">Gambar Ulasan</label>
                                    <input type="file" class="form-control" id="gambar_ulasan" name="gambar_ulasan"
                                        accept="image/*" />
                                    <div id="ulasan-image-preview" class="mt-3 text-center">
                                        @if ($review->gambar_ulasan)
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
                                    <button type="submit" class="btn btn-success mx-2">Perbarui Ulasan</button>
                                    <a href="{{ route('dashboard.reviews.index') }}"
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
