<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::all()->groupBy('group');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'head_photo_file' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
        ]);

        if ($request->filled('_active_tab')) {
            session()->flash('active_tab', $request->input('_active_tab'));
        }

        $data = $request->except(['_token', '_method', '_active_tab', 'head_photo_file']);

        // Handle file upload for head_photo from local computer
        if ($request->hasFile('head_photo_file')) {
            $path = $request->file('head_photo_file')->store('settings', 'public');
            $data['head_photo'] = asset('storage/'.$path);
        }

        foreach ($data as $key => $value) {
            $setting = Setting::where('key', $key)->first();
            if ($setting) {
                $setting->update(['value' => $value]);
            } else {
                Setting::set($key, $value ?? '');
            }
        }

        // Clear cache
        Cache::flush();

        return back()->with('success', 'Pengaturan situs web dan foto pimpinan berhasil diperbarui!');
    }
}
