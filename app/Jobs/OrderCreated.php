<?php

namespace App\Jobs;

use App\Lib\Wablas\WablasClient;
use App\Models\Order;
use App\Models\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderCreated implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $order;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $apiToken = config('wablas.token');
        $wablas = new WablasClient($apiToken);
        $wablas->addRecipient($this->order->no_wa);
        $namaToko = config('app.name');
        $totalTagihan =  number_format($this->order->delivery->ongkos_kirim + $this->order->bayar, 0, ',', '.');
        $banks = Post::where('type', 'akun_bank')->get();
        $listBank = '';
        foreach ($banks as $item) {
            $bank = $item->metas->where('key', 'bank')->first()->value;
            $noRek = $item->metas->where('key', 'no_rek')->first()->value;
            $atasNama = $item->metas->where('key', 'atas_nama')->first()->value;
            $listBank .= '- Bank ' . $bank . ' *' . $noRek . '* a.n *' . $atasNama . "* \n";
        }
        $teks = "*[$namaToko]*\n\n";
        $teks .= "Halo Kak *" . $this->order->nama . "*\n";
        $teks .= "Terimakasih telah order di toko kami\n\n";
        $teks .= "Berikut adalah detail orderan kamu\n";
        $teks .= "No Invoice: *" . $this->order->invoice ."*\n";
        $teks .= "Total tagihan: *Rp " . $totalTagihan ."*\n\n";
        $teks .= "Segera lakukan pembayaran ke salah satu nomor rekening berikut:\n\n";
        $teks .= $listBank . "\n";
        $teks .= "Jika sudah melakukan pembayaran silahkan lakukan konfirmasi di " . route('order.konfirmasi', ['invoice=' . $this->order->invoice]) . "\n\n";
        $teks .= "Untuk melihat detail orderan anda kunjungi link berikut " . route('order.sukses', $this->order->invoice);
        $teks .= "\n\n *Terimakasih*";
        $result = $wablas->sendMessage($teks);
        // dump($result);
    }
}
