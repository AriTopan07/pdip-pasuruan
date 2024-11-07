@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Data Akses {{ $groups->name }}</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-body table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Menu</th>
                                <th colspan="2">Akses</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($menus as $menu)
                                @csrf
                                <tr>
                                    <input type="hidden" value="{{ $groups->id }}" class="group_id" id="group_id">
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $menu->name_menu }}</td>
                                    <td>
                                        <div class="form-check form-check-inline">
                                            <input id="allCheck-{{ $menu->id }}"
                                                onclick="checkAll('{{ $menu->id }}')"
                                                class="form-check-input semua-checkbox-{{ $menu->id }} all-checked"
                                                type="checkbox" data-menu_id="{{ $menu->id }}"
                                                data-aksi="{{ $master_action[0]->id }}"
                                                {{ NavHelper::switched($groups->id, $menu->id) ? 'checked' : '' }} />
                                            <label class="form-check-label" for="semua">semua</label>
                                        </div>
                                    </td>
                                    <td>
                                        @foreach ($master_action as $item)
                                            <div class="form-check form-check-inline">
                                                <input onclick="checkManual('{{ $menu->id }}', this.checked)"
                                                    class="form-check-input checkbox-{{ $menu->id }} indiv-checked"
                                                    type="checkbox" data-menu_id="{{ $menu->id }}"
                                                    data-aksi="{{ $item->id }}"
                                                    {{ NavHelper::create_checked($groups->id, $menu->id, $item->id) ? 'checked' : NavHelper::create_checked($groups->id, $menu->id, $item->id) }} />
                                                <label class="form-check-label" for="read">{{ $item->name }}</label>
                                            </div>
                                        @endforeach
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
    <script>
        function message(title, success = 'true') {
            Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000, // Durasi 7000ms seperti Toastify
                timerProgressBar: true,
                // background: (success) ? "#61876E" : "#F55050", // Warna background sesuai kondisi
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            }).fire({
                icon: (success) ? 'success' : 'error', // Menentukan ikon berdasarkan kondisi
                text: title, // Menggunakan variabel title untuk teks
            });
        }

        function checkAll(menuName) {
            const switchBtn = document.getElementById(`allCheck-${menuName}`);
            const checkboxes = document.querySelectorAll(`.checkbox-${menuName}`);

            checkboxes.forEach(checkbox => {
                checkbox.checked = switchBtn.checked;
            });

            const menu_id = switchBtn.getAttribute('data-menu_id')
            const group_id = $("#group_id").val()
            const status = switchBtn.checked

            $.ajax({
                method: "post",
                url: "{{ route('permission.all-akses') }}",
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val(),
                },
                data: {
                    menu_id,
                    status,
                    group_id
                },
                success: async function(data) {
                    if (data.status) {
                        message(data.message, data.success);
                    }
                }
            })
        }

        // Fungsi untuk memeriksa apakah semua checkbox dalam suatu kelompok aktif atau tidak
        function checkManual(menuName) {
            const checkboxes = document.querySelectorAll(`.checkbox-${menuName}`);
            const switchBtn = document.getElementById(`allCheck-${menuName}`);

            const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

            switchBtn.checked = allChecked;
        }

        $(".indiv-checked").on('click', function() {
            let data = $(this).data();
            const menu_id = data.menu_id;
            const aksi = data.aksi;
            const group_id = $("#group_id").val();

            $.ajax({
                method: "post",
                url: "{{ route('permission.edit-akses') }}",
                headers: {
                    "X-CSRF-TOKEN": $('input[name="_token"]').val(),
                },
                data: {
                    menu_id,
                    aksi,
                    group_id
                },
                success: async function(data) {
                    if (data.status) {
                        message(data.message, data.success);
                    }
                }
            });
        });
    </script>
@endpush
