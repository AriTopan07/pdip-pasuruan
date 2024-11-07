@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>{{ NavHelper::name_menu(Session::get('menu_active'))->name_menu }}</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5>{{ NavHelper::name_menu(Session::get('menu_active'))->name_menu }}</h5>
                    <p>
                        Menampilkan data pertanyaan yang akan ditampilkan pada formulir halaman <b>Troubleshooting
                            Jaringan</b>
                    </p>
                    @if (NavHelper::cekAkses(Auth::user()->id, 'Questions', 'add') == true)
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal"
                            data-bs-target="#modal_add">Add New</button>
                    @endif
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-striped table-hover" id="table1">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Questions</th>
                                <th>Order</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data['question'] as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td style="width: 80%">{{ $item->question }}</td>
                                    <td>{{ $item->order }}</td>
                                    <td>
                                        @if (NavHelper::cekAkses(Auth::user()->id, 'Questions', 'edit') == true)
                                            <a onclick="editData({{ $item->id }})" class="btn btn-primary btn-sm">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                        @endif
                                        @if (NavHelper::cekAkses(Auth::user()->id, 'Questions', 'delete') == true)
                                            <a onclick="deleteData({{ $item->id }})" class="btn btn-danger btn-sm">
                                                <i class="bi bi-trash"></i>
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </div>

    <div class="modal fade text-left modal-lg" id="modal_edit" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Edit Question</h4>
                    <button type="button" class="close btn-tutup" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="" id="groupFormEdit" method="" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="id">
                        <div class="row">
                            <div class="form-group">
                                <textarea class="form-control" name="edit_question" id="edit_question" rows="5"></textarea>
                                <p class="invalid-feedback"></p>
                            </div>
                            <label>order</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="edit_order" id="edit_order">
                                <p class="invalid-feedback"></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" id="update" class="btn btn-primary">
                            Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade text-left modal-lg" id="modal_add" role="dialog" aria-labelledby="myModalLabel33"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title" id="myModalLabel33">Add New Questions</h4>
                    <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                        <i data-feather="x"></i>
                    </button>
                </div>
                <form action="" id="addQuestionForm" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <label>Question</label>
                            <div class="form-group">
                                <textarea class="form-control" name="question" id="question" rows="5"></textarea>
                                <p class="invalid-feedback"></p>
                            </div>
                            <label>order</label>
                            <div class="form-group">
                                <input type="text" class="form-control" name="order" id="order">
                                <p class="invalid-feedback"></p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                            Cancel
                        </button>
                        <button type="submit" id="simpan" class="btn btn-primary" value="Submit">
                            Submit
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('#addQuestionForm').submit(function(event) {
                event.preventDefault();
                let formData = $(this).serialize();
                let submitButton = $("button[id='simpan']");
                submitButton.prop('disabled', true);

                let spinnerHtml =
                    '<div class="spinner-border text-light spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>';
                let originalButtonHtml = submitButton.html();
                submitButton.html(spinnerHtml);

                $.ajax({
                    url: '{{ route('questions.store') }}',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function(data) {
                        // console.log(data);
                        submitButton.prop('disabled', false);
                        submitButton.html('Submit');

                        if (data['success'] === true) {
                            $('.invalid-feedback').removeClass('invalid-feedback').html('');
                            $("input[type='text'], select, input[type='number'], input[type='file'], textarea")
                                .removeClass('is-invalid');
                            window.location.reload();
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
                        console.log('terjadi kesalahan');
                        submitButton.prop('disabled', false);
                        submitButton.html(originalButtonHtml);
                    }
                });
            });
        });

        function editData(id) {
            $('#modal_edit').modal('show');

            $.ajax({
                url: 'questions/' + id,
                type: 'GET',
                success: function(response) {
                    if (response.status) {
                        $('#id').val(response.data.id);
                        $('#edit_question').val(response.data.question);
                        $('#edit_order').val(response.data.order);
                    }
                }
            });
        }

        $('#modal_edit').submit(function(event) {
            event.preventDefault();

            let csrfToken = $('meta[name="csrf-token"]').attr('content');
            let id = $('#id').val();
            let formData = {
                '_token': csrfToken,
                'id': id,
                'edit_question': $('#edit_question').val(),
                'edit_order': $('#edit_order').val(),
            };

            let submitButton = $("button[id='update']");
            submitButton.prop('disabled', true);

            let spinnerHtml =
                '<div class="spinner-border text-light spinner-border-sm" role="status"><span class="visually-hidden">Loading...</span></div>';
            let originalButtonHtml = submitButton.html();

            submitButton.prop('disabled', true);
            submitButton.html(spinnerHtml); // Menampilkan spinner

            $.ajax({
                type: 'PUT',
                url: 'questions/' + id,
                data: formData,
                dataType: 'json',
                success: function(data) {
                    submitButton.prop('disabled', false);
                    submitButton.html(originalButtonHtml);

                    if (data['success'] === true) {
                        $('.invalid-feedback').removeClass('invalid-feedback').html('');
                        $("input[type='text'], select, input[type='number'], input[type='file'], textarea")
                            .removeClass('is-invalid');
                        window.location.reload();
                    } else {
                        $('.invalid-feedback').removeClass('invalid-feedback').html('');
                        $("input[type='text'], select, input[type='number'], input[type='file'], textarea")
                            .removeClass('is-invalid');

                        $.each(data.errors, function(field, errorMessage) {
                            $("#" + field).addClass('is-invalid').siblings('p').addClass(
                                'invalid-feedback').html(errorMessage[0]);
                        });
                    }
                },
                error: function() {
                    console.log('terjadi kesalahan');
                    submitButton.prop('disabled', false);
                    submitButton.html(originalButtonHtml);
                }
            });
        });

        function deleteData(id) {
            let url = '{{ route('questions.delete', 'ID') }}';
            let newUrl = url.replace('ID', id);

            Swal.fire({
                title: 'Yakin hapus data ini?',
                text: "Anda tidak dapat mengembalikannya setelah dihapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: newUrl,
                        type: 'delete',
                        data: {},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        success: function(results) {
                            if (results.status === true) {
                                window.location.reload();
                            } else {
                                window.location.reload();
                            }
                        }
                    });
                }
            });
        }
    </script>
@endpush
