@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Tambah Data Canvassing</h3>
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

            // $.ajax({
            //     url: "/kecamatan",
            //     method: "GET",
            //     success: function(data) {
            //         // Tambahkan opsi kecamatan ke dalam dropdown
            //         data.forEach(function(kecamatan) {
            //             $('#kecamatan').append(
            //                 `<option value="${kecamatan}">${kecamatan}</option>`
            //             );
            //         });
            //     },
            //     error: function(xhr, status, error) {
            //         console.error("Gagal mengambil data kecamatan:", error);
            //         $('#loading-kecamatan').text("Gagal memuat data kecamatan");
            //     }
            // });

            // // Event change pada dropdown kecamatan untuk mengambil data desa
            // $('#kecamatan').on('change', function() {
            //     var kecamatanId = $(this).val();

            //     if (kecamatanId) {
            //         $('#desa').empty().append(
            //             '<option selected disabled>Pilih Desa</option>'); // Reset desa

            //         $.ajax({
            //             url: `/desa/${kecamatanId}`,
            //             method: "GET",
            //             success: function(data) {
            //                 // Sembunyikan spinner desa setelah data berhasil diambil
            //                 $('#loading-desa').hide();

            //                 data.forEach(function(desa) {
            //                     $('#desa').append(
            //                         `<option value="${desa.KELURAHAN}">${desa.KELURAHAN}</option>`
            //                     );
            //                 });
            //             },
            //             error: function(xhr, status, error) {
            //                 console.error("Gagal mengambil data desa:", error);
            //                 $('#loading-desa').text("Gagal memuat data desa");
            //             }
            //         });
            //     } else {
            //         $('#desa').empty().append(
            //             '<option value="">Pilih Desa</option>');
            //     }
            // });

            $('#tambahData').submit(function(event) {
                event.preventDefault();

                let submitButton = $("button[id='simpan']");
                let spinnerHtml =
                    '<div class="spinner-border text-light spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>';
                let originalButtonHtml = submitButton.html();
                submitButton.prop('disabled', true).html(spinnerHtml);

                let formData = new FormData(this);

                $.ajax({
                    url: '{{ route('formulir.store') }}',
                    type: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(data) {
                        submitButton.prop('disabled', false).html(originalButtonHtml);
                        if (data.success) {
                            window.location.reload();
                        } else {
                            showValidationErrors(data.errors);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.log('Terjadi kesalahan', error);
                        submitButton.prop('disabled', false);
                        submitButton.html(originalButtonHtml);

                        alert(error);
                    }
                });

                function showValidationErrors(errors) {
                    // Reset semua error sebelumnya
                    $('.invalid-feedback').remove();
                    $("input, select, textarea").removeClass('is-invalid');

                    // Tampilkan error pada input yang sesuai
                    $.each(errors, function(field, messages) {
                        let input = $(`[name='${field}']`);
                        if (input.length > 0) {
                            input.addClass('is-invalid');
                            input.after(
                                `<div class="invalid-feedback">${messages.join('<br>')}</div>`);
                        }
                    });
                }
            });

        });
    </script>
@endpush
