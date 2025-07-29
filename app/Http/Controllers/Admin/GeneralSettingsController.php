<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\GeneralSetting;
use App\Http\Controllers\Controller;

class GeneralSettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $generalSettings = GeneralSetting::findOrFail(1);

        return view('admin.general_settings.form', compact('generalSettings'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, GeneralSetting $general_setting)
    {
        switch ($request->tab) {
            case 'main':

                if ($request->filled('items_new') && !$request->filled('items')) {
                    $request['all_emails'] = $request->items_new;
                }
        
                if ($request->filled('items') && !$request->filled('items_new')) {
                    $request['all_emails'] = $request->items;
                }
        
                if ($request->filled('items') && $request->filled('items_new')) {
                    $request['all_emails'] = array_merge($request->items, $request->items_new);
                }
        
                $request->validate([
                    // 'notification_emails.*' => 'required|email'
                    'all_emails.*' => 'required|email'
                ], [
                    'all_emails.*' => [
                        'email' => 'Invalid email found'
                    ]
                ]);
        
                // $general_setting->notification_emails = $request->notification_emails;
                $general_setting->notification_emails = $request->all_emails;
                $general_setting->maintenance_mode = $request->has('maintenance_mode');

                break;

            case 'terms-conditions':
                $general_setting->terms_and_conditions = $request->terms_and_conditions;
                break;

            case 'dashboard-text':
                $general_setting->dashboard_text = $request->dashboard_text;
                break;
            
            default:
                # code...
                break;
        }

        $general_setting->save();

        // return redirect()->route('admin.general-settings.index', ['tab' => $request->tab])->withSuccess('General Settings updated successfully');
        return to_route('admin.general-settings.index', ['tab' => $request->tab])->withSuccess('General Settings updated successfully');
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
