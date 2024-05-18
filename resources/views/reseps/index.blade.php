@extends('layouts.app')

@section('content')
<div class="container mb-4">
    <h2>Daftar Resep</h2>
    <a href="{{ route('reseps.create') }}" class="btn btn-primary">Buat Resep Baru</a>
    <table class="table mt-4">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Racikan</th>
                <th>Details</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($reseps as $resep)
                <tr>
                    <td>{{ $resep->id }}</td>
                    <td>{{ $resep->nama_racikan }}</td>
                    <td>
                        <ul>
                            @foreach($resep->details as $detail)
                                <li>{{ $detail->obat->obatalkes_nama }} - {{ $detail->qty }} - {{ $detail->signa->signa_nama }}</li>
                            @endforeach
                        </ul>
                    </td>
                    <td>{{ $resep->created_at }}</td>
                    <td>
                        <a href="{{ route('reseps.cetak', $resep->id) }}" class="btn btn-primary">Cetak PDF</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
