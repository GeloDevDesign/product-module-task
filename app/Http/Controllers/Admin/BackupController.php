<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Storage;

class BackupController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $sluggedName = str_replace(' ', '-', config('app.name'));
        $rawBackups = Storage::disk('local')->allFiles($sluggedName);
        $backups = collect($rawBackups)->sortDesc();

        $page = $request->filled('page') ? $request->page : 1;

        if ($request->filled('per_page')) {
            if ($request->per_page != 'all') {
                $backups = $this->paginateCollection($backups, $page, $request->per_page);
            } else {
                $backups = $backups;
            }
        } else {
            $backups = $this->paginateCollection($backups, $page, 50);
        }

        $filters = [
            'per_page' => $request->per_page,
            'page' => $request->page,
        ];

        return view('admin.backups.index', compact('backups', 'filters'));
    }

    public function generateDatabaseBackup(Request $request)
    {
        Artisan::call('backup:run --only-db');

        $sluggedName = str_replace(' ', '-', config('app.name'));
        $filename = collect(Storage::disk('local')->allFiles($sluggedName))->sortDesc()->first();

        $explode = explode('/', $filename);
        $sanitizedFilename = $explode && count($explode) > 1 ? $explode[1] : $filename;

        activity()->log('Created Database Backup: ' . $sanitizedFilename)
            ->causedBy(authUser());

        // return redirect()->route('admin.backups.index')
        return to_route('admin.backups.index')
            ->withSuccess('Backup Generated Successfully');
    }

    public function generateFullBackup(Request $request)
    {
        Artisan::call('backup:run');

        $sluggedName = str_replace(' ', '-', config('app.name'));
        $filename = collect(Storage::disk('local')->allFiles($sluggedName))->sortDesc()->first();

        $explode = explode('/', $filename);
        $sanitizedFilename = $explode && count($explode) > 1 ? $explode[1] : $filename;

        activity()->log('Created Full Backup: '. $sanitizedFilename)
            ->causedBy(authUser());

        // return redirect()->route('admin.backups.index')
        return to_route('admin.backups.index')
            ->withSuccess('Backup Generated Successfully');
    }

    public function downloadBackup(Request $request)
    {
        return Storage::download($request->file);
    }
    
    public function deleteBackup(Request $request)
    {
        $deleteBackup = Storage::disk('local')->delete($request->file);

        $explode = explode('/', $request->file);
        $sanitizedFilename = $explode && count($explode) > 1 ? $explode[1] : $filename;

        activity()->log('Deleted Database Backup: '.$sanitizedFilename)
            ->causedBy(authUser());

        // return redirect()->route('admin.backups.index')
        return to_route('admin.backups.index')
        ->withSuccess('Backup Deleted Successfully');
    }
}
