<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
    </style>
</head>
<body>
    <h2 style="text-align: center;">Riwayat Transaksi Sparepart</h2>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Sparepart</th>
                <th>Jenis Transaksi</th>
                <th>Gudang</th>
                <th>Tanggal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($transaksi as $index => $t)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $t->sparepart->name }}</td>
                    <td>{{ $t->jenis_transaksi }}</td>
                    <td>{{ $t->gudang->nama_gudang }}</td>
                    <td>{{ $t->tanggal->format('d-m-Y') }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
