<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $pageTitle = 'Admin - Dashboard';

        $generalSettings = GeneralSetting::find(1);
        $contents = optional($generalSettings)->dashboard_text ?? '';

        return view('admin.index',compact('pageTitle', 'contents'));
    }
}
