<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\BuildLibary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CheckUpdateController extends Controller
{
    public function checkUpdate()
    {
        $latestBuild = BuildLibary::where('is_active', 1)->first();
        $latestBuild->file_path = asset(Storage::url($latestBuild->file_path));
        return response()->json([
            'code' => 200,
            'version' => $latestBuild->released_version,
            'url' => $latestBuild->file_path,
        ]);
    }
}
