<?php

namespace App\Lib\ScrapeMarketPlace\Web;

use App\Lib\ScrapeMarketPlace\Exception\MarketPlaceException;
use App\Lib\ScrapeMarketPlace\Exception\TokopediaException;
use App\Lib\ScrapeMarketPlace\Http\Request;
use App\Models\BlackList;
use Illuminate\Support\Str;

class Tokopedia
{

    private $gqlUrl = 'https://gql.tokopedia.com/';

    private $headersTokped = [];

    public function __construct($url)
    {
        if (substr($url, -1) == '/') {
            $url = substr($url, 0, -1);
        }
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

    public function singleProduct($persen = 0, $tambah = 0)
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

        // return $result;
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

        $price = $result->basic->price;
        if ($persen > 0) {
            $priceUp = $price * $persen / 100;
            $price = $price + $priceUp;
        }
        $price = $price + $tambah;

        $description = $result->basic->description ?? 'N/A';
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
            'name' => $result->basic->name,
            'categories' => $categories,
            'thumbnail' => $images[0],
            'images' => $images,
            'description' => $description,
            'stock' => $result->stock->value ?? 1,
            'weight' => $result->basic->weight ?? 100,
            'price' => $price,
            'variants' => $variants,
        ];

        return $returnData;
    }

    public function multipleProduct()
    {
        $ids = str_replace(['https://www.tokopedia.com/', 'https://tokopedia.com/'], '', $this->url);
        $ids = explode('/', $ids);
        $this->shopId = $ids[0];
        $this->etalase = $ids[2] ?? 'etalase';
        // remomve query string
        $this->page = (int) preg_replace('/\?.*/', '', $ids[3] ?? 1);

        $request = Request::post(config('lastore.proxy_shared_hoting'), [], $this->getGqlShopInfo());

        if ($request->failed()) throw new TokopediaException("Gagal mengambil info toko, response body " . $request->body());

        $result = json_decode($request->body());

        if (!isset($result->data) || !$result->data) throw new TokopediaException('Toko tidak ditemukan, response body ' . $request->body());

        $this->shopId = $result->data->shopInfoByID->result[0]->shopCore->shopID;

        // get list products
        $request = Request::post(config('lastore.proxy_shared_hoting'), [], $this->getGqlMultipleProduct());

        $result = json_decode($request->body());
        $result = $result->data->GetShopProduct->data;
        $products = [];
        foreach ($result as $item) {
            $products[] = [
                'item_id' => $item->product_id,
                'name' => $item->name,
                'api_url' => $item->product_url,
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

    private function getGqlShopInfo()
    {
        $gql = [
            'operationName' => 'ShopInfoCore',
            'variables' => [
                'id' => 0,
                'domain' => $this->shopId,
            ],
            'query' => 'query ShopInfoCore($id: Int!, $domain: String) {  shopInfoByID(input: {shopIDs: [$id], fields: ["active_product", "address", "allow_manage", "assets", "core", "closed_info", "create_info", "favorite", "location", "status", "is_open", "other-goldos", "shipment", "shopstats", "shop-snippet", "other-shiploc", "shopHomeType"], domain: $domain, source: "shoppage"}) {    result {      shopCore {        description        domain        shopID        name        tagLine        defaultSort        __typename      }      createInfo {        openSince        __typename      }      favoriteData {        totalFavorite        alreadyFavorited        __typename      }      activeProduct      shopAssets {        avatar        cover        __typename      }      location      isAllowManage      isOpen      address {        name        id        email        phone        area        districtName        __typename      }      shipmentInfo {        isAvailable        image        name        product {          isAvailable          productName          uiHidden          __typename        }        __typename      }      shippingLoc {        districtName        cityName        __typename      }      shopStats {        productSold        totalTxSuccess        totalShowcase        __typename      }      statusInfo {        shopStatus        statusMessage        statusTitle        __typename      }      closedInfo {        closedNote        until        reason        __typename      }      bbInfo {        bbName        bbDesc        bbNameEN        bbDescEN        __typename      }      goldOS {        isGold        isGoldBadge        isOfficial        badge        __typename      }      shopSnippetURL      customSEO {        title        description        bottomContent        __typename      }      __typename    }    error {      message      __typename    }    __typename  }}'
        ];

        return $gql;
    }

    private function getGqlMultipleProduct()
    {
        $gql = [
            'operationName' => 'ShopProducts',
            'variables' => [
                'sid' => $this->shopId,
                'page' => $this->page,
                'perPage' => 80,
                'keyword' => '',
                'etalaseId' => $this->etalase,
                'sort' => 1,
            ],
            'query' => 'query ShopProducts($sid: String!, $page: Int, $perPage: Int, $keyword: String, $etalaseId: String, $sort: Int) {  GetShopProduct(shopID: $sid, filter: {page: $page, perPage: $perPage, fkeyword: $keyword, fmenu: $etalaseId, sort: $sort}) {    status    errors    links {      prev      next      __typename    }    data {      name      product_url      product_id      price {        text_idr        __typename      }      primary_image {        original        thumbnail        resize300        __typename      }      flags {        isSold        isPreorder        isWholesale        isWishlist        __typename      }      campaign {        discounted_percentage        original_price_fmt        start_date        end_date        __typename      }      label {        color_hex        content        __typename      }      label_groups {        position        title        type        __typename      }      badge {        title        image_url        __typename      }      stats {        reviewCount        rating        __typename      }      category {        id        __typename      }      __typename    }    __typename  }}'
        ];

        return $gql;
    }
}
