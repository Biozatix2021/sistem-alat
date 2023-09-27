@extends('layouts.main')

@section('content')
    <div class="card mt-3">
        <div class="card-body">
            <div class="data-tables">
                <table id="Rstable" class="ui celled table responsive nowrap unstackable" width="100%">
                    <thead class="bg-light text-capitalize">
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Kabupaten/Kota</th>
                            <th width="10px">Aksi</th>
                        </tr>
                    </thead>
                </table>
            </div>

        </div>
    </div>
    {{-- make modal --}}
    <div class="modal fade" id="tambaheditmodal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal-judul"></h5>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <form id="form-rs" name="form-rs" class="form-horizontal">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 col-ml-6 col-sm-12">
                                <input type="hidden" name="id" id="id">
                                <div class="form-group">
                                    <label for="nama_rs">Nama Rumah Sakit<span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" aria-describedby="nama_rs" id="nama_rs" name="nama_rs" placeholder="Masukan nama customer.">
                                </div>
                            </div>
                            <div class="col-lg-6 col-ml-6 col-sm-12">
                                <div class="form-group">
                                    <label for="kab_kota">Kab/Kota<span class="text-danger">*</span></label>
                                    <select class=" form-control selectpicker" id="kab_kota" name="kab_kota" data-live-search="true" data-size="1" data-container="body">
                                        <option value="">-- Pilih Kab/Kota --</option>
                                        @foreach ($kota as $item)
                                            <option value="{{ $item->name }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="latitude" class="form-label">Latitude</label>
                                <input type="text" class="form-control" id="latitude" name="latitude">
                            </div>
                            <div class="col-md-6">
                                <label for="Longitude" class="form-label">Longitude</label>
                                <input type="text" class="form-control" id="longitude" name="longitude">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-12">
                                <hr>
                                <div class="maps" id="maps" style="height: 300px">

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

            $('#tambaheditmodal').on('shown.bs.modal', function() {
                leafletMap.invalidateSize();
            });
        });

        const providerOSM = new GeoSearch.OpenStreetMapProvider();
        //leaflet map
        var leafletMap = L.map('maps', {
            fullscreenControl: true,
            // OR
            fullscreenControl: {
                pseudoFullscreen: false // if true, fullscreen to page width and height
            },
            minZoom: 5
        }).setView([-3, 120], 5);

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://osm.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(leafletMap);

        let theMarker = {};

        leafletMap.on('click', function(e) {
            let latitude = e.latlng.lat.toString().substring(0, 15);
            let longitude = e.latlng.lng.toString().substring(0, 15);
            $('#latitude').val(e.latlng.lat);
            $('#longitude').val(e.latlng.lng);
            draggable: true;
            if (theMarker != undefined) {
                leafletMap.removeLayer(theMarker);
            };
            theMarker = L.marker([latitude, longitude]).addTo(leafletMap);

        });

        const search = new GeoSearch.GeoSearchControl({
            provider: providerOSM,
            style: 'bar',
            searchLabel: 'Cari lokasi...',
        });
        leafletMap.addControl(search);

        leafletMap.on('geosearch/showlocation', function(result) {
            console.log(result);
            $('#latitude').val(result.location.y);
            $('#longitude').val(result.location.x);
        });




        $('#Rstable').DataTable({
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
            ajax: "{{ route('rumahsakit.index') }}",
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                },
                {
                    data: 'nama_rs',
                    name: 'nama_rs'
                },
                {
                    data: 'kabupaten_kota',
                    name: 'kabupaten_kota'
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
            $('#modal-judul').html('Tambah Data Rumah Sakit');
            $('#form-rs').trigger('reset');
        }

        function edit_data(id) {
            $('#tambaheditmodal').modal('show');
            $('#modal-judul').html('Edit Data Rumah Sakit');
            $('#form-rs').trigger('reset');
            $.ajax({
                url: "{{ url('rumahsakit') }}" + "/" + id + "/edit",
                type: "GET",
                dataType: "JSON",
                success: function(data) {
                    $('#id').val(data.id);
                    $('#nama_rs').val(data.nama_rs);
                    $('#kab_kota').val(data.kab_kota);
                    $('#latitude').val(data.latitude);
                    $('#longitude').val(data.longitude);

                    leafletMap.setView([data.latitude, data.longitude], 17);
                    let theMarker = {};
                    if (theMarker != undefined) {
                        leafletMap.removeLayer(theMarker);
                    };
                    theMarker = L.marker([data.latitude, data.longitude]).addTo(leafletMap);

                    // remove marker on click map and set new marker
                    leafletMap.on('click', function(e) {
                        let latitude = e.latlng.lat.toString().substring(0, 15);
                        let longitude = e.latlng.lng.toString().substring(0, 15);
                        $('#latitude').val(e.latlng.lat);
                        $('#longitude').val(e.latlng.lng);
                        draggable: true;

                        if (theMarker != undefined) {
                            leafletMap.removeLayer(theMarker);
                        };
                        theMarker = L.marker([latitude, longitude]).addTo(leafletMap);
                    });

                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Terjadi kesalahan!'
                    })
                }
            });
        }

        function save_data() {
            $.ajax({
                url: "{{ route('rumahsakit.store') }}",
                type: "POST",
                data: $('#form-rs').serialize(),
                dataType: 'json',
                success: function(data) {
                    $('#tambaheditmodal').modal('hide');
                    $('#Rstable').DataTable().ajax.reload();
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Data berhasil ditambahkan!'
                    })
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

        function delete_data(id) {
            Swal.fire({
                title: 'Apakah anda yakin?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Tidak, Batalkan!',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: "{{ url('rumahsakit') }}" + "/" + id,
                        type: "DELETE",
                        dataType: "JSON",
                        success: function(data) {
                            $('#Rstable').DataTable().ajax.reload();
                            Swal.fire(
                                'Terhapus!',
                                'Data berhasil dihapus.',
                                'success'
                            )
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
                } else if (
                    result.dismiss === Swal.DismissReason.cancel
                ) {
                    Swal.fire(
                        'Dibatalkan',
                        'Data batal dihapus :)',
                        'error'
                    )
                }
            })
        }
    </script>
@endsection
