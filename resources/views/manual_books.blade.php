@extends('layouts.main')

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <strong>Success!</strong> {{ session('success') }}.
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span class="fa fa-times"></span>
                    </button>
                </div>
            @endif
            <div class="data-tables">
                <table id="tabelManualBook" class="ui celled table responsive nowrap unstackable" width="100%">
                    <thead class="bg-light text-capitalize">
                        <tr>
                            <th width="20px">No</th>
                            <th>Alat</th>
                            <th>File</th>
                            <th width="20px">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tambaheditmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-judul"></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="form-manual-book" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-ml-12 col-sm-12">
                                <div class="form-group">
                                    <label for="alat_id">Pilih ALat<span class="text-danger">*</span></label>
                                    <select class="selectpicker form-control border btn-light" data-style="btn-light" data-live-search="true" data-size="5" name="alat_id"
                                        id="alat_id">
                                        <option value="">Pilih Alat</option>
                                        @foreach ($alats as $item)
                                            <option value="{{ $item->id }}">{{ $item->nama_alat }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-12 col-ml-12 col-sm-12">
                                <label for="input-group-prepend" class="form-label">Pilih File</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend" id="input-group-prepend">
                                        <span class="input-group-text" id="inputGroupFileAddon01">Upload</span>
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="file" name="nama_file" aria-describedby="inputGroupFileAddon01"
                                            accept=".pdf">
                                        <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" id="tombol-tambah-form" class="btn btn-primary btn-sm" onclick="save_data()"><i class="fas fa-paper-plane"></i>
                            Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
        });

        $('#file').on('change', function() {
            //get the file name
            var fileName = $(this).val().replace('C:\\fakepath\\', " ");
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })

        $('#tabelManualBook').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            dom: 'Bfrtip',
            // button tambah data
            buttons: [{
                text: '<i class="fas fa-plus"></i>Tambah Data',
                action: function(e, dt, node, config) {
                    tambahData();
                }
            }],
            ajax: "{{ route('manual-book.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
                {
                    data: 'alat.nama_alat',
                    name: 'alat'
                },
                {
                    data: 'nama_file',
                    name: 'nama_file'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false,
                    className: 'text-center'
                },
            ]
        });

        function tambahData() {
            $('#tambaheditmodal').modal('show');
            $('#modal-judul').html('Tambah Faqs');
        }

        function save_data() {
            var formData = new FormData($('#form-manual-book')[0]);
            $.ajax({
                url: "{{ route('manual-book.store') }}",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: 'json',
                success: function(data) {
                    if (data.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil disimpan!',
                            timer: 2000
                        });
                        $('#tabelManualBook').DataTable().ajax.reload();
                        $('#tambaheditmodal').modal('hide');
                    } else {
                        console.log(data);
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan!',
                        });
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }

        function delete_data(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',

                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('manual-book') }}" + '/' + id,
                        type: "POST",
                        data: {
                            '_method': 'DELETE',
                            '_token': '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            if (data.success) {
                                Swal.fire({
                                    icon: 'success',
                                    title: 'Berhasil',
                                    text: 'Data berhasil dihapus!',
                                    timer: 2000
                                });
                                $('#tabelManualBook').DataTable().ajax.reload();
                            } else {
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Oops...',
                                    text: 'Terjadi kesalahan!',
                                });
                            }
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                }
            })
        }
    </script>
@endsection
