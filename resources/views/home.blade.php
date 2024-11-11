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
            @if (Auth::user()->groups()->whereIn('group_id', [1, 2])->exists())
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
                <div class="card">
                    <div class="card-header">
                        <h5>Jumlah data per Kecamatan</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="kecamatanChart" width="1000" height="170"></canvas>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5>Jumlah data per Desa</h5>
                    </div>
                    <div class="card-body">
                        <canvas id="desaChart" width="1000" height="170"></canvas>
                    </div>
                </div>
            @elseif (Auth::user()->groups()->where('group_id', 3)->exists())
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
            @else
                <p>User tidak memiliki akses yang sesuai.</p>
            @endif
        </section>
    </div>
@endsection

@push('js')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        // Ambil data dari controller
        const kecamatanLabels = @json($data['byKecamatan']->pluck('kecamatan'));
        const kecamatanValues = @json($data['byKecamatan']->pluck('total'));

        // Render chart
        const ctx = document.getElementById('kecamatanChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar', // Bisa diganti dengan 'pie', 'line', dll.
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
        // Data berdasarkan desa
        const desaLabels = @json($data['byDesa']->pluck('desa'));
        const desaValues = @json($data['byDesa']->pluck('total'));

        // Generate warna untuk chart desa
        const desaBackgroundColors = desaLabels.map(() => {
            return `rgba(${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, ${Math.floor(Math.random() * 255)}, 0.5)`;
        });

        // Render chart berdasarkan desa
        const ctxDesa = document.getElementById('desaChart').getContext('2d');
        new Chart(ctxDesa, {
            type: 'bar',
            data: {
                labels: desaLabels,
                datasets: [{
                    label: 'Jumlah Data per Desa',
                    data: desaValues,
                    backgroundColor: desaBackgroundColors,
                    borderColor: desaBackgroundColors,
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
