<?php

namespace App\Jobs;

use App\Lib\Wablas\WablasClient;
use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class OrderKonfirmasi implements ShouldQueue
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
        $wablas = new WablasClient();
        $wablas->addRecipient($this->order->no_wa);
        $namaToko = config('app.name');
        $totalTagihan =  number_format($this->order->delivery->ongkos_kirim + $this->order->bayar, 0, ',', '.');
        $teks = "*[$namaToko]*\n\n";
        $teks .= "Halo Kak *" . $this->order->nama . "*\n";
        $teks .= "Pesanan dengan No. invoice *{$this->order->invoice}* sudah kami konfirmasi dan akan segera dikirim 🤩\n";
        $teks .= "Mohon tunggu informasi selanjutnya ya.\n\n";
        $teks .= "*Terimakasih*";
        $result = $wablas->sendMessage($teks);
    }
}
