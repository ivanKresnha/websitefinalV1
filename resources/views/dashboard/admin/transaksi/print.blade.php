<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BUKTI TRANSAKSI</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            box-sizing: border-box;
            letter-spacing: 0.5px;
        }

        body {
            padding: 20px;
        }

        h1,
        h2,
        h3 {
            text-align: center;
        }

        h1 {
            margin-bottom: 0;
        }

        h2 {
            margin-top: 0;
        }

        .header-table {
            margin-bottom: 20px;
        }

        .logo {
            display: block;
            margin: 10px auto;
            width: 200px;
        }

        table {
            width: 100%;
            margin: 25px auto;
            border-collapse: collapse;
            box-shadow: 0px 10px 30px 5px rgba(0, 0, 0, 0.15);
        }

        table th,
        table td {
            border: 1px solid black;
            padding: 12px;
            text-align: left;
        }

        thead th {
            background-color: #f4f4f4;
            font-weight: bold;
        }

        tfoot td {
            font-weight: bold;
            text-align: right;
        }

        .right-align {
            text-align: right;
        }

        /* Additional styling for better layout */
        td[colspan="3"] {
            text-align: left;
        }

        td[colspan="5"] {
            text-align: left;
        }

        td {
            padding: 8px 12px;
        }
    </style>
</head>

<body>

    <!-- Add Toko Rida Frozen Food and Logo -->
    <h1>TOKO RIDA FROZEN FOOD</h1>
    <h2>ID TRANSAKSI: TRX-{{ $transaction->id }}</h2>

    <table class="header-table">
        <tr>
            <td style="width: 30%;">Nama Pelanggan:</td>
            <td>{{ $transaction->user->name }}</td>
        </tr>
        <tr>
            <td>Tanggal Transaksi:</td>
            <td>{{ $transaction->tgl_transaksi }}</td>
        </tr>
        <tr>
            <td>Status Transaksi:</td>
            <td>{{ $transaction->status_transaksi }}</td>
        </tr>
    </table>

    <h2>DETAIL PRODUK</h2>
    <table>
        <thead>
            <tr>
                <th style="width: 40%;">Nama Produk</th>
                <th style="width: 15%;">Jumlah</th>
                <th style="width: 25%;">Harga Satuan</th>
                <th style="width: 20%;">Total Harga</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaction->details as $detail)
                <tr>
                    <td>{{ $detail->product->nama }}</td>
                    <td>{{ $detail->jmlh_pesan }}</td>
                    <td>Rp{{ number_format($detail->product->harga, 2, ',', '.') }}</td>
                    <td>Rp{{ number_format($detail->total_harga_produk, 2, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <!-- Total Harga Barang -->
            <tr>
                <td colspan="3" class="right-align"><strong>Total Seluruh Harga Barang:</strong></td>
                <td>Rp{{ number_format($total_harga_produk, 0, ',', '.') }}</td>
            </tr>

            <!-- Ongkos Kirim -->
            <tr>
                <td colspan="3" class="right-align"><strong>Total Ongkos Kirim (10%):</strong></td>
                <td>Rp{{ number_format($ongkosKirim, 0, ',', '.') }}</td>
            </tr>

            <!-- Total Harga Seluruh -->
            <tr>
                <td colspan="3" class="right-align"><strong>Total Harga Seluruh:</strong></td>
                <td>Rp{{ number_format($total_harga_seluruh, 0, ',', '.') }}</td>
            </tr>

            <!-- Total Bayar -->
            <tr>
                <td colspan="3" class="right-align"><strong>Total Bayar:</strong></td>
                <td>Rp{{ number_format($total_bayar, 0, ',', '.') }}</td>
            </tr>

            <!-- Kembalian -->
            <tr>
                <td colspan="3" class="right-align"><strong>Kembalian:</strong></td>
                <td>Rp{{ number_format($transaction->kembalian, 0, ',', '.') }}</td>
            </tr>
        </tfoot>
    </table>

    <br>
    <h1>TERIMA KASIH!</h1>
    <h3>
        Kami menghargai kepercayaan Anda dalam menggunakan layanan kami.
        <br>
        Semoga Anda puas dengan transaksi ini dan kami berharap dapat melayani Anda lagi!
    </h3>

    <!-- SCRIPT UNTUK PRINT -->
    <script type="text/javascript">
        window.print();
    </script>

</body>

</html>
