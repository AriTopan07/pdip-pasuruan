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
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Jumlah data per Kecamatan</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="kecamatanChart"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h5>Jumlah data per Desa</h5>
                            </div>
                            <div class="card-body">
                                <canvas id="desaChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Jumlah data per TPS</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="tpsChart"></canvas>
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
                        <canvas id="tpsChart"></canvas>
                    </div>
                </div>
            @elseif (Auth::user()->groups()->where('group_id', 3)->exists())
                <div class="card">
                    <div class="card-header">
                        <h5>Jumlah data per TPS</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="tpsChart"></canvas>
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
    <script>
        const kecamatanLabels = @json($data['byKecamatan']->pluck('kecamatan'));
        const kecamatanValues = @json($data['byKecamatan']->pluck('total'));

        // Render chart
        const ctx = document.getElementById('kecamatanChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: kecamatanLabels,
                datasets: [{
                    label: 'Jumlah Data per Kecamatan',
                    data: kecamatanValues,
                    backgroundColor: 'rgba(255, 0, 0, 0.6)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        const desaLabels = @json($data['byDesa']->pluck('desa'));
        const desaValues = @json($data['byDesa']->pluck('total'));

        const desaBackgroundColors = desaLabels.map(() => {
            return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.5)`;
        });

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
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
    <script>
        const tpsData = @json($data['byTps']);
        const tpsLabels = tpsData.map(item => `TPS ${item.tps} - Desa ${item.desa}, Kec ${item.kecamatan}`);
        const tpsValues = tpsData.map(item => item.total);

        const tpsBackgroundColors = tpsLabels.map(() => {
            return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.5)`;
        });

        const ctxTps = document.getElementById('tpsChart').getContext('2d');
        new Chart(ctxTps, {
            type: 'bar',
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
                responsive: true,
                scales: {
                    y: {
                        beginAtZero: true
                    }
                }
            }
        });
    </script>
@endpush
