<?php

namespace App\Lib\ScrapeMarketPlace\Web;

use App\Lib\ScrapeMarketPlace\Exception\MarketPlaceException;
use App\Lib\ScrapeMarketPlace\Exception\ShopeeException;
use App\Lib\ScrapeMarketPlace\Http\Request;

class Shopee
{

    private $urlFile = 'https://cf.shopee.co.id/file/';

    public function __construct($url)
    {
        $this->url = $url;
    }

    public function singleProduct($persen = 0, $tambah = 0)
    {
        if (strpos($this->url, 'https://shopee.co.id/api/v2/item/get?itemid=') !== false) {
            $urlApi = $this->url;
        } else {
            $ids = explode('.', $this->url);
            if (count($ids) < 2) throw new ShopeeException('Url produk tidak valid: id tidak ditemukan');
            $this->shopId = $ids[count($ids) - 2];
            $this->itemId = $ids[count($ids) - 1];
            $urlApi = "https://shopee.co.id/api/v2/item/get?itemid={$this->itemId}&shopid={$this->shopId}";
        }

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
        $price = $result->price / 100000;
        if ($persen > 0) {
            $priceUp = $price * $persen / 100;
            $price = $price + $priceUp;
        }
        $price = $price + $tambah;

        $returnData = [
            'name' => $result->name,
            'categories' => $categories,
            'thumbnail' => $this->urlFile . $result->image,
            'images' => $images,
            'description' => $result->description,
            'stock' => $result->stock,
            'weight' => $result->weight ?? 0,
            'price' => $price,
            'variants' => $variants,
        ];

        return $returnData;
    }

    public function multipleProduct()
    {
        if (strpos($this->url, 'https://shopee.co.id/shop/') === false) throw new ShopeeException('Id toko tidak ditemukan');
        $id = str_replace('https://shopee.co.id/shop/', '', $this->url);
        $id = explode('/', $id);
        $id = $id[0];
        // $urlApi = "https://shopee.co.id/api/v2/search_items/?by=sales&limit=30&match_id={$id}&newest=0&order=desc&page_type=shop&version=2";
        $urlApi = "https://shopee.co.id/api/v2/search_items/?by=pop&entry_point=ShopBySearch&limit=30&match_id={$id}&newest=0&order=desc&page_type=shop&version=2";

        $request = Request::get($urlApi);
        if ($request->failed()) throw new ShopeeException("Gagal mengambil list produk, response body " . $request->body());
        $result = json_decode($request->body());
        if (!$result->items) throw new ShopeeException('Toko tidak ditemukan, response body ' . $request->body());

        $result = $result->items;
        $products = [];
        foreach ($result as $item) {
            $products[] = [
                'item_id' => $item->itemid,
                'name' => $item->name,
                // 'image' => $this->urlFile . $item->image,
                'api_url' => "https://shopee.co.id/api/v2/item/get?itemid={$item->itemid}&shopid={$id}",
            ];
        }

        return $products;
    }
}
