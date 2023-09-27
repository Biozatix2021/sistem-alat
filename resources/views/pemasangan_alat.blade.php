@extends('layouts.main')

@section('content')
    <form id="form-pemasangan-alat">
        @csrf
        <div class="card mt-3">
            <div class="card-body">
                <h4 class="header-title"><u>General</u></h4>

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
                        <select class="selectpicker form-control border" data-live-search="true" name="rs_id" id="rs_id">
                            <option value="">Silahkan pilih kota terlebih dahulu</option>
                        </select>
                    </div>
                    <div class="col-lg-6 col-ml-6 col-sm-12 mb-3">
                        <label for="nama_alat">Nama Teknisi Lab<span class="text-danger">*</span></label> <br>
                        <input type="text" class="form-control" name="nama_teknisi_lab" id="nama_teknisi_lab" placeholder="Masukan nama teknisi.">
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <h4 class="header-title"><u>Alat</u></h4>
                <div class="row">
                    <div class="col-lg-6 col-ml-6 col-sm-12 mb-3">
                        <label for="nama_alat">Pilih alat<span class="text-danger">*</span></label> <br>
                        <select class="selectpicker form-control border" data-live-search="true" name="alat_id" id="alat_id">
                            <option value="">-- Pilih Alat --</option>
                            @foreach ($alats as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_alat }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-lg-6 col-ml-6 col-sm-12 mb-3">
                        <label for="nama_alat">SN Alat<span class="text-danger">*</span></label> <br>
                        <input type="text" class="form-control" name="sn_alat" id="sn_alat" placeholder="Masukan nomor seri alat.">
                    </div>
                    <div class="col-lg-6 col-ml-6 col-sm-12 mb-3">
                        <label for="nama_alat">Tanggal Pemasangan<span class="text-danger">*</span></label> <br>
                        <input type="date" class="form-control" name="tgl_pemasangan" id="tgl_pemasangan">
                    </div>
                    <div class="col-lg-6 col-ml-6 col-sm-12 mb-3">
                        <label for="nama_alat">Status Pemasangan<span class="text-danger">*</span></label> <br>
                        <select class="selectpicker form-control border" name="status_pemasangan" id="status_pemasangan">
                            <option value="">-- Pilih Status Pemasangan --</option>
                            <option value="KSO">KSO</option>
                            <option value="BELI">BELI</option>
                        </select>
                    </div>
                    <div class="col-lg-6 col-ml-6 col-sm-12 mb-3">
                        <label for="nama_alat">Tanggal Pengiriman Alat<span class="text-danger">*</span></label> <br>
                        <input type="date" class="form-control" name="tgl_pengiriman_alat" id="tgl_pengiriman_alat">
                    </div>
                    <div class="col-lg-6 col-ml-6 col-sm-12 mb-3">
                        <label for="nama_alat">Tanggal Alat Sampai Rumah Sakit<span class="text-danger">*</span></label> <br>
                        <input type="date" class="form-control" name="tgl_sampai_rs" id="tgl_sampai_rs">
                    </div>
                </div>
            </div>
        </div>
        <div class="card mt-3">
            <div class="card-body">
                <h4 class="header-title"><u>Garansi</u></h4>
                <div class="row">
                    <div class="col-lg-6 col-ml-6 col-sm-12 mb-3">
                        <label for="nama_alat">Type Garansi<span class="text-danger">*</span></label> <br>
                        <select class="selectpicker form-control border" name="garansi_id" id="garansi_id">
                            <option value="">-- Pilih Tipe Garansi --</option>
                            @foreach ($garansi as $item)
                                <option value="{{ $item->id }}">{{ $item->nama }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-6 col-ml-6 col-sm-12">
                        <label for="nama_alat">Tgl Mulai Berlaku Garansi<span class="text-danger">*</span></label> <br>
                        <input type="date" class="form-control" name="tgl_mulai_garansi" id="tgl_mulai_garansi">
                    </div>
                    <div class="col-lg-6 col-ml-6 col-sm-12">
                        <label for="nama_alat">Tgl Akhir Garansi<span class="text-danger">*</span></label> <br>
                        <input type="date" class="form-control" name="tgl_akhir_garansi" id="tgl_akhir_garansi">
                    </div>
                    <div class="col-lg-8 col-ml-8 col-sm-12">
                    </div>
                    <div class="col-lg-4 col-ml-4 col-sm-12 mb-5 mt-5 text-right">
                        <button type="button" onclick="save_data()" id="tombol-tambah-form" class="btn btn-primary btn-sm"><i class="fas fa-paper-plane"></i>
                            Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
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
                    $('#rs_id').html(html);
                    // append data to selectpicker 
                    $('#rs_id').selectpicker('refresh');


                }
            });
        }

        function save_data() {
            var form = $('#form-pemasangan-alat').serialize();
            $.ajax({
                url: "{{ route('pemasangan-alat.store') }}",
                type: "POST",
                data: form,
                success: function(data) {
                    console.log(data);
                    if (data.status) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Data berhasil disimpan!',
                            timer: 2000
                        }).then(function() {
                            window.location.href = "{{ route('pemasangan-alat.index') }}";
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Terjadi kesalahan!',
                        });
                    }
                },
                error: function(xhr) {
                    toastr.error(xhr.responseJSON.text, 'Gagal!')
                }
            });
        }
    </script>
@endsection
