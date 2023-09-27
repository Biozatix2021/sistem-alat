<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class FaqsController extends Controller
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
            $data = Faq::all();
            return datatables()->of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $button = '<button type="button"class="edit btn btn-primary btn-sm" onclick="edit_data(' . $data->id . ')"><i class="fa fa-edit"></i></button>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" class="delete btn btn-danger btn-sm" onclick="delete_data(' . $data->id . ')"><i class="fa fa-trash"></i></button>';
                    return $button;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('faqs');
    }

    public function upload(Request $request)
    {
        if ($request->hasFile('upload')) {
            $originName = $request->file('upload')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;

            $request->file('upload')->move(public_path('media'), $fileName);

            $url = asset('media/' . $fileName);

            return response()->json(['fileName' => $fileName, 'uploaded' => 1, 'url' => $url]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request  $request)
    {
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
            'judul' => 'required',
            'deskripsi' => 'required',
        ];

        $messages = [
            'judul.required' => 'Judul harus diisi.',
            'deskripsi.required' => 'Isi harus diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            # code...
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        Faq::updateOrCreate(
            ['id' => $request->id],
            [
                'judul' => $request->judul,
                'isi' => $request->deskripsi,
                'status' => $request->status,
            ]
        );

        return redirect()->back()->with('success', 'Faq berhasil disimpan.');
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
        $data = Faq::findorfail($id);
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
        $rules = [
            'edit_judul' => 'required',
            'editor' => 'required',
        ];

        $messages = [
            'edit_judul.required' => 'Judul harus diisi.',
            'editor.required' => 'Isi harus diisi.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            # code...
            return response()->json(['errors' => $validator->errors()->all()]);
        }

        Faq::updateOrCreate(
            ['id' => $request->id],
            [
                'judul' => $request->edit_judul,
                'isi' => $request->editor,
                'status' => $request->edit_status,
            ]
        );

        return redirect()->back()->with('success', 'Faq berhasil disimpan.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Faq::find($id)->delete();
        return response()->json(['success' => 'Faq berhasil dihapus.']);
    }
}
