<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function web()
    {
        return view('admin.setting.web');
    }

    public function store(Request $request)
    {
        $request->validate([
            'options' => 'required',
            'logo' => 'nullable|image',
        ]);

        if (!$request->options['site_default_font_url']) {
            return redirect()->back()->with('info', 'Masukkan url font googlenya');
        }


        if ($request->hasFile('logo')) {
            $uploadLogo = Storage::put('public', $request->file('logo'));
            Option::updateOrCreate(
                [
                    'name' => 'logo',
                ],
                [
                    'value' => basename($uploadLogo),
                ]
            );
        }

        foreach ($request->options as $key => $option) {
            Option::updateOrCreate(
                [
                    'name' => $key,
                ],
                [
                    'value' => $option,
                ],
            );
        }

        return redirect()->back()->with('info', 'Settingan berhasil diperbarui');
    }
}
