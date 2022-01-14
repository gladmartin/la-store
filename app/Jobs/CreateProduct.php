<?php

namespace App\Jobs;

use App\Http\Services\ProductService;
use App\Lib\ScrapeMarketPlace\ScrapeMarketPlace;
use App\Models\Log;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Http\Request;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use stdClass;

class CreateProduct implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $url;
    protected $tambah;
    protected $persen;
    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($url, $tambah = 0, $persen = 0, User $user)
    {
        $this->url = $url;
        $this->tambah = $tambah;
        $this->persen = $persen;
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::create([
            'message' => 'Scrape produk dari url (' . $this->url . ')',
        ]);
        try {
            $product = (object) ScrapeMarketPlace::product($this->url, $this->persen, $this->tambah);
        } catch (\Throwable $th) {
            dump($this->url);
            dump($th->getMessage());
            return;
        }

        $varian = [];
        foreach ($product->variants as $item) {
            $item = (object) $item;
            $varian[] = [
                'key' => $item->name,
                'value' => $item->value,
                'stok' => $item->stock ?? 1,
                'harga_tambahan' => $item->price_add,
            ];
        }

        $request = new Request();
        $request->setMethod('POST');
        $request->request->add(['produk' => $product->name]);
        $request->request->add(['thumbnail' => $product->thumbnail]);
        $request->request->add(['galeri' => implode('|', $product->images)]);
        $request->request->add(['url_sumber' => $this->url]);
        $request->request->add(['kategori' => end($product->categories)]);
        $request->request->add(['deskripsi' => $product->description]);
        $request->request->add(['stok' => $product->stock]);
        $request->request->add(['harga' => $product->price]);
        $request->request->add(['varian' => $varian]);
        $request->request->add(['tambah' => $this->tambah]);
        $request->request->add(['persen' => $this->persen]);
        $request->request->add(['user_id' => $this->user->id]);

        try {
            ProductService::create($request);
        } catch (\Throwable $th) {
            dump($th->getMessage());
        }
    }
}
