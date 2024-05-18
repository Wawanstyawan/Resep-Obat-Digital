<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resep</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 10px;
            text-align: left;
        }
    </style>
</head>
<body>
    <h2>Resep</h2>
    <p>ID Resep: {{ $resep->id }}</p>
    <p>Nama Racikan: {{ $resep->nama_racikan }}</p>
    <h3>Detail Resep</h3>
    <table>
        <thead>
            <tr>
                <th>Obat</th>
                <th>Quantity</th>
                <th>Signa</th>
            </tr>
        </thead>
        <tbody>
            @foreach($resep->details as $detail)
                <tr>
                    <td>{{ $detail->obat->obatalkes_nama }}</td>
                    <td>{{ $detail->qty }}</td>
                    <td>{{ $detail->signa->signa_nama }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
