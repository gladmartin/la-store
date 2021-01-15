<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use phpDocumentor\Reflection\Location;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        // create admin user
        User::updateOrCreate([
            'email' => 'iamn34r@lastore.com',
        ], [
            'name' => 'Iamn34r',
            'role' => 'admin',
            'email_verified_at' => now(),
            'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        ]);

        $this->call([
            CategorySeeder::class,
            ProductSeeder::class,
            CourierSeeder::class,
            LocationSeeder::class,
        ]);
    }
}
