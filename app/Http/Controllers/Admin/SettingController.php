<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Gate;

use App\Models\Setting;

class SettingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function logo()
    {
        $setting = Setting::first();
        $footername = $setting->footername;
        $hr_link = $setting->hr_link;
        $title = $setting->title;
        return view('admin.setting.logo', compact('footername', 'hr_link', 'title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update_logo(Request $request)
    {
        $setting = Setting::first();
        $setting->footername = $request->footername;
        $setting->hr_link = $request->hr_link;
        $setting->title = $request->title;
        $setting->save();

        if ($request->hasFile('favicon')) {
            if (!file_exists(public_path('assets/images'))) {
                mkdir(public_path('assets/images'), 0777);
            }
            $file     = $request->file('favicon');
            $filename = 'favicon.'.$file->extension();
            @unlink(public_path('assets/images/').$filename);
            $file->move(public_path('assets/images'), $filename);
        }
        if ($request->hasFile('photo')) {
            if (!file_exists(public_path('assets/images'))) {
                mkdir(public_path('assets/images'), 0777);
            }
            $file     = $request->file('photo');
            $filename = 'logo.'.$file->extension();
            @unlink(public_path('assets/images/').$filename);
            $file->move(public_path('assets/images'), $filename);
        }
        if ($request->hasFile('photo_login')) {
            if (!file_exists(public_path('assets/images'))) {
                mkdir(public_path('assets/images'), 0777);
            }
            $file     = $request->file('photo_login');
            $filename = 'logo_login.'.$file->extension();
            @unlink(public_path('assets/images/').$filename);
            $file->move(public_path('assets/images'), $filename);
        }
        if ($request->hasFile('photo_sm')) {
            if (!file_exists(public_path('assets/images'))) {
                mkdir(public_path('assets/images'), 0777);
            }
            $file     = $request->file('photo_sm');
            $filename = 'logo_sm.'.$file->extension();
            @unlink(public_path('assets/images/').$filename);
            $file->move(public_path('assets/images'), $filename);
        }
        if ($request->hasFile('login_background')) {
            if (!file_exists(public_path('assets/images'))) {
                mkdir(public_path('assets/images'), 0777);
            }
            $file     = $request->file('login_background');
            $filename = 'login_background.'.$file->extension();
            @unlink(public_path('assets/images/').$filename);
            $file->move(public_path('assets/images'), $filename);
        }

        return redirect()->route('admin.setting.logo');
    }

}
