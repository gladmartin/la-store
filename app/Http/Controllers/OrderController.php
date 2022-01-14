<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\MakeOrder;
use App\Http\Requests\Order\StoreKonfirmasiBayar;
use App\Jobs\OrderCreated;
use App\Models\City;
use App\Models\Delivery;
use App\Models\Meta;
use App\Models\Order;
use App\Models\Post;
use App\Models\Product;
use App\Models\Province;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class OrderController extends Controller
{
    public function store(MakeOrder $request)
    {
        $invoice = date('ymd') . random_int(111111, 999999);
        $product = Product::find($request->product_id);
        if (!$product->stok > $request->kuantitas) {
            return response()->json([
                'success' => false,
                'message' => 'Kuantitas tidak cukup, stok tersedia ' . $request->stok,
            ], 402);
        }

        $rajaongkir = Http::get('https://pro.rajaongkir.com/api/subdistrict', [
            'key' => config('rajaongkir.api_key'),
            'city' => $request->kota,
            'id' => $request->kecamatan,
        ]);
        $rajaongkir = (object) $rajaongkir->json('rajaongkir.results');

        if (empty($rajaongkir)) {
            return response()->json([
                'success' => false,
                'message' => 'Data kecamatan tidak ditemukan!',
            ], 402);
        }

        $bayar = $product->harga * $request->kuantitas;
        $variants = null;
        if ($request->variants) {
            $variants = Variant::select('id', 'key', 'value')->where('product_id', $request->product_id)->whereIn('id', $request->variants)->get();
        }
        if ($variants && !empty($variants)) {
            foreach ($variants as $item) {
                if ($item->harga_tambahan && $item->harga_tambahan > 0) {
                    $bayar += $item->harga_tambahan;
                }
            }
        }

        $alamat = "Provinsi {$rajaongkir->province}, Kota/Kabupaten {$rajaongkir->city}, Kecamatan {$rajaongkir->subdistrict_name}. Alamat lengkap " . $request->alamat;
        $order = Order::create([
            'invoice' => $invoice,
            'product_id' => $request->product_id,
            'alamat' => $alamat,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_wa' => $request->no_wa,
            'variants' => json_encode($variants),
            'kuantitas' => $request->kuantitas,
            'bayar' => $bayar,
            'status_order' => 'PENDING',
            'status_pembayaran' => 'BELUM DIBAYAR',
        ]);

        if ($request->catatan) {
            $order->metas()->create([
                'key' => 'catatan',
                'value' => $request->catatan,
            ]);
        }

        $order->metas()->create([
            'key' => 'kecamatan',
            'value' => $request->kecamatan
        ]);

        $order->metas()->create([
            'key' => 'provinsi',
            'value' => $request->provinsi
        ]);

        $order->metas()->create([
            'key' => 'provinsi',
            'value' => $request->provinsi
        ]);

        // create deleivery
        Delivery::create([
            'order_id' => $order->id,
            'ongkos_kirim' => $request->ongkos_kirim,
            'ekspedisi' => $request->ekspedisi,
            'service' => $request->service,
        ]);

        OrderCreated::dispatch($order);

        return response()->json([
            'success' => true,
            '__next' => route('order.sukses', $order->invoice),
            'results' => [
                'invoice' => $order,
            ],
        ]);
    }

    public function konfirmasiBayar()
    {
        $banks = Post::where('type', 'akun_bank')->get();

        // dd($banks);

        return view('site.order.konfirmasi-bayar', compact('banks'));
    }

    public function storeKonfirmasiBayar(StoreKonfirmasiBayar $request)
    {
        $order = Order::where('invoice', $request->invoice)->first();

        if (!$order) {
            return redirect()->back()->with('info', 'No invoice yang kamu masukkan tidak ditemukan')->withInput();
        }

        if ($order->status_order == 'SEDANG DIKIRIM') {
            return redirect()->back()->with('info', 'Orderan anda sedang dalam perjalanan!')->withInput();
        }

        if ($request->nominal < $order->bayar) {
            return redirect()->back()->with('info', 'Nominal bayar yang kamu transfer tidak sesaui dengan jumlah tagihan ' . rupiah($order->bayar))->withInput();
        }

        $meta = [
            'key' => 'user_konfirmasi_order',
            'value' => json_encode([
                'nama_pengirim' => $request->nama_pengirim,
                'bank_pengirim' => $request->bank_pengirim,
                'bank_tujuan' => $request->bank_tujuan,
                'nominal' => $request->nominal,
            ])
        ];

        $order->metas()->updateOrCreate([
            'metaable_id' => $order->id,
            'metaable_type' => Order::class
        ], $meta);

        $order->update([
            'status_pembayaran' => 'MENUNGGU KONFIRMASI',
        ]);

        return redirect()->back()->with('info', 'Terimakasih, orderan anda akan segera kami proses.')->withInput();
    }

    public function lacak()
    {
        return view('site.order.lacak');
    }

    public function sukses(string $invoiceId)
    {
        $order = Order::where('invoice', $invoiceId)->firstOrFail();
        $banks = Post::where('type', 'akun_bank')->get();

        return view('site.order.sukses', compact('order', 'banks'));
    }

    public function lacakJson($invoice)
    {
        $order = Order::where('invoice', $invoice)->where('status_order', 'SEDANG DIKIRIM')->with('delivery')->first();

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'Data resi tidak ditemukan, status orderan kamu belum dikrim',
            ]);
        }

        return response()->json([
            'success' => true,
            'data' => $order->delivery->details,
        ]);
    }
}
