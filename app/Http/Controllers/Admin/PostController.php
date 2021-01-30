<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Bulk\DeleteBulk;
use App\Http\Requests\Post\StorePostRequest;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.post.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $uploaded = null;
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $uploaded = Storage::put('public/post', $file);
            $uploaded = basename($uploaded);
        }

        Post::create([
            'user_id' => $request->user()->id,
            'title' => $request->judul,
            'slug' => Str::slug($request->judul),
            'image' => $uploaded,
            'content' => $request->konten,
            'type' => $request->type ?? 'post',
        ]);

        $type = $request->type ?? 'Post';

        return redirect()->back()->with('info', "$type berhasil ditambahkan");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        return view('admin.post.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(StorePostRequest $request, Post $post)
    {
        $dataUpdate = [
            'user_id' => $request->user()->id,
            'title' => $request->judul,
            'slug' => Str::slug($request->judul),
            'content' => $request->konten,
            'type' => $request->type ?? 'post',
        ];
        if ($request->hasFile('thumbnail')) {
            $file = $request->file('thumbnail');
            $uploaded = Storage::put('public/post', $file);
            $dataUpdate['image'] = basename($uploaded);
            Storage::delete('public/post/' . $post->image);
        }
        $post->update($dataUpdate);

        $type = $request->type ?? 'Post';

        return redirect()->back()->with('info', "$type berhasil diubah");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        Storage::delete('public/post/' . $post->image);
        $type = $post->type ?? 'Post';
        $post->delete();

        return redirect()->back()->with('info', "$type brehasil dihapus");
    }

    public function deleteBulk(DeleteBulk $request)
    {
        $deleted = Post::destroy($request->ids);
        if (!$deleted) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada delivery yang dihpaus',
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Delivery berhasil dihapus',
        ]);
    }
}
