<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi - {{ $request->tgl_awal }} s/d {{ $request->tgl_akhir }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Arial', sans-serif;
        }

        body {
            padding: 20px;
            margin: 0;
        }

        h3 {
            text-align: center;
            margin-bottom: 20px;
        }

        h4 {
            text-align: center;
            margin-bottom: 10px;
        }

        .content {
            width: 100%;
            margin-top: 20px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: center;
            border: 1px solid #ccc;
        }

        .table th {
            background-color: #4CAF50;
            color: white;
        }

        .status {
            padding: 5px;
            border-radius: 3px;
            display: inline-block;
        }

        .status.lunas {
            background-color: green;
            color: white;
        }

        .status.belum-lunas {
            background-color: red;
            color: white;
        }

        .footer {
            margin-top: 40px;
            text-align: center;
        }

        .footer p {
            margin: 5px 0;
        }

        .product-row {
            border-top: 2px solid #ccc;
        }

        .product-name {
            text-align: left;
        }

        .right-align {
            text-align: right;
        }
    </style>
</head>

<body>
    <h3>TOKO RIDA FROZEN FOOD</h3>
    <h4>LAPORAN TRANSAKSI</h4>
   <p style="text-align: center; margin-top: 20px; margin-bottom: 20px;">
        Tanggal: {{ $request->tgl_awal }} s/d {{ $request->tgl_akhir }}
    </p>

    <table class="table">
        <thead>
            <tr>
                <th>No</th>
                <th>ID Transaksi</th>
                <th>Nama Pelanggan</th>
                <th>Tgl Transaksi</th>
                <th>Status Transaksi</th>
                <th>Nama Produk</th>
                <th>Harga</th>
                <th>Jumlah Pesan</th>
                <th>Total Harga + Ongkir</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transactions as $transaction)
                @foreach ($transaction->details as $detail)
                    <!-- Loop through each product detail -->
                    <tr class="product-row">
                        <td>{{ $loop->parent->iteration }}.{{ $loop->iteration }}</td>
                        <td>TRX-{{ $transaction->id }}</td>
                        <td>{{ $transaction->user->name }}</td>
                        <td>{{ \Carbon\Carbon::parse($transaction->tgl_transaksi)->format('d-m-Y') }}</td>
                        <td>
                            @if ($transaction->status_transaksi == 'Sudah Divalidasi')
                                <span class="status lunas">Sudah Divalidasi</span>
                            @elseif ($transaction->status_transaksi == 'Belum Divalidasi')
                                <span class="status belum-lunas">Belum Divalidasi</span>
                            @else
                                {{ $transaction->status_transaksi }}
                            @endif
                        </td>
                        <td class="product-name">{{ $detail->product->nama }}</td> <!-- Product name -->
                        <td>Rp{{ number_format($detail->product->harga, 2, ',', '.') }}</td> <!-- Product price -->
                        <td>{{ $detail->jmlh_pesan }}</td> <!-- Quantity -->
                        <td>
                            <!-- Calculate Total Harga Produk + Ongkir -->
                            Rp{{ number_format($detail->total_harga_produk + $transaction->total_harga_kirim, 2, ',', '.') }}
                        </td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <!-- Calculation of totals -->
    <table class="table">
        <tr>
            <td class="total">Total Produk</td>
            <td>{{ $transactions->sum(function ($transaction) {
                // Sum of all quantities of products across all transactions
                return $transaction->details->sum('jmlh_pesan');
            }) }}</td>
        </tr>

        <tr>
            <td class="total">Total Harga Seluruh Barang</td>
            <td>Rp{{ number_format(
                $transactions->sum(function ($transaction) {
                    // Sum of total product prices (total_harga_produk) for all products in all transactions
                    return $transaction->details->sum('total_harga_produk');
                }),
                2,
                ',',
                '.',
            ) }}</td>
        </tr>

        <tr>
            <td class="total">Total Harga + Ongkir</td>
            <td>Rp{{ number_format(
                $transactions->sum(function ($transaction) {
                    // Sum of total product prices and shipping cost for all products in all transactions
                    return $transaction->details->sum('total_harga_produk') + $transaction->total_harga_kirim;
                }),
                2,
                ',',
                '.',
            ) }}</td>
        </tr>
    </table>

    <div class="footer">
        <p>Nama Admin: {{ $adminName }}</p>
        <p>Admin Toko Rida Frozen Food</p>
    </div>

    <script type="text/javascript">
        window.print();
    </script>
</body>

</html>
