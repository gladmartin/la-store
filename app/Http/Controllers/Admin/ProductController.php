<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Product\ProductStoreRequest;
use App\Http\Requests\Admin\Product\ProductUpdateRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.product.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.product.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductStoreRequest $request)
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
                'user_id' => $request->user()->id,
            ]);
            $category = $category->id;
        }
        $deskripsi = str_replace(['Tokopedia', 'Shopee', 'tokped', 'tokopedia', 'shopee'], '', $request->deskripsi);
        $product = Product::create([
            'user_id' => $request->user()->id,
            'category_id' => $category,
            'title' => $request->produk,
            'slug' => Str::slug($request->produk),
            'deskripsi' => $deskripsi,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'diskon' => $request->diskon,
            'berat' => $request->berat,
            'kondisi' => $request->kondisi,
            'image' => $thumbnailUploaded,
            'images' => json_encode($imagesUploaded),
            'url_sumber' => $request->url_sumber,
        ]);
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

        return redirect()->route('product.index')->with('info', 'Produk berhasil ditambahakan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::all();

        return view('admin.product.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductUpdateRequest $request, Product $product)
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
                'user_id' => $request->user()->id,
            ]);
            $category = $category->id;
        }
        $deskripsi = str_replace(['Tokopedia', 'Shopee', 'tokped', 'tokopedia', 'shopee'], '', $request->deskripsi);
        $product->update([
            'user_id' => $request->user()->id,
            'category_id' => $category,
            'title' => $request->produk,
            'slug' => Str::slug($request->produk),
            'deskripsi' => $deskripsi,
            'stok' => $request->stok,
            'harga' => $request->harga,
            'diskon' => $request->diskon,
            'berat' => $request->berat,
            'kondisi' => $request->kondisi,
            'image' => $thumbnailUploaded,
            'images' => json_encode($imagesUploaded),
            'url_sumber' => $request->url_sumber,
        ]);
        $variants = null;
        foreach ($request->varian as $key => $value) {
            if ($value['key'] || $value['value'] || $value['stok']) {
                $variants[$key] = $value;
                $variants[$key]['product_id'] = $product->id;
            }
        }

        if ($variants) {
            $product->variants()->delete();
            $product->variants()->insert($variants);
        }

        return redirect()->back()->with('info', 'Produk berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('product.index')->with('info', 'Produk berhasil dihapus');
    }
}
