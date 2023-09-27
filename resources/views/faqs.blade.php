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
                <table id="tabelFaqs" class="ui celled table responsive nowrap unstackable" width="100%">
                    <thead class="bg-light text-capitalize">
                        <tr>
                            <th width="20px">No</th>
                            <th>Judul</th>
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
                <form action="{{ route('faqs.store') }}" method="POST" id="form-faq" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-ml-12 col-sm-12">
                                <div class="form-group">
                                    <label for="judul">Judul<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" aria-describedby="judul" id="judul" name="judul" placeholder="Masukan nama brand.">
                                </div>
                            </div>
                            <div class="col-lg-12 col-ml-12 col-sm-12">
                                <div class="form-group">
                                    <label for="nama_rs">Deskripsi<span class="text-danger">*</span></label>
                                    <textarea name="deskripsi" id="deskripsi" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-ml-12 col-sm-12">
                                <div class="form-group">
                                    <label for="nama_rs">Terbitkan<span class="text-danger">*</span></label>
                                    <select class="form-control custom-select" name="status" id="status">
                                        <option value="">Select Terbitkan</option>
                                        <option value="publish">Ya</option>
                                        <option value="draft">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="tombol-tambah-form" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i>
                            Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Modal Edit --}}
    <div class="modal fade" id="editmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-judul"></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="form-edit-faq" action="/faqs/1" class="form-horizontal" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-12 col-ml-12 col-sm-12">
                                <div class="form-group">
                                    <input type="hidden" name="id" id="id">
                                    <label for="edit_judul">Judul<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" aria-describedby="edit_judul" id="edit_judul" name="edit_judul"
                                        placeholder="Masukan nama brand.">
                                </div>
                            </div>
                            <div class="col-lg-12 col-ml-12 col-sm-12">
                                <div class="form-group">
                                    <label for="nama_rs">Deskripsi<span class="text-danger">*</span></label>
                                    <textarea name="editor" id="editor" cols="30" rows="10"></textarea>
                                </div>
                            </div>
                            <div class="col-lg-12 col-ml-12 col-sm-12">
                                <div class="form-group">
                                    <label for="nama_rs">Terbitkan<span class="text-danger">*</span></label>
                                    <select class="form-control custom-select" name="edit_status" id="edit_status">
                                        <option value="">Select Terbitkan</option>
                                        <option value="publish">Ya</option>
                                        <option value="draft">Tidak</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" id="tombol-tambah-form" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i>
                            Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    {{-- Akhir Modal Edit --}}
@endsection

@section('js')
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                }

            });
            ClassicEditor
                .create(document.querySelector('#deskripsi'), {
                    ckfinder: {
                        uploadUrl: '{{ route('ckeditor.upload') }}' + '?_token={{ csrf_token() }}'
                    }
                })
                .catch(error => {
                    console.error(error);
                });
        });


        $('#tabelFaqs').DataTable({
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
            ajax: "{{ route('faqs.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex'
                },
                {
                    data: 'judul',
                    name: 'judul'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                },
            ]
        });


        function tambahData() {
            $('#tambaheditmodal').modal('show');
            $('#modal-judul').html('Tambah Faqs');
        }

        function edit_data(id) {
            $('#editmodal').modal('show');
            $('#modal-judul').html('Edit Faqs');
            // reset form ke semula
            $('#form-edit-faq').trigger('reset');
            $.ajax({
                url: "/faqs/" + id + "/edit",
                type: "GET",
                dataType: "json",
                success: function(data) {
                    console.log(data);
                    $('#id').val(data.id);
                    $('#edit_judul').val(data.judul);
                    $('#edit_status').val(data.status);
                    ClassicEditor.create(document.querySelector('#editor'), {
                        ckfinder: {
                            uploadUrl: '{{ route('ckeditor.upload') }}' + '?_token={{ csrf_token() }}'
                        }
                    }).then(editor => {
                        editor.setData(data.isi);
                        editor.replaceAll(data.isi);
                    });
                    $('#tombol-tambah-form').hide();
                    $('#tombol-ubah-form').show();
                }
            })
        }

        function delete_data(id) {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
            })
            swalWithBootstrapButtons.fire({
                title: 'Konfirmasi !',
                text: "Anda Akan Menghapus Data ?",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus !',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.value) {
                    $.ajax({
                        url: "/faqs/" + id,
                        type: "DELETE",
                        dataType: "JSON",
                        data: {

                            '_token': '{{ csrf_token() }}'
                        },
                    })
                    Swal.fire({
                        position: 'center',
                        icon: 'success',
                        title: 'Produk berhasil dihapus.',
                        showConfirmButton: false,
                        timer: 2000
                    })
                    // $('#tabelFaqs').DataTable().ajax.reload();
                } else if (result.dismiss === Swal.DismissReason.cancel) {
                    swalWithBootstrapButtons.fire(
                        'Batal',
                        'Data tidak dihapus',
                        'error'
                    )
                }
            })
        }
    </script>
@endsection
