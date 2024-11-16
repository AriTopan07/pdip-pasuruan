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
                <div class="row" style="max-height: 120vh; overflow-y: auto;">
                    @foreach ($tpsData as $desa => $dataPerDesa)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Jumlah Data Desa: {{ $desa }}</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="chart-{{ Str::slug($desa) }}" height="300"></canvas>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const ctx = document.getElementById('chart-{{ Str::slug($desa) }}').getContext('2d');
                                const tpsData = @json($dataPerDesa);

                                const labels = tpsData.map(data => data.user_name); // Menggunakan user_name
                                const dataCounts = tpsData.map(data => data.total);
                                const bgColors = kecamatanLabels.map(() => {
                                    return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.8)`;
                                });

                                new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Jumlah Data per TPS',
                                            data: dataCounts,
                                            backgroundColor: bgColors,
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
                                    plugins: [ChartDataLabels]
                                });
                            });
                        </script>
                    @endforeach
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
                <div class="row" style="max-height: 120vh; overflow-y: auto;">
                    @foreach ($tpsData as $desa => $dataPerDesa)
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Jumlah Data Desa: {{ $desa }}</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="chart-{{ Str::slug($desa) }}" height="300"></canvas>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const ctx = document.getElementById('chart-{{ Str::slug($desa) }}').getContext('2d');
                                const tpsData = @json($dataPerDesa);

                                const labels = tpsData.map(data => data.user_name); // Menggunakan user_name
                                const dataCounts = tpsData.map(data => data.total);
                                const bgColors = kecamatanLabels.map(() => {
                                    return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.8)`;
                                });

                                new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Jumlah Data per TPS',
                                            data: dataCounts,
                                            backgroundColor: bgColors,
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
                                    plugins: [ChartDataLabels]
                                });
                            });
                        </script>
                    @endforeach
                </div>
            @elseif (Auth::user()->groups()->where('group_id', 3)->exists())
                <div class="row">
                    @foreach ($tpsData as $desa => $dataPerDesa)
                        <div class="col">
                            <div class="card">
                                <div class="card-header">
                                    <h5>Jumlah Data Desa: {{ $desa }}</h5>
                                </div>
                                <div class="card-body">
                                    <canvas id="chart-{{ Str::slug($desa) }}" height="120"></canvas>
                                </div>
                            </div>
                        </div>

                        <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                const ctx = document.getElementById('chart-{{ Str::slug($desa) }}').getContext('2d');
                                const tpsData = @json($dataPerDesa);

                                const labels = tpsData.map(data => data.user_name); // Menggunakan user_name
                                const dataCounts = tpsData.map(data => data.total);
                                const bgColors = kecamatanLabels.map(() => {
                                    return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.8)`;
                                });

                                new Chart(ctx, {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Jumlah Data per TPS',
                                            data: dataCounts,
                                            backgroundColor: bgColors,
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
                                    plugins: [ChartDataLabels]
                                });
                            });
                        </script>
                    @endforeach
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
            return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.7)`;
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
@endpush
