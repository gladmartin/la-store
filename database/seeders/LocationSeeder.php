<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Province;
use Illuminate\Database\Seeder;
use Kavist\RajaOngkir\Facades\RajaOngkir;

class LocationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		$provinces = file_get_contents(__DIR__ . '/../dump/provinces.json');
		$cities = file_get_contents(__DIR__ . '/../dump/cities.json');
		$provinces = json_decode($provinces, true);
		$cities = json_decode($cities, true);
		Province::insert($provinces);
		City::insert($cities);

    }
}
