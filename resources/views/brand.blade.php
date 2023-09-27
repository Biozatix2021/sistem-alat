@extends('layouts.main')

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="data-tables">
                <table id="tabelBrand" class="ui celled table responsive nowrap unstackable" width="100%">
                    <thead class="bg-light text-capitalize">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="tambahmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-judul"></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form-brand" name="form-brand" class="form-horizontal">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 col-ml-12 col-sm-12">
                                <div class="form-group">
                                    <label for="nama_rs">Nama Brand<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" aria-describedby="nama_rs" id="nama_brand" name="nama_brand" placeholder="Masukan nama brand.">
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" id="tombol-tambah-form" class="btn btn-primary btn-sm" onclick="save_data()"><i class="fas fa-paper-plane"></i>
                        Simpan</button>
                </div>
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

        $('#tabelBrand').DataTable({
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
            ajax: "{{ route('brand.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
            ]
        });

        function tambahData() {
            $('#tambahmodal').modal('show');
            $('#modal-judul').html('Tambah Brand');
            $('#form-brand')[0].reset();
        }

        function save_data() {
            $.ajax({
                url: "{{ route('brand.store') }}",
                type: "POST",
                data: $('#form-brand').serialize(),
                dataType: 'json',
                success: function(data) {
                    $('#tambahmodal').modal('hide');
                    $('#tabelBrand').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data berhasil ditambahkan!'
                    })
                    // modal hide
                },
                error: function(data) {
                    console.log(data);
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan!'
                    })
                }
            });
        }
    </script>
@endsection
