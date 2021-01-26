<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\OrderClose;
use App\Jobs\OrderKonfirmasi;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.order.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order)
    {
        return view('admin.order.detail', compact('order'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $order)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $order)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Order  $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('order.index')->with('info', 'Data orderan berhasil dihapus');
    }

    public function konfirmasiBayar(Order $order)
    {
        $order->status_order = 'SEDANG DIKIRIM';
        $order->status_pembayaran = 'LUNAS';
        $order->save();
        
        OrderKonfirmasi::dispatch($order);

        return redirect()->back()->with('info', 'Status pembayaran berhasil diubah');
    }

    public function sampai(Order $order)
    {
        $order->status_order = 'ORDER TERKIRIM';
        $order->status_pembayaran = 'LUNAS';
        $order->save();

        OrderClose::dispatch($order);

        return redirect()->back()->with('info', 'Orderan telah terkirim!');
    }
}
