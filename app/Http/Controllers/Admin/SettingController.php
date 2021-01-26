<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Option;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

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
            if ($key == 'site_default_color') {
                $siteDefaultColorLow = adjustBrightness($option, 0.8);
            }
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

    public function footer()
    {
        return view('admin.setting.footer.index');
    }

    public function bank()
    {
        return view('admin.setting.bank.index');
    }
    
    public function bankCreate()
    {
        return view('admin.setting.bank.create');
    }

    public function bankStore(Request $request)
    {
        $request->validate([
            'thumbnail' => 'image',
        ]);

        $file = $request->file('thumbnail');
        $uploaded = Storage::put('public/post', $file);
        $uploaded = basename($uploaded);

        $judul = uniqid('Akun bank ');

        $post = Post::create([
            'user_id' => $request->user()->id,
            'title' => $judul,
            'slug' => Str::slug($judul),
            'image' => $uploaded,
            'content' => '-',
            'type' => 'akun_bank',
        ]); 

        foreach ($request->meta as $key => $value) {
            $post->metas()->create([
                'key' => $key,
                'value' => $value,
            ]);
        }

        return redirect()->route('setting.bank')->with('info', 'Akun bank berhasil ditambah');
    }
}
