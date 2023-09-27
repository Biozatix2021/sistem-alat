<?php

namespace App\Http\Controllers;

use App\Models\Alat;
use App\Models\ManualBook;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ManualBookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $alats = Alat::select('id', 'nama_alat')->get();
        if ($request->ajax()) {
            $data = ManualBook::with('alat');
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('nama_file', function ($data) {
                    $button = '<a href="' . asset('storage/manualbook/' . $data->nama_file) . '" target="_blank">Download</a>';
                    return $button;
                })
                ->addColumn('action', function ($data) {
                    $button = '<button type="button" class="delete btn btn-danger btn-sm" onclick="delete_data(' . $data->id . ')"><i class="fa fa-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['nama_file', 'action'])
                ->make(true);
        }
        return view('manual_books', [
            'alats' => $alats
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
        $rules = [
            'alat_id' => 'required',
            'nama_file' => 'required|mimes:pdf|max:2048',
        ];

        $messages = [
            'alat_id.required' => 'Alat harus diisi.',
            'nama_file.required' => 'File harus diisi.',
            'nama_file.mimes' => 'File harus berupa pdf.',
            'nama_file.max' => 'File maksimal 2MB.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            # code...
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        $name = $request->file('nama_file')->getClientOriginalName();

        $filename = str_replace(' ', '_', $name);

        if ($request->file('nama_file')) {
            # code...  
            $validateData['pdf'] = $request->file('nama_file')->storeAs('public/manualbook', $filename);
        }

        ManualBook::create([
            'alat_id' => $request->alat_id,
            'nama_file' => $filename,
        ]);

        return response()->json(['success' => 'Data berhasil ditambahkan.']);
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
        // delete data and file
        $data = ManualBook::findorfail($id);
        $file = $data->nama_file;
        $path = public_path() . '/storage/manualbook/' . $file;
        if (file_exists($path)) {
            unlink($path);
        }
        $data->delete();

        return response()->json(['success' => 'Data berhasil dihapus.']);
    }
}
