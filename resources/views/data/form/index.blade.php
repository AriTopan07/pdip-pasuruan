@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Data Canvassing</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5>Tampilkan data berdasarkan Kec/Desa</h5>
                    <form action="{{ route('formulir.index') }}">
                        <div class="row">
                            <div class="col-lg-2">
                                <select name="kecamatan" id="kecamatan" class="form-control">
                                    <option selected disabled>Pilih Kecamatan</option>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <select name="desa" id="desa" class="form-control">
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <button class="btn btn-primary">Tampilkan</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="card-body table-responsive">
                    <div class="table-responsive">
                        <table class="table table-striped table-hover mt-3">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Kecamatan</th>
                                    <th>Desa</th>
                                    <th>NIK</th>
                                    <th>Nama Lengkap</th>
                                    <th>Foto KTP</th>
                                    <th>Foto Diri</th>
                                    {{-- <th>Aksi</th> --}}
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
    <script>
        $(document).ready(function() {
            $.ajax({
                url: "/kecamatan",
                method: "GET",
                success: function(data) {
                    data.forEach(function(kecamatan) {
                        $('#kecamatan').append(
                            `<option value="${kecamatan}">${kecamatan}</option>`
                        );
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Gagal mengambil data kecamatan:", error);
                    $('#loading-kecamatan').text("Gagal memuat data kecamatan");
                }
            });

            $('#kecamatan').on('change', function() {
                var kecamatanId = $(this).val();

                if (kecamatanId) {
                    $('#desa').empty().append(
                        '<option selected disabled>Pilih Desa</option>');

                    $.ajax({
                        url: `/desa/${kecamatanId}`,
                        method: "GET",
                        success: function(data) {
                            $('#loading-desa').hide();

                            data.forEach(function(desa) {
                                $('#desa').append(
                                    `<option value="${desa.KELURAHAN}">${desa.KELURAHAN}</option>`
                                );
                            });
                        },
                        error: function(xhr, status, error) {
                            console.error("Gagal mengambil data desa:", error);
                            $('#loading-desa').text("Gagal memuat data desa");
                        }
                    });
                } else {
                    $('#desa').empty().append(
                        '<option value="">Pilih Desa</option>');
                }
            });

        });
    </script>
@endpush
