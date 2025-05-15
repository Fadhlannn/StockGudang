@extends('layouts.app', ['activePage' => 'RekapOrder', 'title' => 'Rekap Total Order'])

@section('content')
<div class="container mt-4">
    @if(isset($rekap) && count($rekap) > 0)
        @foreach ($rekap as $no_order => $data)
            <h2 class="mb-4">Rekap Total Harga per No Order: {{ $no_order }}</h2>

            <div class="card mb-3">
                <div class="card-header">
                    <strong>No Order: {{ $no_order }}</strong> — Total: <strong>Rp{{ number_format($data['total'], 0, ',', '.') }}</strong>
                </div>
                <div class="card-body">
                    <table class="table table-sm">
                        <thead>
                            <tr>
                                <th>Nama Barang</th>
                                <th>Jumlah</th>
                                <th>Harga Satuan</th>
                                <th>Subtotal</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['items'] as $item)
                                <tr>
                                    <td>{{ $item->nama_barang }}</td>
                                    <td>{{ $item->jumlah }}</td>
                                    <td>Rp{{ number_format($item->harga_satuan, 0, ',', '.') }}</td>
                                    <td>Rp{{ number_format($item->total_harga, 0, ',', '.') }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                      <div class="mt-3">
                          <strong>Total Semua: </strong>
                        <span>Rp{{ number_format($data['items']->sum('total_harga'), 0, ',', '.') }}</span>
                </div>
            </div>
        @endforeach
    @else
        <p>Tidak ada data untuk order ini.</p>
    @endif
</div>
@endsection
