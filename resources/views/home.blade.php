@extends('layouts.master')

@section('content')
    <style>
        .custom-progress {
            height: 45px;
            font-size: 18px;
            font-weight: 600;
        }
    </style>

    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="section">
            @if (Auth::user()->groups()->where('group_id', 1)->exists())
                <div class="row">
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h5>Jumlah data Masuk</h5>
                            </div>
                            <div class="card-body">
                                <h2>{{ $data['dataMasuk'] }}</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h5>Total Kecamatan</h5>
                            </div>
                            <div class="card-body">
                                <h2>24</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card">
                            <div class="card-header">
                                <h5>Total Desa/kelurahan</h5>
                            </div>
                            <div class="card-body">
                                <h2>365</h2>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="card">
                            <div class="card-header">
                                <h5>Total TPS</h5>
                            </div>
                            <div class="card-body">
                                <h2>2338</h2>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Jumlah data per Kecamatan</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="kecamatanChart"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Jumlah data per Desa</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="desaChart"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Jumlah data per TPS</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="tpsChart" height="1000"></canvas>
                    </div>
                </div>
            @elseif (Auth::user()->groups()->where('group_id', 2)->exists())
                <div class="card">
                    <div class="card-header">
                        <h5>Jumlah data per Desa</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="desaChart"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Jumlah data per TPS</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="tpsChart" height="1000"></canvas>
                    </div>
                </div>
            @elseif (Auth::user()->groups()->where('group_id', 3)->exists())
                <div class="card">
                    <div class="card-header">
                        <h5>Jumlah data per TPS</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="tpsChart" height="1000"></canvas>
                    </div>
                </div>
            @elseif (Auth::user()->groups()->where('group_id', 4)->exists())
                <div class="card">
                    <div class="card-header">
                        <h5>Progresku</h5>
                    </div>
                    <div class="card-body">
                        <div class="progress custom-progress">
                            <div class="progress-bar progress-bar-striped progress-bar-animated
                           @if ($data['progressPercentage'] < 50) bg-danger
                           @elseif($data['progressPercentage'] < 80) bg-warning
                           @else bg-success @endif"
                                role="progressbar" style="width: {{ $data['progressPercentage'] }}%;"
                                aria-valuenow="{{ $data['progressPercentage'] }}" aria-valuemin="0" aria-valuemax="100">
                                {{ round($data['progressPercentage'], 2) }}%
                            </div>
                        </div>
                        <p class="mt-2">
                            Anda telah mengisi {{ $data['progresku'] }} dari {{ $data['totalData'] }} data.
                        </p>
                    </div>
                </div>
            @endif
        </section>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom"></script>
    <script>
        // Ambil data dari PHP
        const kecamatanData = @json($data['byKecamatan']);
        const kecamatanLabels = kecamatanData.map(item => item.kecamatan);
        const kecamatanValues = kecamatanData.map(item => item.total);

        // Buat warna background secara dinamis
        const kecamatanBackgroundColors = kecamatanLabels.map(() => {
            return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.5)`;
        });

        // Inisialisasi Chart.js
        const ctx = document.getElementById('kecamatanChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: kecamatanLabels,
                datasets: [{
                    label: 'Jumlah Data per Kecamatan',
                    data: kecamatanValues,
                    backgroundColor: kecamatanBackgroundColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: true
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `${tooltipItem.raw} data`;
                            }
                        }
                    },
                    datalabels: { // Konfigurasi untuk menampilkan jumlah data
                        anchor: 'end',
                        align: 'top',
                        formatter: (value) => value, // Menampilkan nilai data
                        font: {
                            size: 12
                        },
                        color: '#000' // Warna label
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
            plugins: [ChartDataLabels] // Aktifkan plugin
        });
    </script>

    <script>
        // Data dari backend
        const desaLabels = @json($data['byDesa']->pluck('desa'));
        const desaValues = @json($data['byDesa']->pluck('total'));

        // Warna background untuk batang
        const desaBackgroundColors = desaLabels.map(() => {
            return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.7)`; // Warna batang dengan transparansi
        });

        // Inisialisasi Chart.js
        const ctxDesa = document.getElementById('desaChart').getContext('2d');
        new Chart(ctxDesa, {
            type: 'bar',
            data: {
                labels: desaLabels,
                datasets: [{
                    label: 'Jumlah Data per Desa',
                    data: desaValues,
                    backgroundColor: desaBackgroundColors,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        display: false // Sembunyikan legenda jika tidak diperlukan
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return `Jumlah: ${tooltipItem.raw}`;
                            }
                        }
                    },
                    datalabels: { // Konfigurasi untuk menampilkan jumlah data
                        anchor: 'end',
                        align: 'top',
                        formatter: (value) => value, // Menampilkan nilai data
                        font: {
                            size: 12
                        },
                        color: '#000' // Warna label
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            },
            plugins: [ChartDataLabels] // Aktifkan plugin datalabels
        });
    </script>

    <script>
        const tpsData = @json($data['byTps']);
        const tpsLabels = tpsData.map(item => `${item.user_name}`);
        const tpsValues = tpsData.map(item => item.total);

        const tpsBackgroundColors = tpsLabels.map(() => {
            return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.5)`;
        });

        const ctxTps = document.getElementById('tpsChart').getContext('2d');
        new Chart(ctxTps, {
            type: 'bar', // Tetap menggunakan "bar"
            data: {
                labels: tpsLabels,
                datasets: [{
                    label: 'Jumlah Data per TPS',
                    data: tpsValues,
                    backgroundColor: tpsBackgroundColors,
                    borderWidth: 1
                }]
            },
            options: {
                indexAxis: 'y', // Mengatur sumbu menjadi horizontal
                responsive: true,
                plugins: {
                    tooltip: {
                        callbacks: {
                            title: (tooltipItems) => {
                                const index = tooltipItems[0].dataIndex;
                                return tpsLabels[index];
                            },
                            label: (tooltipItem) => {
                                return `Jumlah: ${tooltipItem.raw}`;
                            }
                        }
                    },
                    legend: {
                        display: false // Sembunyikan legenda jika tidak diperlukan
                    },
                    datalabels: { // Plugin untuk menampilkan jumlah data di bar
                        anchor: 'end',
                        align: 'right',
                        formatter: (value) => value, // Tampilkan nilai data
                        color: '#000', // Warna teks
                        font: {
                            size: 12, // Ukuran font
                        }
                    }
                },
                scales: {
                    x: { // Sumbu x untuk nilai
                        beginAtZero: true
                    },
                    y: { // Sumbu y untuk label
                        beginAtZero: false
                    }
                }
            },
            plugins: [ChartDataLabels] // Daftarkan plugin Data Labels
        });
    </script>
@endpush
