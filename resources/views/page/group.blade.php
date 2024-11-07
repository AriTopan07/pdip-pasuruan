@extends('layouts.master')

@section('content')
    <div class="page-heading">
        <h3>Group</h3>
    </div>
    <div class="page-content">
        <section class="section">
            <div class="card">
                <div class="card-header">
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="table1">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Nama Grup</th>
                                <th>Deskripsi</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $item->name }}</td>
                                    <td>{{ $item->description }}</td>
                                    <td>
                                        <form onsubmit="return confirm(Hapus Data?)" class='d-inline'
                                            action=" {{ url('/adjusment/delete/' . $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" name="submit"
                                                class="btn btn-danger btn-sm">Delete</button>
                                        </form>
                                        {!! NavHelper::action('tabel', $item->id) !!}
                                        {{-- <button type="button" class="btn btn-warning btn-sm" onclick="edit({{ $item->id }})">Edit</button> --}}
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

{{-- Modal Add --}}
<div class="modal fade text-left" id="modal-add" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel34">Tambah Data </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label>Name</label>
                    <div class="form-group">
                        <input type="text" placeholder="Nama" class="form-control" name="name" id="name"
                            required value="{{ old('name') }}" required>
                    </div>
                    <label>Description</label>
                    <div class="form-group">
                        <input type="text" placeholder="Deskripsi" class="form-control" name="description"
                            id="description" required value="{{ old('description') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1 btn-update">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- Modal Edit --}}
<div class="modal fade text-left" id="modal-edit" role="dialog" aria-labelledby="myModalLabel34" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="myModalLabel34">Edit Data </h4>
                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                    <i data-feather="x"></i>
                </button>
            </div>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <label>Name</label>
                    <div class="form-group">
                        <input type="text" placeholder="Nama" class="form-control" name="name-edit" id="name-edit"
                            required value="{{ old('name') }}" required>
                    </div>
                    <label>Description</label>
                    <div class="form-group">
                        <input type="text" placeholder="Deskripsi" class="form-control" name="description-edit"
                            id="description-edit" required value="{{ old('description') }}" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Tutup</span>
                    </button>
                    <button type="button" class="btn btn-primary ml-1 btn-update">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('js')
    <script>
        const edit = async (id) => {
            $('#modal-edit').modal('show');

            const response = await fetch(`/group/detail/${id}`)
            const data = await response.json()

            const token = $('input[name="_token"]');
            const name = $('input[name="name-edit"]');
            const description = $('input[name="description-edit"]');

            if (response.ok) {
                name.val(data.payload.name)
                description.val(data.payload.description)
            }

            $('.btn-update').click(e => {
                e.preventDefault()

                const formData = new FormData();
                formData.append('_token', token.val())
                formData.append('name', name.val())
                formData.append('description', description.val())

                $.ajax({
                    type: 'POST',
                    url: "{{ url('group/update') }}/" + id,
                    headers: {
                        'X-CSRF-TOKEN': token
                    },
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    beforeSend: function() {
                        $('.btn-update').prop('disabled', true);
                        $('.btn-update').html('');
                        $('.btn-update').append(
                            '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span>Loading...'
                        )
                    },
                    success: async function(data) {
                        if (data.success) {
                            window.location.reload();
                        }
                    },
                    complete: function() {
                        $('.btn-update').prop('disabled', false);
                        $('.btn-update').html('');
                        $('.btn-update').append('Simpan');
                        $("input[name=color]").val("");
                    },
                    error: function(params) {
                        let txt = params.responseJSON;
                        $.each(txt.errors, function(k, v) {
                            message(v, false);
                        });
                    }
                });
            })
        }
    </script>
@endpush
