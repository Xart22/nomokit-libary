<?php

namespace App\Http\Controllers;

use App\Models\Libary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UploadLibaryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $libaries = Libary::all();
        foreach ($libaries as $libary) {
            $libary->file_path = Storage::url($libary->file_path);
            $index_time = strpos($libary->name, '_');
            $libary->name = substr($libary->name, $index_time + 1);
        }
        return view('upload.index', [
            'libaries' => $libaries
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function upload(Request $request)
    {

        $files = $request->file('file');
        foreach ($files as $file) {
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = Storage::putFileAs('public', $file, $fileName);
            Libary::create([
                'name' => str_replace('.zip', ' ', $fileName),
                'file_path' => $filePath,
            ]);
        }
        return response()->json([
            "code" => 200,
            'success' => 'You have successfully upload file.'
        ]);
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
