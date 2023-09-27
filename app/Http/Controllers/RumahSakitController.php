<?php

namespace App\Http\Controllers;

use App\Models\Kota;
use App\Models\RumahSakit;
use Illuminate\Http\Request;

class RumahSakitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $kota = Kota::all();
        if ($request->ajax()) {
            $data = RumahSakit::where('kabupaten_kota', 'LIKE', '%' . $request->kabupaten_kota . '%');
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" class="btn btn-warning btn-sm" onclick="edit_data(' . $data->id . ')">Edit</a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="delete" onclick="delete_data(' . $data->id . ')" class="delete btn btn-danger btn-sm">Delete</button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('rumahsakit', [
            'kota' => $kota,
        ]);
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
        RumahSakit::updateOrCreate(
            ['id' => $request->id],
            [
                'nama_rs' => $request->nama_rs,
                'kabupaten_kota' => $request->kab_kota,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
            ]
        );
        return response()->json(['success' => 'Data Rumah Sakit Berhasil Disimpan.']);
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
        $data = RumahSakit::find($id);
        return response()->json($data);
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
        RumahSakit::find($id)->delete();
        return response()->json(['success' => 'Data Rumah Sakit Berhasil Dihapus.']);
    }
}
