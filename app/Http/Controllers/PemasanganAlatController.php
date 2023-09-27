<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\Alat_terpasang;
use App\Models\Garansi;
use App\Models\Kota;
use App\Models\RumahSakit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PemasanganAlatController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $alats = Alat::all();
        $kota = Kota::all();
        $garansi = Garansi::all();
        return view('pemasangan_alat', [
            'alats' => $alats,
            'kota' => $kota,
            'garansi' => $garansi,
        ]);
    }

    public function get_rs(Request $request)
    {
        $data = RumahSakit::where('kabupaten_kota', $request->kota)->get();
        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // return $request->all();
        $rules = [
            'rs_id'                 => 'required',
            'nama_teknisi_lab'      => 'required',
            'alat_id'               => 'required',
            'sn_alat'               => 'required',
            'tgl_pemasangan'        => 'required',
            'status_pemasangan'     => 'required',
            'tgl_pengiriman_alat'   => 'required',
            'tgl_sampai_rs'         => 'required',
            'garansi_id'            => 'required',
            'tgl_mulai_garansi'     => 'required',
            'tgl_akhir_garansi'     => 'required'
        ];

        $messages = [
            'rs_id'                 => 'Anda belum memilih rumah sakit.',
            'nama_teknisi_lab'      => 'Silahkan isi nama teknisi lab.',
            'alat_id'               => 'Anda belum memilih alat',
            'sn_alat'               => 'Nomor seri alat tidak boleh kosong.',
            'tgl_pemasangan'        => 'Silahkan isi tanggal pemasangan.',
            'status_pemasangan'     => 'Anda belum memilih status pemasangan.',
            'tgl_pengiriman_alat'   => 'Silahkan isi tanggal pengiriman.',
            'tgl_sampai_rs'         => 'Silahkan isi tanggal diterima.',
            'garansi_id'            => 'Anda belum memilih garansi.',
            'tgl_mulai_garansi'     => 'Silahkan isi tanggal mulai garansi.',
            'tgl_akhir_garansi'     => 'Silahkan isi tanggal akhir garansi.'
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json(['success' => 0, 'text' => $validator->errors()->first()], 422);
        }

        Alat_terpasang::Create([
            'rs_id'                    => $request->rs_id,
            'nama_teknisi_lab'         => $request->nama_teknisi_lab,
            'alat_id'                  => $request->alat_id,
            'nomor_seri'               => $request->sn_alat,
            'tanggal_pemasangan'       => $request->tgl_pemasangan,
            'status_pemasangan'        => $request->status_pemasangan,
            'tanggal_pengiriman'       => $request->tgl_pengiriman_alat,
            'tanggal_diterima'         => $request->tgl_sampai_rs,
            'garansi_id'               => $request->garansi_id,
            'tanggal_mulai_garansi'    => $request->tgl_mulai_garansi,
            'tanggal_selesai_garansi'  => $request->tgl_akhir_garansi,
        ]);

        return response()->json(['status' => true]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
