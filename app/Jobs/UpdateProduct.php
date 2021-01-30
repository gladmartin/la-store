<?php

namespace App\Jobs;

use App\Lib\ScrapeMarketPlace\ScrapeMarketPlace;
use App\Models\Product;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class UpdateProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $product;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $persen = $this->product->metas->where('key', 'persen')->first()->value ?? 0;
        $tambahan = $this->product->metas->where('key', 'tambahan')->first()->value ?? 0;
        try {
            $scrape = (object) ScrapeMarketPlace::product($this->product->url_sumber, $persen, $tambahan);
        } catch (\Throwable $th) {
            return;
        }

       $this->product->update([
            'stok' => $scrape->stock,
            'harga' => $scrape->price,
        ]);
    }
}
