<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function single($slug, $id)
    {
        $post = Post::where('slug', $slug)->where('id', $id)->where('type', 'post')->firstOrFail();

        return view('site.post.single', compact('post'));
    }
}
