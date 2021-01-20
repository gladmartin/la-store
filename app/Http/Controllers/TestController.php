<?php

namespace App\Http\Controllers;

use App\Lib\Wablas\WablasClient;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class TestController extends Controller
{
    protected $order;

    public function wablas()
    {
        $this->order = Order::find(19);
        $apiToken = config('wablas.token');
        $wablas = new WablasClient($apiToken);
        $wablas->addRecipient('6282285365211');
        $namaToko = config('app.name');
        $totalTagihan =  number_format($this->order->delivery->ongkos_kirim + $this->order->bayar, 0, ',', '.');
        $teks = "*[$namaToko]*\n\n";
        $teks .= "Halo Kak *" . $this->order->nama . "*\n";
        $teks .= "Terimakasih telah order di toko kami\n\n";
        $teks .= "Berikut adalah detail orderan kamu\n";
        $teks .= "No Invoice: *" . $this->order->invoice ."*\n";
        $teks .= "Total tagihan: *Rp " . $totalTagihan ."*\n\n";
        $teks .= "Segera lakukan pembayaran ke salah nomor rekening berikut:\n";
        $teks .= "- Bank xxx no xxx A.N xxx\n\n";
        $teks .= "Jika sudah melakukan pembayaran silahkan luakukan konfirmasi di " . route('order.konfirmasi') . "\n\n";
        $teks .= "*Terimakasih*";
        $result = $wablas->sendMessage($teks);
    }

    public function random()
    {
        $this->shopId = 'bayerhealth';
        $this->itemId = 'momies-kit-lock-lock-silicone-strap-bottle-550-ml';
        $gql = [
            'operationName' => 'PDPInfoQuery',
            'variables' => [
                'shopDomain' => $this->shopId,
                'productKey' => $this->itemId,
            ],
            'query' => 'query PDPInfoQuery($shopDomain: String, $productKey: String) {  getPDPInfo(productID: 0, shopDomain: $shopDomain, productKey: $productKey) {    basic {      id      shopID      name      alias      price      priceCurrency      lastUpdatePrice      description      minOrder      maxOrder      status      weight      weightUnit      condition      url      sku      gtin      isKreasiLokal      isMustInsurance      isEligibleCOD      isLeasing      catalogID      needPrescription      __typename    }    category {      id      name      title      breadcrumbURL      isAdult      detail {        id        name        breadcrumbURL        __typename      }      __typename    }    pictures {      picID      fileName      filePath      description      isFromIG      width      height      urlOriginal      urlThumbnail      url300      status      __typename    }    preorder {      isActive      duration      timeUnit      __typename    }    wholesale {      minQty      price      __typename    }    videos {      source      url      __typename    }    campaign {      campaignID      campaignType      campaignTypeName      originalPrice      discountedPrice      isAppsOnly      isActive      percentageAmount      stock      originalStock      startDate      endDate      endDateUnix      appLinks      hideGimmick      __typename    }    stats {      countView      countReview      countTalk      rating      __typename    }    txStats {      txSuccess      txReject      itemSold      itemSoldPaymentVerified      __typename    }    cashback {      percentage      __typename    }    variant {      parentID      isVariant      __typename    }    stock {      useStock      value      stockWording      __typename    }    menu {      name      __typename    }    __typename  }}'
        ];

        $res = Http::post(config('lastore.proxy_shared_hoting'), $gql);

        dd($res->json());
    }
}
