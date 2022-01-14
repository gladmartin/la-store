<?php

namespace App\Lib\ScrapeMarketPlace\Web;

use App\Lib\ScrapeMarketPlace\Exception\MarketPlaceException;
use App\Lib\ScrapeMarketPlace\Exception\ShopeeException;
use App\Lib\ScrapeMarketPlace\Http\Request;
use App\Models\BlackList;

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
        // dd($this->url);
        $request = Request::get($urlApi, [
            'Referer' => 'https://shopee.co.id',
            // 'referer' => $this->url,
            'x-api-source' => 'pc',
            'x-requested-with' => 'XMLHttpRequest',
            'x-shopee-language' => 'id',
            'accept-language' => 'en-US,en;q=0.9,id-ID;q=0.8,id;q=0.7',
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36',
            'accept' => '*/*',
        ]);
        
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

        $description = $result->description ?? 'N/A';
        $blacklist = BlackList::all()->pluck('blacklist')->toArray();
        // $description = str_replace($blacklist, '', $description);
        // $blacklist = ['beli', '0123123'];
        $descriptionExplode = explode("\n", $description);
        foreach ($descriptionExplode as $key => $des) {
            foreach ($blacklist as $word) {
                if (strpos(strtolower($des), strtolower($word)) !== false) {
                    unset($descriptionExplode[$key]);
                }
            }
        }
        $description = implode("\n", $descriptionExplode);

        $price = round($price, -3);

        $returnData = [
            'name' => $result->name,
            'categories' => $categories,
            'thumbnail' => $this->urlFile . $result->image,
            'images' => $images,
            'description' => $description,
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

        $request = Request::get($urlApi, [
            'Referer' => 'https://shopee.co.id',
            // 'referer' => $this->url,
            'x-api-source' => 'pc',
            'x-requested-with' => 'XMLHttpRequest',
            'x-shopee-language' => 'id',
            'accept-language' => 'en-US,en;q=0.9,id-ID;q=0.8,id;q=0.7',
            'user-agent' => 'Mozilla/5.0 (Windows NT 10.0; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/90.0.4430.93 Safari/537.36',
            'accept' => '*/*',
        ]);
        if ($request->failed()) throw new ShopeeException("Gagal mengambil list produk, response body " . $request->body());
        $result = json_decode($request->body());
        if (!$result->items) throw new ShopeeException('Toko tidak ditemukan, response body ' . $request->body());

        // dd($result);

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
