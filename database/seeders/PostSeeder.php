<?php

namespace Database\Seeders;

use App\Models\Post;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Post::updateOrCreate([
            'title' => 'Tentang kami',
        ], [
            'slug' => Str::slug('Tentang kami'),
            'content' => '<a href="" class="d-block">Toko kami</a>',
            'type' => 'widget_footer',
        ]);

        Post::updateOrCreate([
            'title' => 'Customer Support',
        ], [
            'slug' => Str::slug('Tentang kami'),
            'content' => '<a href="" class="d-block">Toko kami</a>',
            'type' => 'widget_footer',
        ]);

        Post::updateOrCreate([
            'title' => 'Tentang kami',
        ], [
            'slug' => Str::slug('Tentang kami'),
            'content' => '<img src="https://317927-1222945-1-raikfcquaxqncofqfm.stackpathdns.com/wp-content/uploads/2020/05/Partner-LogoArtboard-1-copy-1-1024x488.png" alt="" width="100%" class="rounded">',
            'type' => 'widget_footer',
        ]);
    }
}
