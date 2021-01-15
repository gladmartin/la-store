<?php

namespace App\Http\Controllers;

use App\Http\Requests\Order\MakeOrder;
use App\Jobs\OrderCreated;
use App\Models\Delivery;
use App\Models\Order;
use App\Models\Product;
use App\Models\Variant;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function store(MakeOrder $request)
    {
        $invoice = date('ymd') . random_int(11111111111, 99999999999);
        $product = Product::find($request->product_id);
        if (!$product->stok > $request->kuantitas) {
            return response()->json([
                'success' => false,
                'message' => 'Kuantitas tidak cukup, stok tersedia ' . $request->stok,
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
        $alamat = 'Alamat lengkap ' . $request->alamat;
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
        return view('site.order.konfirmasi-bayar');
    }

    public function lacak()
    {
        return view('site.order.lacak');
    }

    public function sukses(string $invoiceId)
    {
        $order = Order::where('invoice', $invoiceId)->firstOrFail();

        return view('site.order.sukses', compact('order'));
    }
}
