<h2>Resep</h2>
<p>Nama Racikan: {{ $resep->nama_racikan }}</p>
<table>
    <thead>
        <tr>
            <th>Obat</th>
            <th>Signa</th>
            <th>Qty</th>
        </tr>
    </thead>
    <tbody>
        @foreach($resep->details as $detail)
            <tr>
                <td>{{ $detail->obat->obatalkes_nama }}</td>
                <td>{{ $detail->signa->signa_nama }}</td>
                <td>{{ $detail->qty }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
