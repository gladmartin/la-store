<?php

namespace App\Http\Controllers;

use App\Http\Requests\RajaOngkir\CostOngkir;
use App\Models\City;
use App\Models\Option;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RajaOngkirController extends Controller
{
    public function province()
    {
        $provinces = Province::all(['province_id', 'title']);

        return response()->json([
            'success' => true,
            'results' => $provinces,
        ]);
    }

    public function city(Request $request)
    {
        if (!$request->province_id) {
            return response()->json([
                'success' => false,
                'message' => 'Province id required',
            ], 402);
        }

        $cities = City::where('province_id', $request->province_id)->get();

        return response()->json([
            'success' => true,
            'results' => $cities,
        ]);

    }

    public function subdistrict(Request $request)
    {
        if (!$request->city_id) {
            return response()->json([
                'success' => false,
                'message' => 'City id required',
            ], 402);
        }

        // $rawResponse = Http::get("https://api.pvita.babaturan.net/kecamatan/{$request->city_id}");
        $rawResponse = Http::get('https://pro.rajaongkir.com/api/subdistrict', [
            'city' => $request->city_id,
            'key' => config('rajaongkir.api_key'),
        ]);

        $result = $rawResponse->json('rajaongkir.results');
        
        if (!$result || empty($result)) {
            return response()->json([
                'success' => false,
                'message' => 'Subdistrict not found',
            ], 404);
        }
        
        return response()->json([
            'success' => true,
            'results' => $result,
        ]);

    }

    public function ongkir(CostOngkir $request)
    {
        $kecamatanToko = Option::where('name', 'subdistrict')->first()->value ?? 1;
        // sementara pakai punya orang dulu.
        $raw = Http::get('https://api.pvita.babaturan.net/ongkir', [
            'dari' => $kecamatanToko,
            'ke' => $request->ke,
            'berat' => $request->berat == 0 ? 1 : $request->berat,
            'kurir' => 'jne,tiki,pos',
        ]);
        // $raw = Http::post('https://pro.rajaongkir.com/api/cost', [
        //     'origin' => $kecamatanToko,
        //     'originType' => 'subdistrict',
        //     'destination' => $request->ke,
        //     'destinationType' => 'subdistrict',
        //     'weight' => $request->berat == 0 ? 1 : $request->berat,
        //     'courier' => 'jne',
        //     'key' => config('rajaongkir.api_key')
        // ]);

        $result = $raw->json();
        // $result = $raw->json('rajaongkir.results');
        // dd($result);
        $ongkir = [];
        foreach ($result as $res) {
            if ($res == null) continue;
            if (empty($res[0]['costs'])) continue;
            $ongkir[] = $res[0];
        }
        
        if (empty($ongkir)) {
            return response()->json([
                'success' => false,
                'message' => 'Ongkir not found',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'results' => $ongkir,
        ]);
    }
}
