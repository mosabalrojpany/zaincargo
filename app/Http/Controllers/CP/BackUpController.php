<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use Artisan;
use Config;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BackUpController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $directory = $this->getBackupDirectory();

        if (File::exists($directory)) {
            $files = collect(File::files($directory))
                ->sortByDesc(function ($file) {
                    return $file->getCTime();
                })
                ->map(function ($file) {
                    return [
                        'name' => $file->getBaseName(),
                        'date' => date("Y-m-d g:ia", $file->getCTime()),
                        'size' => file_size_human($file->getSize()),
                    ];
                });
        } else {
            $files = [];
        }

        return view('CP.backups')->with(['files' => $files]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|integer|between:0,2',
        ]);

        $type = [
            '0' => '',
            '1' => '--only-db',
            '2' => '--only-files',
        ];

        Artisan::queue('app:backup ' . $type[$request->type]);
    }

    /**
     * Download the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function download($name)
    {
        $file = $this->getBackupDirectory() . "/$name";
        if (File::exists($file)) {
            return response()->download($file);
        }
        return abort(404);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $file = $this->getBackupDirectory() . "/$request->id";
        if (File::exists($file)) {
            File::delete($file);
        }
    }

    /**
     * Get Backup Directory, path of backups files
     */
    private function getBackupDirectory()
    {
        return storage_path('app/' . config('backup.backup.name'));
    }

}
