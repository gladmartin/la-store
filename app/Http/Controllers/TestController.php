<?php

namespace App\Http\Controllers;

use App\Lib\Wablas\WablasClient;
use App\Models\Order;
use Illuminate\Http\Request;

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
}
