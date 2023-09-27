<?php

namespace App\Http\Controllers;

use App\Models\Garansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GaransiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            # code...
            $data = Garansi::all();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('periode_garansi', function ($data) {
                    return $data->periode_garansi . ' Tahun';
                })
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" class="btn btn-sm btn-warning" onclick="detail_data(' . $data->id . ')">Detail</a>';
                    return $button;
                })
                ->rawColumns(['periode_garansi', 'action'])
                ->make(true);
        }
        return view('garansi');
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
        $rules = [
            'judul_garansi' => 'required',
            'periode_garansi'   => 'required',
            'deskripsi' => 'required',
        ];

        $messages = [
            'judul_garansi.required' => 'Judul Garansi harus diisi',
            'periode_garansi.required' => 'Periode Garansi harus diisi',
            'deskripsi.required' => 'Deskripsi harus diisi',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()->all()
            ]);
            return redirect()->back()->withErrors($validator)->withInput($request->all());
        }

        Garansi::updateOrCreate(
            ['id' => $request->id],
            [
                'nama' => $request->judul_garansi,
                'periode_garansi' => $request->periode_garansi,
                'keterangan' => $request->deskripsi,
            ]
        );

        return redirect()->back()->with('success', 'Data Garansi Berhasil Disimpan.');
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
        $data = Garansi::findOrFail($id);
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
        //
    }
}
