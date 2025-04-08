@extends('layouts.app', ['activePage' => 'dashboard', 'title' => 'Dashboard Transaksi', 'navName' => 'Dashboard', 'activeButton' => 'laravel'])

@section('content')
    <div class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Total Transaksi</h4>
                        </div>
                        <div class="card-body">
                            <h3>{{ $totalTransaksi }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Total Pengguna</h4>
                        </div>
                        <div class="card-body">
                            <h3>{{ $totalUsers }}</h3>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Total Gudang</h4>
                        </div>
                        <div class="card-body">
                            <h3>{{ $totalGudang }}</h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4 class="card-title">Grafik Transaksi Per Bulan</h4>
                        </div>
                        <div class="card-body">
                            <canvas id="transaksiChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById("transaksiChart").getContext("2d");
            var transaksiChart = new Chart(ctx, {
                type: "bar",
                data: {
                    labels: @json($transaksiPerBulan->pluck('month')),
                    datasets: [{
                        label: "Jumlah Transaksi",
                        data: @json($transaksiPerBulan->pluck('total')),
                        backgroundColor: "#36a2eb",
                        borderColor: "#0366d6",
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: { beginAtZero: true }
                    }
                }
            });
        });
    </script>
@endpush
