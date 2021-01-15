<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cateogry = Category::updateOrCreate([
            'slug' => 'pakaian-pria'
        ],[
            'user_id' => 1,
            'name' => 'Pakaian Pria',
            'icon' => 'https://cf.shopee.co.id/file/de587d171994bfb399ef7601c6372ab9_tn',
        ]);

        Category::updateOrCreate([
            'slug' => 'kemeja'
        ],[
            'user_id' => 1,
            'name' => 'Kemeja',
            'icon' => 'https://cf.shopee.co.id/file/de587d171994bfb399ef7601c6372ab9_tn',
            'category_id' => $cateogry->id,
        ]);
        

        Category::updateOrCreate([
            'slug' => 'tas-wanita'
        ],[
            'user_id' => 1,
            'name' => 'Tas Wanita',
            'icon' => 'https://cf.shopee.co.id/file/64c14bde856d8700aa0b4c3d8835ad45_tn',
        ]);
    }
}
