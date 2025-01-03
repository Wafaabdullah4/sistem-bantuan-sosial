<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Bantuan - Bantunusa</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #0a7e8c;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        h1 {
            text-align: center;
            color: #0a7e8c;
            margin-top: 20px;
            font-size: 28px;
        }
        table {
            width: 100%;
            margin: 20px auto;
            border-collapse: collapse;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            background-color: white;
        }
        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }
        th {
            background-color: #0a7e8c;
            color: white;
            font-weight: bold;
        }
        tr:nth-child(even) {
            background-color: #f9f9f9;
        }
        tr:hover {
            background-color: #f1f1f1;
        }
        footer {
            text-align: center;
            font-size: 14px;
            color: #777;
            margin-top: 40px;
            padding: 10px;
            background-color: #0a7e8c;
            color: white;
        }
    </style>
</head>
<body>

    <header>
        Laporan Bantuan - Bantunusa
    </header>

    <h1>Laporan Bantuan</h1>

    <table>
        <thead>
            <tr>
                <th>Wilayah</th>
                <th>Program</th>
                <th>Status</th>
                <th>Tanggal Penyaluran</th>
                <th>Jumlah Penerima</th>
            </tr>
        </thead>
        <tbody>
            @foreach($laporanBantuans as $laporan)
                <tr>
                    <td>{{ $laporan->wilayah->nama_wilayah }}</td>
                    <td>{{ $laporan->program->nama_program }}</td>
                    <td>{{ $laporan->status }}</td>
                    <td>{{ $laporan->tanggal_penyaluran }}</td>
                    <td>{{ $laporan->jumlah_penerima }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <footer>
        <p>&copy; 2025 Bantunusa | Semua hak cipta dilindungi</p>
    </footer>

</body>
</html>
