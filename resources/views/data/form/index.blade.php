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
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Kecamatan</th>
                                <th>Desa</th>
                                <th>Nama Lengkap</th>
                                <th>Foto KTP</th>
                                <th>Foto Diri</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->kecamatan }}</td>
                                    <td>{{ $item->desa }}</td>
                                    <td>{{ $item->nama_lengkap }}</td>
                                    <td>
                                        <img src="{{ $item->foto_ktp }}" alt="" height="100">
                                    </td>
                                    <td>
                                        <img src="{{ $item->foto_diri }}" alt="" height="100">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script></script>
@endpush
