<?php

namespace App\Jobs;

use App\Lib\Wablas\WablasClient;
use App\Models\DeliveryDetail;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateOrderResi implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected $deliveryDetail;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(DeliveryDetail $deliveryDetail)
    {
        $this->deliveryDetail = $deliveryDetail;
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
        $wablas->addRecipient($this->deliveryDetail->delivery->order->no_wa);
        $namaToko = config('app.name');
        $teks = "*[$namaToko]*\n\n";
        $teks .= "Halo Kak *" . $this->deliveryDetail->delivery->order->nama . "*\n\n";
        $teks .= "Berikut informasi update resi orderan no invoice. *{$this->deliveryDetail->delivery->order->invoice}*\n\n";
        $teks .= "[{$this->deliveryDetail->created_at}] - {$this->deliveryDetail->keterangan}\n\n";
        $teks .= "Untuk melacak orderan kamu secara detail bisa kunjungi ke sini " . route('order.lacak', 'invoice=' . $this->deliveryDetail->delivery->order->invoice);
        $teks .= "\n\n*Terimakasih*";
        $result = $wablas->sendMessage($teks);
    }
}
