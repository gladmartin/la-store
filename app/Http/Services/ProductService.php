<?php

namespace App\Http\Services;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    static public function create(Request $request)
    {
        $thumbnailUploaded = $request->thumbnail;
        $imagesUploaded = null;
        if ($request->galeri) {
            $imagesUploaded = explode('|', $request->galeri);
        }

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailUploaded = Storage::put('public/product', $thumbnail);
            $thumbnailUploaded = basename($thumbnailUploaded);
        }
        $category = $request->kategori;
        if ($request->url_sumber) {
            $category = Category::firstOrCreate([
                'slug' => Str::slug($request->kategori),
            ], [
                'name' => $request->kategori,
                'user_id' => $request->user_id ?? auth()->user()->id,
            ]);
            $category = $category->id;
        }
        $deskripsi = str_replace(['Tokopedia', 'Shopee', 'tokped', 'tokopedia', 'shopee'], '', $request->deskripsi);
        $product = Product::create([
            'user_id' => $request->user_id ?? auth()->user()->id,
            'category_id' => $category,
            'title' => $request->produk,
            'slug' => Str::slug($request->produk),
            'deskripsi' => $deskripsi,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'diskon' => $request->diskon ?? 0,
            'berat' => $request->berat ?? 100,
            'kondisi' => $request->kondisi ?? 'baru',
            'image' => $thumbnailUploaded,
            'images' => json_encode($imagesUploaded),
            'url_sumber' => $request->url_sumber,
        ]);
        if (is_array($request->varian)) {
            $variants = null;
            foreach ($request->varian as $key => $value) {
                if ($value['key'] || $value['value'] || $value['stok']) {
                    $variants[$key] = $value;
                    $variants[$key]['product_id'] = $product->id;
                }
            }

            if ($variants) {
                $product->variants()->insert($variants);
            }
        }
        $insertMeta = [
            [
                'key' => 'harga_tambahan',
                'value' => $request->tambah ?? 0,
                'metaable_id' => $product->id,
                'metaable_type' => Product::class,
            ],
            [
                'key' => 'harga_tambahan_persen',
                'value' => $request->persen ?? 0,
                'metaable_id' => $product->id,
                'metaable_type' => Product::class,
            ]
        ];
        $product->metas()->insert($insertMeta);

        return $product;
    }
}
