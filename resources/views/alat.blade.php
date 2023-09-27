@extends('layouts.main')

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="data-tables">
                <table id="tabelAlat" class="ui celled table responsive nowrap unstackable" width="100%">
                    <thead class="bg-light text-capitalize">
                        <tr>
                            <th width="10px">No</th>
                            <th>Nama</th>
                            <th>Brand</th>
                            <th>Kategori</th>
                            <th width="10px">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

    <div class="modal fade" id="tambaheditmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-judul"></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <form id="form-alat" name="form-alat" class="form-horizontal" action="{{ route('alat.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-lg-6 col-ml-6 col-sm-12">
                                <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                    <label for="nama_alat">Nama Alat<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" aria-describedby="nama_alat" id="nama_alat" name="nama_alat" placeholder="Masukan nama alat.">
                                </div>
                            </div>
                            <div class="col-lg-6 col-ml-6 col-sm-12">
                                <div class="form-group">
                                    <label for="nama_rs">Brand<span class="text-danger">*</span></label>
                                    <select class="form-control custom-select" name="brand" id="brand">
                                        <option value="">Select Brand</option>
                                        @foreach ($brands as $item)
                                            <option value="{{ $item->nama }}">{{ $item->nama }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-ml-6 col-sm-12">
                                <div class="form-group">
                                    <label for="nama_rs">Type Alat<span class="text-danger">*</span></label>
                                    <select class="form-control custom-select" name="type_alat" id="type_alat">
                                        <option value="">Select Type Alat</option>
                                        <option value="Automatic IHC">Automatic IHC</option>
                                        <option value="Printer">Printer</option>
                                        <option value="Scanner">Scanner</option>
                                        <option value="Molekular ">Molekular </option>
                                        <option value="Basic Lab">Basic Lab</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-ml-6 col-sm-12">
                                <div class="form-group">
                                    <label for="foto">Foto<span class="text-danger mb-0">*</span></label>
                                    <div class="input-group">
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="foto" name="foto" aria-describedby="inputGroupFileAddon01"
                                                accept=".jpg, .jpeg, .png, .webp">
                                            <label class="custom-file-label" for="inputGroupFile01">Choose file</label>
                                        </div>
                                    </div>
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

        $('#foto').on('change', function() {
            //get the file name
            var fileName = $(this).val().replace('C:\\fakepath\\', " ");
            //replace the "Choose a file" label
            $(this).next('.custom-file-label').html(fileName);
        })

        $('#tabelAlat').DataTable({
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
            ajax: "{{ route('alat.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                },
                {
                    data: 'nama_alat',
                    name: 'nama_alat'
                },
                {
                    data: 'brand',
                    name: 'brand'
                },
                {
                    data: 'kategori',
                    name: 'kategori'
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
            $('#tambaheditmodal').modal('show');
            $('#modal-judul').html('Tambah Data Alat');
            $('#form-rs').trigger('reset');
        }

        function save_data() {
            $.ajax({
                url: "{{ route('alat.store') }}",
                type: "POST",
                data: $('#form-alat').serialize(),
                dataType: 'json',
                success: function(data) {
                    $('#tambaheditmodal').modal('hide');
                    $('#tabelAlat').DataTable().ajax.reload();
                },
                error: function(data) {
                    console.log(data);
                }
            });
        }
    </script>
@endsection
