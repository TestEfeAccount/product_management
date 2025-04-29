<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Provider;

class ProviderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $providers = [
            ['name' => 'Tea Provider'],
            ['name' => 'Shoe Provider'],
            ['name' => 'Electronics Provider'],
        ];

        foreach ($providers as $provider) {
            Provider::create($provider);
        }
    }
}
