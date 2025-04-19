@extends('layout.admin.index')

@section('title', 'Tambah Transaksi')

@section('content')
    <div class="container mt-20">
        <div class="card shadow-sm p-3 mb-5 bg-body rounded">
            <div class="card-header bg-dark text-white">
                <h4 class="text-center mb-0">Form Tambah Transaksi</h4>
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

                    <!-- Form Tambah  -->
                    <div class="col-lg-5 col-md-12">
                        <div class="card">
                            <div class="card-header bg-primary text-white">
                                <h5 class="text-center mb-0">Form Tambah Data</h5>
                            </div>
                            <div class="card-body">
                                <form id="orderForm" action="{{ route('dashboard.transactions.store') }}" method="POST"
                                    enctype="multipart/form-data" onsubmit="return checkFormSubmission()">
                                    @csrf

                                    <div class="mb-3">
                                        <label for="user_id" class="form-label">Transaksi Atas Nama</label>
                                        @if (auth()->user()->role_id == 1)
                                            <select id="user_id" name="user_id" class="form-select" required>
                                                <option selected disabled>Pilih Nama Customer</option>
                                                @foreach ($users as $user)
                                                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                                                @endforeach
                                            </select>
                                        @else
                                            <!-- Jika bukan role_id 1, set user_id menjadi id pengguna yang login -->
                                            <input type="hidden" id="user_id" name="user_id"
                                                value="{{ auth()->user()->id }}">
                                            <!-- Menampilkan nama pengguna yang sedang login menggunakan input readonly -->
                                            <input type="text" class="form-control" value="{{ auth()->user()->name }}"
                                                readonly>
                                        @endif
                                    </div>



                                    <div class="mb-3">
                                        <label for="product_id" class="form-label">Pesanan Produk</label>
                                        <select class="form-control" id="product_id">
                                            <option selected disabled>Pilih Nama Produk</option>
                                            @foreach ($products as $product)
                                                <option value="{{ $product->id }}" data-price="{{ $product->harga }}"
                                                    data-stock="{{ $product->stok }}">
                                                    {{ $product->nama }} -
                                                    Rp{{ number_format($product->harga, 0, ',', '.') }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div class="mb-3">
                                        <label for="sisa_stok" class="form-label">Sisa Stok</label>
                                        <input type="text" id="sisa_stok" class="form-control" readonly>
                                    </div>

                                    <div class="mb-3">
                                        <label for="jmlh_pesan" class="form-label">Jumlah Pesanan</label>
                                        <input type="number" id="jmlh_pesan" class="form-control" min="1"
                                            placeholder="Masukkan jumlah pesanan">
                                    </div>

                                    <div class="text-center">
                                        <button type="button" class="btn btn-primary" onclick="addToCart()">
                                            <i class="fas fa-cart-plus"></i> Tambah ke Keranjang
                                        </button>
                                    </div>
                            </div>
                        </div>
                    </div>

                    <!-- Keranjang Pesanan -->
                    <div class="col-lg-7 col-md-12">
                        <div class="card">
                            <div class="card-header bg-warning text-white">
                                <h5 class="text-center mb-0">Keranjang Pesanan</h5>
                            </div>
                            <div class="card-body" style="max-height: 400px; overflow-y: auto;"> <!-- Scrollable section -->
                                <table class="table table-striped">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Nama Produk</th>
                                            <th>Harga</th>
                                            <th>Jumlah</th>
                                            <th>Total Harga</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody id="cartList">
                                        <tr>
                                            <td colspan="6" class="text-center text-muted">Belum ada produk yang dipilih.
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>


                            <div class="card-footer">
                                <div class="mt-3">
                                    <strong>Total Harga Barang: </strong>
                                    <span id="totalHargaBarang">Rp0</span>
                                    <input type="hidden" id="total_harga_kirim" name="total_harga_kirim" value="0">
                                </div>

                                <div class="mt-3">
                                    <strong>Total Ongkos Kirim (10%): </strong>
                                    <span id="totalOngkosKirim">Rp0</span>
                                    <input type="hidden" id="total_harga_kirim" name="total_harga_kirim" value="0">

                                </div>
                                <div class="mt-3">
                                    <strong>Total Harga Seluruh: </strong>
                                    <span id="totalHargaSeluruh">Rp0</span>
                                </div>
                                <div class="mt-3">
                                    <label for="total_bayar" class="form-label">Total Bayar</label>
                                    <input type="number" id="total_bayar" name="total_bayar" class="form-control"
                                        placeholder="Masukkan total bayar">
                                </div>
                                <div class="mt-3">
                                    <label for="kembalian" class="form-label">Kembalian</label>
                                    <input type="text" id="kembalian" class="form-control" readonly>
                                </div>

                                <div class="mb-3">
                                    <label for="alamat" class="form-label">Alamat</label>
                                    <textarea id="alamat" name="alamat" class="form-control" rows="3"
                                        placeholder="Masukkan alamat pengiriman"></textarea>
                                </div>
                   
                                <div class="mb-3">
                                    <label for="catatan_tambahan" class="form-label">Catatan Tambahan</label>
                                    <textarea id="catatan_tambahan" name="catatan_tambahan" class="form-control" rows="3"
                                        placeholder="Masukkan Catatan pengiriman"></textarea>
                                </div>

                                <div class="mb-3">
                                    @if (auth()->user()->role_id == 1)
                                        <label for="status_transaksi" class="form-label">Status Transaksi</label>
                                        <select id="status_transaksi" name="status_transaksi" class="form-select"
                                            required>
                                            <option value="Belum Diproses" selected>Belum Diproses</option>
                                            <option value="Sudah Diproses">Sudah Diproses</option>
                                        </select>
                                    @else
                                        <!-- Input hidden jika bukan role_id 1 -->
                                        <input type="hidden" id="status_transaksi" name="status_transaksi"
                                            value="Belum Diproses">
                                    @endif
                                </div>

                                <div class="mt-3">
                                    @if (auth()->user()->role_id == 1)
                                        <label for="status_pengiriman" class="form-label">Status Pengiriman</label>
                                        <select id="status_pengiriman" name="status_pengiriman" class="form-select">
                                            <option value="Belum Dikirim" selected>Belum Dikirim</option>
                                            <option value="Sudah Dikirim">Sudah Dikirim</option>
                                        </select>
                                    @else
                                        <!-- Input hidden jika bukan role_id 1 -->
                                        <input type="hidden" id="status_pengiriman" name="status_pengiriman"
                                            value="Belum Dikirim">
                                    @endif
                                </div>

                                <div class="mt-3">
                                    <label for="tgl_transaksi" class="form-label">Tanggal Transaksi</label>
                                    <input type="date" id="tgl_transaksi" name="tgl_transaksi" class="form-control"
                                        value="{{ date('Y-m-d') }}">
                                </div>

                                <div class="mb-3">
                                    <label for="metode_bayar" class="form-label">Metode Bayar</label>
                                    <select id="metode_bayar" name="metode_bayar" class="form-select" required>
                                        <option selected disabled>Pilih Metode Bayar</option>
                                        <option value="BCA">BCA</option>
                                        <option value="MANDIRI">MANDIRI</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="rekening_label" class="form-label">No Rekening: </label>
                                    <input type="text" id="rekening_label" class="form-control" readonly>
                                </div>



                                <!-- Upload Bukti Bayar -->
                                <div class="mb-3 mt-4">
                                    <label for="gambar_bukti_bayar" class="form-label">Upload Bukti Bayar</label>
                                    <input type="file" id="gambar_bukti_bayar" name="gambar_bukti_bayar"
                                        class="form-control" accept="image/*">
                                    <div class="text-center mt-3" id="bukti-bayar-preview">
                                        <p class="text-muted">Upload gambar untuk melihat preview.</p>
                                    </div>
                                </div>



                                <input type="hidden" id="cartData" name="cartData">
                                <input type="hidden" id="jmlh_pesan_hidden" name="jmlh_pesan" value="0">

                                <div class="text-center mt-4">
                                    <button type="submit" class="btn btn-success">Tambah Data</button>
                                </div>

                            </div>
                        </div>
                    </div>

                    </form>
                </div>
            </div>
        </div>
    </div>



    <script>
        document.getElementById('metode_bayar').addEventListener('change', function() {
            var rekeningInput = document.getElementById('rekening_label');

            // Cek metode bayar yang dipilih dan sesuaikan nomor rekening
            if (this.value === 'BCA') {
                rekeningInput.value = '12344321'; // Nomor rekening BCA
            } else if (this.value === 'MANDIRI') {
                rekeningInput.value = '987654321'; // Nomor rekening Mandiri
            } else {
                rekeningInput.value = ''; // Jika tidak ada pilihan yang valid, kosongkan
            }
        });
    </script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const buktiBayarInput = document.getElementById('gambar_bukti_bayar');
            const buktiBayarPreview = document.getElementById('bukti-bayar-preview');

            if (buktiBayarInput && buktiBayarPreview) {
                buktiBayarInput.addEventListener('change', function() {
                    const file = this.files[0];

                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            buktiBayarPreview.innerHTML = `
                            <img src="${e.target.result}" alt="Preview Bukti Bayar" 
                                 class="img-fluid rounded shadow-sm" style="max-width: 200px; height: auto;">
                        `;
                        };
                        reader.readAsDataURL(file);
                    } else {
                        buktiBayarPreview.innerHTML =
                            `<p class="text-muted">Upload gambar untuk melihat preview.</p>`;
                    }
                });
            }
        });
    </script>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            const imgPreview = document.getElementById('imgPreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');

            if (file) {
                const reader = new FileReader();

                reader.onload = function(e) {
                    imgPreview.src = e.target.result;
                    imagePreviewContainer.style.display = 'block';
                };

                reader.readAsDataURL(file);
            } else {
                imagePreviewContainer.style.display = 'none';
            }
        }

        let cart = [];
        const cartList = document.getElementById('cartList');
        const cartDataInput = document.getElementById('cartData');
        const totalHargaBarang = document.getElementById('totalHargaBarang');
        const totalOngkosKirim = document.getElementById('totalOngkosKirim');
        const totalHargaSeluruh = document.getElementById('totalHargaSeluruh');
        const totalBayarInput = document.getElementById('total_bayar');
        const kembalianInput = document.getElementById('kembalian');
        const productSelect = document.getElementById('product_id');
        const sisaStokInput = document.getElementById('sisa_stok');
        const jmlhPesanInput = document.getElementById('jmlh_pesan');
        const jmlhPesanHidden = document.getElementById('jmlh_pesan_hidden');

        productSelect.addEventListener('change', updateProductDetails);
        jmlhPesanInput.addEventListener('input', validateStock);
        totalBayarInput.addEventListener('input', calculateKembalian);

        function updateProductDetails() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            if (!selectedOption || selectedOption.value === '') {
                sisaStokInput.value = '';
                return;
            }
            const stock = selectedOption.dataset.stock || 0;
            sisaStokInput.value = stock;
        }

        function validateStock() {
            const selectedStock = parseInt(sisaStokInput.value || 0);
            const qty = parseInt(jmlhPesanInput.value || 0);

            if (qty > selectedStock) {
                alert('Jumlah pesanan tidak boleh melebihi stok yang tersedia!');
                jmlhPesanInput.value = selectedStock;
            }
        }

        function addToCart() {
            const selectedOption = productSelect.options[productSelect.selectedIndex];
            const productId = selectedOption.value;
            const productName = selectedOption.text.split(' - ')[0];
            const productPrice = parseInt(selectedOption.dataset.price || 0);
            const qty = parseInt(jmlhPesanInput.value || 0);

            if (!productId || qty <= 0) {
                alert('Masukkan jumlah pesanan yang valid!');
                return;
            }

            const existingProductIndex = cart.findIndex(item => item.id === productId);
            if (existingProductIndex >= 0) {
                cart[existingProductIndex].qty += qty;
                cart[existingProductIndex].total += productPrice * qty;
            } else {
                cart.push({
                    id: productId,
                    name: productName,
                    price: productPrice,
                    qty,
                    total: productPrice * qty,
                });
            }

            updateCart();
            resetForm();
        }

        function resetForm() {
            productSelect.selectedIndex = 0; // Mengatur dropdown kembali ke opsi pertama (default)
            sisaStokInput.value = '';
            jmlhPesanInput.value = '';
        }


        function updateCart() {
            cartList.innerHTML = '';
            let totalQty = 0;
            let totalBarang = 0;

            cart.forEach((item, index) => {
                totalQty += item.qty;
                totalBarang += item.total;
                cartList.innerHTML += `
            <tr>
                <td>${index + 1}</td>
                <td>${item.name}</td>
                <td>Rp${item.price.toLocaleString()}</td>
                <td>${item.qty}</td>
                <td>Rp${item.total.toLocaleString()}</td>
                <td><button class="btn btn-danger" onclick="removeFromCart(${index})">Hapus</button></td>
            </tr>`;
            });

            // Hitung ongkos kirim sebagai 10% dari total barang
            const ongkosKirim = totalBarang * 0.1;
            const totalSeluruh = totalBarang + ongkosKirim;

            // Update nilai di tampilan dan input hidden
            totalHargaBarang.innerText = `Rp${totalBarang.toLocaleString()}`;
            totalOngkosKirim.innerText = `Rp${ongkosKirim.toLocaleString()}`;
            totalHargaSeluruh.innerText = `Rp${totalSeluruh.toLocaleString()}`;
            document.getElementById('total_harga_kirim').value = ongkosKirim; // Kirim ke server
            jmlhPesanHidden.value = totalQty;
            cartDataInput.value = JSON.stringify(cart);
        }

        function removeFromCart(index) {
            cart.splice(index, 1);
            updateCart();
        }

        function calculateKembalian() {
            const totalHargaValue = parseInt(
                totalHargaSeluruh.innerText.replace(/[^\d]/g, '') || 0
            );
            const totalBayarValue = parseInt(totalBayarInput.value || 0);
            const kembalianContainer = kembalianInput;

            if (totalBayarValue < totalHargaValue) {
                kembalianContainer.style.color = 'red';
                kembalianContainer.value = 'Uang Anda kurang';
            } else {
                const kembalian = totalBayarValue - totalHargaValue;
                kembalianContainer.style.color = 'black';
                kembalianContainer.value = `Rp${kembalian.toLocaleString()}`;
            }
        }

        function checkFormSubmission() {
            const totalHargaValue = parseInt(
                totalHargaSeluruh.innerText.replace(/[^\d]/g, '') || 0
            );
            const totalBayarValue = parseInt(totalBayarInput.value || 0);

            if (cart.length === 0) {
                alert('Keranjang tidak boleh kosong!');
                return false;
            }

            if (totalBayarValue < totalHargaValue) {
                alert('Uang Anda kurang!');
                return false;
            }

            document.getElementById('cartData').value = JSON.stringify(cart); // Masukkan data keranjang ke hidden input
            return true;
        }
    </script>

@endsection
