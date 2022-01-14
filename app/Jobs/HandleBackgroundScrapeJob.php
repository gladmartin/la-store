<?php

namespace App\Jobs;

use App\Lib\ScrapeMarketPlace\ScrapeMarketPlace;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandleBackgroundScrapeJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $data;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($data, $user)
    {
        $this->data = $data;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $urls = explode("\n", $this->data->url_mp);

        foreach ($urls as $url) {
            $url = trim($url);
            try {
                if (isset($this->data->is_toko)) {
                    try {
                        $products = ScrapeMarketPlace::products($url);
                    } catch (\Throwable $th) {
                    }
                    foreach ($products as $product) {
                        $product = (object) $product;
                        CreateProduct::dispatch($product->api_url, $this->data->tambah, $this->data->persen, $this->user);
                    }
                } else {
                    CreateProduct::dispatch($url, $this->data->tambah, $this->data->persen, $this->user);
                }
            } catch (\Throwable $th) {
                // dump($url);
                // dump($th->getMessage());
                // dump('Gagal');
            }
        }
    }
}
