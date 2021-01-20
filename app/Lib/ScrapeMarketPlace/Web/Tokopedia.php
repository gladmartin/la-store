<?php

namespace App\Lib\ScrapeMarketPlace\Web;

use App\Lib\ScrapeMarketPlace\Exception\MarketPlaceException;
use App\Lib\ScrapeMarketPlace\Exception\TokopediaException;
use App\Lib\ScrapeMarketPlace\Http\Request;
use Illuminate\Support\Str;

class Tokopedia
{

    private $gqlUrl = 'https://gql.tokopedia.com/';

    private $headersTokped = [];

    public function __construct($url)
    {
        $this->url = $url;
        $this->parseUrl = parse_url($url);
        $this->headersTokped = [
            'Content-Type' => 'text/plain',
            'Content-Length' => 239,
            'Host' => 'gql.tokopedia.com',
            'User-Agent' => 'PostmanRuntime/7.26.8',
            'Accept' => '*/*',
            'Accept-Encoding' => 'gzip, deflate, br',
            'Cookie' => 'lang=id; bm_sz=33F3A3811CE610A2D32E41E8CD3F578D~YAAQVeUcuABHmxh3AQAAmTZTHwp/mPIVk2ixL3RVmug9lasD+Bwogs8QBQ2qVaRsjgDzoOf8CsaHmVdcekHokZhGWXR//saTbwykxZKedj13+fizXkTTwTCmNszut/SaMVOLJQqw54HL9aaK4GkqWS7GOXyFp24TnhpNuk82j+BRj7LLGcms0ctuetrZJ6GI/m5y; _abck=922A2A975D0035698694E2C71CD6176E~-1~YAAQVeUcuAFHmxh3AQAAmTZTHwWHlWbMtaAnseb80sia9nOjlqHl80HJl70/sWhhf9IrdK5tYWSpfTZEuQEGXOVuiaA+SXakHLyn1bbnWqc+e6m4L6z8aV5+24cYehuSSZKYnYx+3pl3WP7TidsLGWeKfTmTZ63em0WmrocyvSVCT/cFgImgM/O6oeg8RcWxMGbFN18GRNlPcN3F/x8tdcoBwZ+Z2WzIv2E7IGb1/htcZwy/72hGeUNOYSG8QpFzTDGUnGg5TpDGo8IitxFxQ2957/ZdnsrbBuNanyj4SwIBqQoZ1D32zYs7HBkT1mFIgSnrB/4jRNtBaIM=~-1~-1~-1',
            'Cache-Control' => 'no-cache',
            'Postman-Token' => (string) Str::uuid(),
        ];
    }

    public function singleProduct()
    {
        $ids = explode('/', $this->parseUrl['path']);
        if (count($ids) < 3) throw new TokopediaException('Url produk tidak valid domain toko dan slug produk tidak ada');
        $this->shopId = $ids[1];
        $this->itemId = $ids[2];
        if ($this->itemId == '') throw new TokopediaException('Produk slug tidak ditemukan');
        $body = $this->getGqlSingleProduct();
        $request = Request::post(config('lastore.proxy_shared_hoting'), [], $body);
        if ($request->failed()) throw new TokopediaException("Gagal mengambil info produk, response body " . $request->body());
        $result = json_decode($request->body());
        if (!$result->data) throw new TokopediaException('Produk tidak ditemukan, response body ' . $request->body());

        $result = $result->data->getPDPInfo;

        $categories = [];
        foreach ($result->category->detail as $category) {
            $categories[] = $category->name;
        }

        $images = [];
        foreach ($result->pictures as $image) {
            $images[] = $image->urlOriginal;
        }

        $variants = [];
        // foreach ($result->tier_variations as $variant) {
        //     if ($variant->name == '') continue;
        //     foreach ($variant->options as $option) {
        //         $variants[] = [
        //             'name' => $variant->name,
        //             'value' => $option,
        //             'stock' => null,
        //             'price_add' => null,
        //         ];
        //     }
        // }

        $returnData = [
            'name' => $result->basic->name,
            'categories' => $categories,
            'thumbnail' => $images[0],
            'images' => $images,
            'description' => $result->basic->description,
            'stock' => $result->stock ?? 1,
            'weight' => $result->basic->weight ?? 100,
            'price' => $result->basic->price,
            'variants' => $variants,
        ];

        return $returnData;
    }

    public function multipleProduct()
    {
        if (strpos($this->url, 'https://shopee.co.id/shop/') === false) throw new TokopediaException('Id toko tidak ditemukan');
        $id = str_replace('https://shopee.co.id/shop/', '', $this->url);
        $id = explode('/', $id);
        $id = $id[0];
        // $urlApi = "https://shopee.co.id/api/v2/search_items/?by=sales&limit=30&match_id={$id}&newest=0&order=desc&page_type=shop&version=2";
        $urlApi = "https://shopee.co.id/api/v2/search_items/?by=pop&entry_point=ShopBySearch&limit=30&match_id={$id}&newest=0&order=desc&page_type=shop&version=2";

        $request = Request::get(config('lastore.proxy_shared_hoting'));
        if ($request->failed()) throw new TokopediaException("Gagal mengambil list produk, response body " . $request->body());
        $result = json_decode($request->body());
        if (!$result->items) throw new TokopediaException('Toko tidak ditemukan, response body ' . $request->body());

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

    private function getGqlSingleProduct()
    {
        $gql = [
            'operationName' => 'PDPInfoQuery',
            'variables' => [
                'shopDomain' => $this->shopId,
                'productKey' => $this->itemId,
            ],
            'query' => 'query PDPInfoQuery($shopDomain: String, $productKey: String) {  getPDPInfo(productID: 0, shopDomain: $shopDomain, productKey: $productKey) {    basic {      id      shopID      name      alias      price      priceCurrency      lastUpdatePrice      description      minOrder      maxOrder      status      weight      weightUnit      condition      url      sku      gtin      isKreasiLokal      isMustInsurance      isEligibleCOD      isLeasing      catalogID      needPrescription      __typename    }    category {      id      name      title      breadcrumbURL      isAdult      detail {        id        name        breadcrumbURL        __typename      }      __typename    }    pictures {      picID      fileName      filePath      description      isFromIG      width      height      urlOriginal      urlThumbnail      url300      status      __typename    }    preorder {      isActive      duration      timeUnit      __typename    }    wholesale {      minQty      price      __typename    }    videos {      source      url      __typename    }    campaign {      campaignID      campaignType      campaignTypeName      originalPrice      discountedPrice      isAppsOnly      isActive      percentageAmount      stock      originalStock      startDate      endDate      endDateUnix      appLinks      hideGimmick      __typename    }    stats {      countView      countReview      countTalk      rating      __typename    }    txStats {      txSuccess      txReject      itemSold      itemSoldPaymentVerified      __typename    }    cashback {      percentage      __typename    }    variant {      parentID      isVariant      __typename    }    stock {      useStock      value      stockWording      __typename    }    menu {      name      __typename    }    __typename  }}'
        ];

        return $gql;
    }
}
