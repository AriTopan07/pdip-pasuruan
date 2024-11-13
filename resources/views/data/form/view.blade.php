@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Tambah Data Peserta</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5>Form Tambah Data</h5>
                </div>
                <div class="card-body">
                    <form action="" id="tambahData" method="" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <label class="fw-bold">Kecamatan<span class="text-danger">*wajib diisi</span></label>
                            <div class="form-group">
                                <select name="kecamatan" id="kecamatan" class="form-control">
                                    <option value="">Pilih Kecamatan</option>
                                </select>
                                <p class="invalid-feedback"></p>
                            </div>
                            <label class="fw-bold">Kelurahan/Desa<span class="text-danger">*wajib diisi</span></label>
                            <div class="form-group">
                                <select name="desa" id="desa" class="form-control">
                                </select>
                                <p class="invalid-feedback"></p>
                            </div>
                            <label class="fw-bold">Nama Lengkap Pemilih<span class="text-danger">*wajib diisi</span></label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap"
                                    autocomplete="off">
                                <p class="invalid-feedback"></p>
                            </div>
                            <label class="fw-bold">NIK Pemilih (tidak wajib)</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="nik" id="nik" autocomplete="off">
                                <p class="invalid-feedback"></p>
                            </div>
                            <label class="fw-bold">Foto KTP (tidak wajib)</label>
                            <div class="form-group">
                                <input type="file" name="foto_ktp" id="foto_ktp" accept="image/*"
                                    style="display: none;">
                                <button type="button" class="btn btn-primary"
                                    onclick="document.getElementById('foto_ktp').click();">
                                    Upload/Ambil Foto KTP
                                </button>
                                <span id="file-name-ktp"
                                    style="margin-left: 10px; font-weight: bold; font-size: 14px;"></span>
                                <p class="invalid-feedback"></p>
                            </div>
                            <label class="fw-bold">Foto Diri<span class="text-danger">*wajib diisi</span></label>
                            <div class="form-group">
                                <input type="file" name="foto_diri" id="foto_diri" accept="image/*"
                                    style="display: none;">
                                <button type="button" class="btn btn-primary"
                                    onclick="document.getElementById('foto_diri').click();">
                                    Upload/Ambil Foto Diri
                                </button>
                                <span id="file-name-diri"
                                    style="margin-left: 10px; font-weight: bold; ; font-size: 14px;"></span>
                                <p class="invalid-feedback"></p>
                            </div>
                        </div>
                        <button type="submit" id="simpan" class="btn btn-primary float-end">
                            Simpan
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('js')
    <script>
        document.getElementById('foto_ktp').addEventListener('change', function() {
            var fileName = this.files[0] ? this.files[0].name : '';
            document.getElementById('file-name-ktp').textContent = fileName;
        });
        document.getElementById('foto_diri').addEventListener('change', function() {
            var fileName = this.files[0] ? this.files[0].name : '';
            document.getElementById('file-name-diri').textContent = fileName;
        });

        function compressImage(file, maxSizeMB, callback) {
            console.log("Original file size:", (file.size / (1024 * 1024)).toFixed(2), "MB");

            const reader = new FileReader();
            reader.readAsDataURL(file);
            reader.onload = function(event) {
                const img = new Image();
                img.src = event.target.result;
                img.onload = function() {
                    const canvas = document.createElement('canvas');
                    const ctx = canvas.getContext('2d');
                    const scaleFactor = Math.sqrt(maxSizeMB * 1024 * 1024 / file.size);

                    canvas.width = img.width * scaleFactor;
                    canvas.height = img.height * scaleFactor;

                    ctx.drawImage(img, 0, 0, canvas.width, canvas.height);

                    canvas.toBlob(function(blob) {
                        console.log("Compressed file size:", (blob.size / (1024 * 1024)).toFixed(2), "MB");
                        callback(blob);
                    }, 'image/jpeg', 0.7); // Adjust the quality parameter as needed
                };
            };
        }

        function handleFileChange(inputId, spanId, maxSizeKB) {
            const input = document.getElementById(inputId);
            const span = document.getElementById(spanId);

            input.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    if (file.size / 1024 > maxSizeKB) { // Check if size exceeds 800KB
                        // Compress the image if it exceeds maxSizeKB
                        compressImage(file, maxSizeKB / 1024, function(compressedBlob) {
                            const compressedFile = new File([compressedBlob], file.name, {
                                type: 'image/jpeg'
                            });
                            span.textContent = `${compressedFile.name} (compressed)`;

                            // Set the compressed file to the input
                            const dataTransfer = new DataTransfer();
                            dataTransfer.items.add(compressedFile);
                            input.files = dataTransfer.files;
                        });
                    } else {
                        // No need to compress
                        console.log("File size within limit, no compression needed:", (file.size / 1024).toFixed(2),
                            "KB");
                        span.textContent = file.name;
                    }
                }
            });
        }

        // Set max size to 800KB (800 * 1024 bytes)
        handleFileChange('foto_ktp', 'file-name-ktp', 800);
        handleFileChange('foto_diri', 'file-name-diri', 800);
    </script>
    <script>
        $(document).ready(function() {

            $.ajax({
                url: "https://www.emsifa.com/api-wilayah-indonesia/api/districts/3514.json",
                method: "GET",
                success: function(data) {
                    // Tambahkan opsi kecamatan ke dalam dropdown
                    data.forEach(function(kecamatan) {
                        $('#kecamatan').append(
                            `<option value="${kecamatan.id}">${kecamatan.name}</option>`
                        );
                    });
                },
                error: function(xhr, status, error) {
                    console.error("Gagal mengambil data kecamatan:", error);
                    $('#loading-kecamatan').text("Gagal memuat data kecamatan");
                }
            });

            // Event change pada dropdown kecamatan untuk mengambil data desa
            $('#kecamatan').on('change', function() {
                var kecamatanId = $(this).val();

                if (kecamatanId) {
                    // $('#desa').empty().append('<option value="">Pilih Desa</option>'); // Reset desa

                    $.ajax({
                        url: `https://www.emsifa.com/api-wilayah-indonesia/api/villages/${kecamatanId}.json`,
                        method: "GET",
                        success: function(data) {
                            // Sembunyikan spinner desa setelah data berhasil diambil
                            $('#loading-desa').hide();

                            data.forEach(function(desa) {
                                $('#desa').append(
                                    `<option value="${desa.id}">${desa.name}</option>`
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

            $('#tambahData').submit(function(event) {
                event.preventDefault();

                let kecamatan = $('#kecamatan').find('option:selected').text();
                let desa = $('#desa').find('option:selected').text();
                let nik = $('#nik').val();
                let namaLengkap = $('#nama_lengkap').val();
                let fotoKtp = document.getElementById('foto_ktp').files[0];
                let fotoDiri = document.getElementById('foto_diri').files[0];

                // console.log("Kecamatan:", kecamatan);
                // console.log("Desa:", desa);
                // console.log("Nama Lengkap:", namaLengkap);
                // console.log("Foto KTP:", fotoKtp ? fotoKtp.name : "Tidak ada file");
                // console.log("Foto Diri:", fotoDiri ? fotoDiri.name : "Tidak ada file");

                let formData = new FormData(this);
                formData.append('kecamatan', kecamatan);
                formData.append('desa', desa);
                formData.append('nik', nik);
                formData.append('nama_lengkap', namaLengkap);
                formData.append('foto_ktp', fotoKtp);
                formData.append('foto_diri', fotoDiri);

                let submitButton = $("button[id='simpan']");
                submitButton.prop('disabled', true);

                let spinnerHtml =
                    '<div class="spinner-border text-light spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>';
                let originalButtonHtml = submitButton.html();
                submitButton.html(spinnerHtml);

                $.ajax({
                    url: '{{ route('formulir.store') }}', // URL tujuan
                    type: 'POST',
                    data: formData,
                    processData: false, // Jangan proses data
                    contentType: false, // Jangan set content-type secara manual
                    success: function(data) {
                        console.log("Data berhasil dikirim:", data);
                        submitButton.prop('disabled', false);
                        submitButton.html('Submit');

                        if (data['success'] === true) {
                            window.location.reload();
                            $('.invalid-feedback').removeClass('invalid-feedback').html('');
                            $("input[type='text'], select, input[type='number'], input[type='file'], textarea")
                                .removeClass('is-invalid');
                        } else {
                            $('.invalid-feedback').removeClass('invalid-feedback').html('');
                            $("input[type='text'], select, input[type='number'], input[type='file'], textarea")
                                .removeClass('is-invalid');

                            $.each(data.errors, function(field, errorMessage) {
                                $("#" + field).addClass('is-invalid')
                                    .siblings('p')
                                    .addClass('invalid-feedback')
                                    .html(errorMessage[0]);
                            });
                        }
                    },
                    error: function() {
                        console.log('Terjadi kesalahan');
                        submitButton.prop('disabled', false);
                        submitButton.html(originalButtonHtml);
                    }
                });
            });

        });
    </script>
@endpush
