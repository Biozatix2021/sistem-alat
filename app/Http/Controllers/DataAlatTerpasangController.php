<?php

namespace App\Http\Controllers;

use App\Models\Alat_terpasang;
use App\Models\Kota;
use Illuminate\Http\Request;

class DataAlatTerpasangController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request  $request)
    {
        $filter = $request->get('filter');

        $kota = Kota::all();
        if ($request->ajax()) {

            if ($filter != null) {
                # code...
                $data = Alat_terpasang::with('rumah_sakit', 'alat', 'garansi')
                    ->where('is_delete', '=', '0')
                    ->where('rs_id', '=', $filter)
                    ->orderBydesc('created_at');
            } else if ($filter == null) {
                # code...
                $data = Alat_terpasang::with('rumah_sakit', 'alat', 'garansi')
                    ->where('is_delete', '=', '1')
                    ->orderBydesc('created_at');
            } else {
                $data = Alat_terpasang::with('rumah_sakit', 'alat', 'garansi')
                    ->where('is_delete', '=', '0')
                    ->orderBydesc('created_at');
            }
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<a href="javascript:void(0)" onclick="detail_data(' . $data->id . ')" class="btn btn-sm btn-primary"><i class="fa fa-eye"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="' . $data->id . '" class="delete btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('alat_terpasang', [
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
        //
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
        $data = Alat_terpasang::with('rumah_sakit', 'alat', 'garansi')
            ->where('id', '=', $id)->first();
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
