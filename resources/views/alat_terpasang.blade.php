@extends('layouts.main')

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="data-tables">
                <table id="tabelAlat" class="ui celled table responsive nowrap unstackable" width="100%">
                    <thead class="bg-light text-capitalize">
                        <tr>
                            <th>No</th>
                            <th>Nama Alat</th>
                            <th>Nomor Seri</th>
                            <th>Tanggal <br> Pemasangan</th>
                            <th>Status <br> Pemasangan</th>
                            <th>Type <br> Garansi</th>
                            <th>Rumah <br> Sakit</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
    <div class="modal fade" id="filtermodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-judul"></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form-filter" class="form-horizontal">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-ml-6 col-sm-12">
                                <div class="form-group">
                                    <label for="nama_alat">Kota<span class="text-danger">*</span></label>
                                    <select class="selectpicker form-control border btn-light" data-style="btn-light" data-live-search="true" data-size="5" name="kota"
                                        id="kota" onchange="get_rs()">
                                        <option value="">Pilih Kota</option>
                                        @foreach ($kota as $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-lg-6 col-ml-6 col-sm-12">
                                <label for="nama_alat">Rumah Sakit<span class="text-danger">*</span></label> <br>
                                <select class="selectpicker form-control border" data-live-search="true" name="filter_rs" id="filter_rs">
                                    <option value="">Silahkan pilih kota terlebih dahulu</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-outline-secondary btn-xs" data-dismiss="modal">Close</button>
                    <button type="button" id="tombol-tambah-form" class="btn btn-outline-primary btn-xs"><i class="fas fa-search" onclick="add_filter()"></i> Cari</button>
                </div>
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
                        <div class="col-lg-4 col-ml-4 col-sm-12">
                            <img src="" id="foto" class="img-fluid" alt="" style="height: 200px">
                        </div>
                        <div class="col-lg-8 col-ml-8 col-sm-12">
                            <table class="table table-borderless">
                                <tbody>
                                    <tr class="m-0">
                                        <td class="m-0 p-1">Rumah Sakit</td>
                                        <td class="m-0 p-1">:</td>
                                        <td class="m-0 p-1" id="rumah_sakit"></td>
                                    </tr>
                                    <tr class="m-0">
                                        <td class="m-0 p-1">Nama Alat</td>
                                        <td class="m-0 p-1">:</td>
                                        <td class="m-0 p-1" id="nama_alat"></td>
                                    </tr>
                                    <tr class="m-0">
                                        <td class="m-0 p-1">Kategori Alat</td>
                                        <td class="m-0 p-1">:</td>
                                        <td class="m-0 p-1" id="kategori_alat"></td>
                                    </tr>
                                    <tr class="m-0">
                                        <td class="m-0 p-1">Nomor Seri</td>
                                        <td class="m-0 p-1">:</td>
                                        <td class="m-0 p-1" id="nomor_seri"></td>
                                    </tr>
                                    <tr class="m-0">
                                        <td class="m-0 p-1">Status Pemasangan</td>
                                        <td class="m-0 p-1">:</td>
                                        <td class="m-0 p-1" id="status_pemasangan"></td>
                                    </tr>
                                    <tr class="m-0">
                                        <td class="m-0 p-1">Tanggal Pemasangan</td>
                                        <td class="m-0 p-1">:</td>
                                        <td class="m-0 p-1" id="tanggal_pemasangan"></td>
                                    </tr>
                                    <tr class="m-0">
                                        <td class="m-0 p-1">Tanggal Pengiriman Alat</td>
                                        <td class="m-0 p-1">:</td>
                                        <td class="m-0 p-1" id="tanggal_pengiriman"></td>
                                    </tr>
                                    <tr class="m-0">
                                        <td class="m-0 p-1">Tanggal Diterima Rumah Sakit</td>
                                        <td class="m-0 p-1">:</td>
                                        <td class="m-0 p-1" id="tanggal_diterima"></td>
                                    </tr>
                                    <tr class="m-0">
                                        <td class="m-0 p-1">Teknisi Lab</td>
                                        <td class="m-0 p-1">:</td>
                                        <td class="m-0 p-1" id="teknisi_lab"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-lg-12 col-ml-12 col-sm-12">
                            <nav>
                                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                                    <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab"
                                        aria-controls="nav-home" aria-selected="true">Garansi</button>
                                    <button class="nav-link" id="nav-home-tab" data-toggle="tab" data-target="#nav-lokasi" type="button" role="tab"
                                        aria-controls="nav-home" aria-selected="true">Lokasi</button>

                                </div>
                            </nav>
                            <div class="tab-content" id="nav-tabContent">
                                <div class="tab-pane fade show active mt-3" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                                    <table class="table table-borderless">
                                        <tbody>
                                            <tr class="m-0">
                                                <td class="m-0 p-1" style="width: 150px">Garansi</td>
                                                <td class="m-0 p-1">:</td>
                                                <td class="m-0 p-1" id="type_garansi"></td>
                                            </tr>
                                            <tr class="m-0">
                                                <td class="m-0 p-1" style="width: 150px">Periode Garansi</td>
                                                <td class="m-0 p-1">:</td>
                                                <td class="m-0 p-1" id="periode_garansi"></td>
                                            </tr>
                                            <tr class="m-0">
                                                <td class="m-0 p-1" style="width: 150px">Garansi Aktif</td>
                                                <td class="m-0 p-1">:</td>
                                                <td class="m-0 p-1" id="garansi_aktif"></td>
                                            </tr>
                                            <tr class="m-0">
                                                <td class="m-0 p-1" style="width: 150px">Keterangan</td>
                                                <td class="m-0 p-1">:</td>
                                                <td class="m-0 p-1" id="keterangan"></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="tab-pane fade show mt-3" id="nav-lokasi" role="tabpanel" aria-labelledby="nav-home-tab">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
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
        });

        function filterData() {
            $('#filtermodal').modal('show');
            $('#modal-judul').html('Filter Data Alat');
            $('#form-alat').trigger('reset');
        }

        function add_filter() {
            var filter = $("#filter_rs").val();
            table.draw();
        }

        table = $('#tabelAlat').DataTable({
            processing: true,
            serverSide: true,
            responsive: true,
            columnDefs: [{
                className: "text-center",
                targets: [0, 2, 3, 4, 5, 7]
            }],
            dom: 'Bfrtip',
            // button tambah data
            buttons: [{
                text: '<i class="fas fa-plus"></i>Tambah Data',
                action: function(e, dt, node, config) {
                    tambahData();
                }
            }, {
                text: '<i class="fas fa-filter"></i>Filter Data',
                action: function(e, dt, node, config) {
                    filterData();
                }
            }],
            ajax: {
                url: "{{ route('data-alat-terpasang.index') }}",
                type: "GET",
                data: function(data) {
                    data.filter = $('#filter_rs').val();
                },
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                },
                {
                    data: 'alat.nama_alat',
                    name: 'alat.nama_alat'
                },
                {
                    // data + span 
                    data: 'nomor_seri',
                    name: 'nomor_seri'
                },
                {
                    data: 'tanggal_pemasangan',
                    name: 'tanggal_pemasangan'
                },
                {
                    data: 'status_pemasangan',
                    name: 'status_pemasangan'
                },
                {
                    data: 'garansi.nama',
                    name: 'garansi.nama'
                },
                {
                    data: 'rumah_sakit.nama_rs',
                    name: 'rumah_sakit.nama_rs'
                },
                {
                    data: 'action',
                    name: 'action',
                    orderable: false,
                    searchable: false
                }
            ]
        });

        function get_rs() {
            var kota = $('#kota').val();
            // console.log(kota);
            $.ajax({
                url: "{{ route('get_rs') }}",
                type: "POST",
                data: {
                    kota: kota,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log(data);

                    // looping show data in filter_rumah_sakit
                    var html = '';
                    html += '<option value="" disabled selected>Pilih Rumah Sakit</option>';
                    for (var i = 0; i < data.length; i++) {
                        html += '<option value="' + data[i].id + '">' + data[i].nama_rs + '</option>';
                    }
                    $('#filter_rs').html(html);
                    // append data to selectpicker 
                    $('#filter_rs').selectpicker('refresh');


                }
            });
        }

        function detail_data(id) {
            $('#modaldetail').modal('show');
            $('#modal-judul').html("Detail Data Alat Terpasang");
            $.ajax({
                url: "{{ url('data-alat-terpasang') }}" + '/' + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    console.log(data);
                    $('#modaldetail').modal('show');
                    $('#rumah_sakit').html(data.rumah_sakit.nama_rs);
                    $('#nama_alat').html(data.alat.nama_alat);
                    $('#kategori_alat').html(data.alat.kategori);
                    $('#nomor_seri').html(data.nomor_seri);
                    $('#status_pemasangan').html('<span class="badge badge-success">' + data.status_pemasangan + '</span>');
                    $('#tanggal_pemasangan').html(moment(data.tanggal_pemasangan).format('DD MMMM YYYY'));
                    $('#tanggal_pengiriman').html(moment(data.tanggal_pengiriman).format('DD MMMM YYYY'));
                    $('#tanggal_diterima').html(moment(data.tanggal_diterima).format('DD MMMM YYYY'));
                    $('#foto').attr('src', "{{ asset('product/images') }}/" + data.alat.foto);
                    $('#type_garansi').html(data.garansi.nama);
                    $('#periode_garansi').html('<span class="badge badge-success">' + data.garansi.periode_garansi + ' Tahun</span>');
                    $('#keterangan').html(data.garansi.keterangan);
                    var tgl_mulai = moment(data.tanggal_mulai_garansi).format('DD MMMM YYYY');
                    var tgl_selesai = moment(data.tanggal_selesai_garansi).format('DD MMMM YYYY');
                    $('#garansi_aktif').html(tgl_mulai + ' - ' + tgl_selesai);
                    $('#teknisi_lab').html('<p><strong>' + data.nama_teknisi_lab + '</strong></p>');
                },
                error: function() {
                    alert("Tidak ada data");
                }
            });
        }
    </script>
@endsection
