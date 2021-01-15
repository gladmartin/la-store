<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductModel;
use App\Models\Variant;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $title = 'Hoodie Polos Jumpper Termurah Pria Wanita Hodie Premium';
        
        $product = Product::updateOrCreate([
            'slug' => Str::slug($title),
        ],[
            'title' => $title,
            'deskripsi' => 'Deskripsi produk',
            'stok' => 20,
            'harga' => 60000,
            'image' => 'https://cf.shopee.co.id/file/772330591d5d6bf7c099d3a7c84033e9',
            'images' => json_encode(['https://cf.shopee.co.id/file/772330591d5d6bf7c099d3a7c84033e9']),
            'berat' => 1900,
            'user_id' => 1,
            'category_id' => 2,
            'diskon' => 10,
        ]);

        Variant::updateOrCreate([
            'product_id' => $product->id,
            'key' => 'Ukuran',
            'value' => 'M',
            'stok' => 20,
        ]);

        Variant::updateOrCreate([
            'product_id' => $product->id,
            'key' => 'Ukuran',
            'value' => 'L',
            'stok' => 20,
            'harga_tambahan' => 0,
        ]);

        Variant::updateOrCreate([
            'product_id' => $product->id,
            'key' => 'Ukuran',
            'value' => 'XL',
            'stok' => 20,
            'harga_tambahan' => 1000,
        ]);

        Variant::updateOrCreate([
            'product_id' => $product->id,
            'key' => 'Warna',
            'value' => 'Merah',
        ]);

        Variant::updateOrCreate([
            'product_id' => $product->id,
            'key' => 'Warna',
            'value' => 'Putih',
        ]);
        
    }
}
