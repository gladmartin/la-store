<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\UpdateOrderResi;
use App\Models\Delivery;
use App\Models\DeliveryDetail;
use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.delivery.index');
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
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function show(Delivery $delivery)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function edit(Delivery $delivery)
    {
        $deliveryDetail = $delivery->details;

        return view('admin.delivery.edit', compact('delivery', 'deliveryDetail'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Delivery $delivery)
    {
        $delivery->update([
            'no_resi' => $request->resi,
        ]);

        return redirect()->back()->with('info', 'No resi berhasil diupdate');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Delivery  $delivery
     * @return \Illuminate\Http\Response
     */
    public function destroy(Delivery $delivery)
    {
        //
    }

    public function storeDetail(Request $request, Delivery $delivery)
    {
        $request->validate([
            'keterangan' => 'required',
        ]);

        
        
        $deliveryDetail =  DeliveryDetail::create([
            'delivery_id' => $delivery->id,
            'keterangan' => $request->keterangan,
        ]);

        // dd($deliveryDetail);

        UpdateOrderResi::dispatch($deliveryDetail);

        return redirect()->back()->with('info', 'Detail pengantaran berhasil ditambah');
    }

    public function deleteDetail(Request $request, DeliveryDetail $deliveryDetail)
    {
        $deliveryDetail->delete();

        return redirect()->back()->with('info', 'Detail pengantaran berhasil dihapus');
    }
}
