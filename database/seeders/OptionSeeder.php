<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Option::updateOrCreate(
            [
                'name' => 'site_title',
            ],
            [
                'value' => 'LaStore'
            ]
        );

        Option::updateOrCreate(
            [
                'name' => 'site_description',
            ],
            [
                'value' => 'Belanja jadi makin mudah'
            ]
        );

        Option::updateOrCreate(
            [
                'name' => 'site_default_color',
            ],
            [
                'value' => 'red'
            ]
        );

        Option::updateOrCreate(
            [
                'name' => 'navbar_color',
            ],
            [
                'value' => 'red'
            ]
        );

        Option::updateOrCreate(
            [
                'name' => 'phone',
            ],
            [
                'value' => '0822121212'
            ]
        );

        Option::updateOrCreate(
            [
                'name' => 'email',
            ],
            [
                'value' => '0822121212'
            ]
        );

        Option::updateOrCreate(
            [
                'name' => 'address',
            ],
            [
                'value' => '-'
            ]
        );

        Option::updateOrCreate(
            [
                'name' => 'province',
            ],
            [
                'value' => '1'
            ]
        );

        Option::updateOrCreate(
            [
                'name' => 'city',
            ],
            [
                'value' => '17'
            ]
        );

        Option::updateOrCreate(
            [
                'name' => 'subdistrict',
            ],
            [
                'value' => '258'
            ]
        );
    }
}
