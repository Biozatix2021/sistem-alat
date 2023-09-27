@extends('layouts.main')

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            @if (session('status'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <strong>Sukses!</strong> {{ session('status') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true" class="fas fa-times"></span>
                    </button>
                </div>
            @endif
            <div class="data-tables">
                <table id="tabelGaransi" class="ui celled table responsive nowrap unstackable" width="100%">
                    <thead class="bg-light text-capitalize">
                        <tr>
                            <th>No</th>
                            <th>Judul Garansi</th>
                            <th>Periode</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="modaltambahdata" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-judul"></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="form-pemasangan-alat" name="form-pemasangan-alat" action="{{ route('garansi.store') }}" method="POST" class="form-horizontal">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-ml-6 col-sm-12">
                                <div class="form-group">
                                    <label for="judul_garansi">Judul Garansi<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" aria-describedby="judul_garansi" id="judul_garansi" name="judul_garansi"
                                        placeholder="Masukan nama brand.">
                                </div>
                            </div>
                            <div class="col-lg-6 col-ml-6 col-sm-12">
                                <div class="form-group">
                                    <label for="periode_garansi">Periode Garansi<span class="text-danger">*</span></label>
                                    <input type="number" class="form-control" aria-describedby="periode_garansi" id="periode_garansi" name="periode_garansi"
                                        placeholder="Masukan nama brand.">
                                    <span class="text-danger">Dalam tahun</span>
                                </div>
                            </div>
                            <div class="col-lg-12 col-ml-12 col-sm-12">
                                <div class="form-group">
                                    <label for="periode_garansi">Periode Garansi<span class="text-danger">*</span></label>
                                    <textarea name="deskripsi" id="deskripsi" cols="30"></textarea>
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
    <div class="modal fade" id="modaldetail" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-judul"></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-lg-12 col-ml-12 col-sm-12">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr class="m-0 p-0">
                                        <td class="p-0" style="width: 140px">Nama Garansi</td>
                                        <td class="p-0">:</td>
                                        <td class="p-0" id="nama_garansi"></td>
                                    </tr>
                                    <tr class="m-0 p-0">
                                        <td class="p-0" style="width: 140px">Periode Garansi</td>
                                        <td class="p-0">:</td>
                                        <td class="p-0" id="periodeGaransi"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 col-ml-12 col-sm-12">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab"
                                        aria-controls="nav-home" aria-selected="true">Description</button>
                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active mt-3" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <p id="description"></p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="tombol-tambah-form" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i>
                        Simpan</button>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('js')
    <script>
        var table;
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            ClassicEditor
                .create(document.querySelector('#deskripsi'), {
                    // height
                    minHeight: '500px'
                })
                .then(editor => {})
                .catch(error => {
                    console.error(error);
                });
        });

        // ckeditor

        table = $('#tabelGaransi').DataTable({
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
            ajax: "{{ route('garansi.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                },
                {
                    data: 'nama',
                    name: 'nama'
                },
                {
                    // data + span 
                    data: 'periode_garansi',
                    name: 'periode_garansi'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        function tambahData() {
            $('#modaltambahdata').modal('show');
            $('#modal-judul').html('Tambah Garansi');
            // $('#form-garansi')[0].reset();
        }

        function detail_data(id) {
            // modal show
            $.ajax({
                url: "/garansi/" + id + "/edit",
                method: "GET",
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    $('#modaldetail').modal('show');
                    $('#modal-judul').html('Detail Garansi');
                    $('#nama_garansi').html(data.nama);
                    $('#periodeGaransi').html(data.periode_garansi);
                    $('#description').html(data.keterangan);
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    </script>
@endsection
