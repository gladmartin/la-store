<?php

namespace App\Lib\ScrapeMarketPlace\Web;

use App\Lib\ScrapeMarketPlace\Exception\MarketPlaceException;
use App\Lib\ScrapeMarketPlace\Exception\ShopeeException;
use App\Lib\ScrapeMarketPlace\Http\Request;

class Shopee {
    
    private $urlFile = 'https://cf.shopee.co.id/file/';

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function singleProduct()
    {
        $ids = explode('.', $this->url);
        if (count($ids) < 2) throw new ShopeeException('Url produk tidak valid: id tidak ditemukan');
        $this->shopId = $ids[count($ids) - 2];
        $this->itemId = $ids[count($ids) - 1];
        $urlApi = "https://shopee.co.id/api/v2/item/get?itemid={$this->itemId}&shopid={$this->shopId}";

        $request = Request::get($urlApi);
        if ($request->failed()) throw new ShopeeException("Gagal mengambil info produk, response body " . $request->body());
        $result = json_decode($request->body());
        if (!$result->item) throw new ShopeeException('Produk tidak ditemukan, response body ' . $request->body());
        
        $result = $result->item;

        $categories = [];
        foreach ($result->categories as $category) {
            $categories[] = $category->display_name;
        }

        $images = [];
        foreach ($result->images as $image) {
            $images[] = $this->urlFile . $image;
        }

        $variants = [];
        foreach ($result->tier_variations as $variant) {
            if ($variant->name == '') continue;
            foreach ($variant->options as $option) {
                $variants[] = [
                    'name' => $variant->name,
                    'value' => $option,
                    'stock' => null,
                    'price_add' => null,
                ];
            }
        }

        $returnData = [
            'name' => $result->name,
            'categories' => $categories,
            'thumbnail' => $this->urlFile . $result->image,
            'images' => $images,
            'description' => $result->description,
            'stock' => $result->stock,
            'weight' => $result->weight ?? 0,
            'price' => $result->price / 100000,
            'variants' => $variants,    
        ];

        return $returnData;
        
    }
}