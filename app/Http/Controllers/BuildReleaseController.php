<?php

namespace App\Http\Controllers;

use App\Models\BuildLibary;
use App\Models\Libary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use ZipArchive;

class BuildReleaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $libaries = Libary::all();

        if (count($libaries) == 0) {
            return redirect()->route('upload')->withErrors(['error' => 'Please upload libary before build release']);
        }
        foreach ($libaries as $libary) {
            $libary->file_path = Storage::url($libary->file_path);
            $index_time = strpos($libary->name, '_');
            $libary->name = substr($libary->name, $index_time + 1);
        }
        $latestBuild = BuildLibary::where('is_active', 1)->first();
        return view('build-release.index', compact('libaries', 'latestBuild'));
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
        $validator = Validator::make($request->all(), [
            'libary' => 'required',
            'version' => 'unique:build_libaries,released_version',
        ]);
        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }
        $selected = [];
        foreach ($request->libary as $libary) {
            $getLibaries = Libary::where('name', 'LIKE', '%' . $libary . '%')->first();
            if ($getLibaries) {
                array_push($selected, $getLibaries);
            }
        }
        try {
            if (count($selected) != count($request->libary)) {
                return back()->with('error', 'Some libaries not found');
            }
            $zip = new ZipArchive();
            $zipName = $request->version . '.zip';
            $zip->open(Storage::path('public/' . $zipName), ZipArchive::CREATE);
            $id_lib = [];
            foreach ($selected as $libary) {
                array_push($id_lib, $libary->id);
                $zip->addFile(Storage::path($libary->file_path), str_replace('public/', '', $libary->file_path));
            }
            $zip->close();
            DB::beginTransaction();
            BuildLibary::where('is_active', 1)->update(['is_active' => 0]);
            BuildLibary::create([
                'released_version' => str_replace('.zip', '', $zipName),
                'file_path' => 'public/' . $zipName,
                'id_libaries' => implode(',', $id_lib),
                'is_active' => 1,
            ]);
            foreach ($selected as $libary) {
                $libary->released_version = str_replace('.zip', '', $zipName);
                $libary->save();
            }

            DB::commit();
            return redirect()->route('home');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th);
            return back()->with('error', 'Something went wrong');
        }
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
