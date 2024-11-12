@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Data</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5>Data</h5>
                </div>
                <div class="card-body table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kecamatan</th>
                                    <th>Desa</th>
                                    <th>NIK</th>
                                    <th>Nama Lengkap</th>
                                    <th>Foto Diri</th>
                                    <th>Foto KTP</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($data as $item)
                                    <tr>
                                        <td>{{ $loop->iteration + ($data->currentPage() - 1) * $data->perPage() }}</td>
                                        <td>{{ $item->kecamatan }}</td>
                                        <td>{{ $item->desa }}</td>
                                        <td>{{ $item->nik }}</td>
                                        <td>{{ $item->nama_lengkap }}</td>
                                        <td>
                                            <img src="{{ $item->foto_ktp }}" alt="" height="120px">
                                        </td>
                                        <td>
                                            <img src="{{ $item->foto_diri }}" alt="" height="120px">
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="8" class="text-center">Tidak ada data.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="d-flex justify-content-center">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script></script>
@endpush
