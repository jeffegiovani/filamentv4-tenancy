<?php

namespace Database\Seeders;

use App\Models\RealEstate;
use Database\Factories\RealEstateFactory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class RealEstateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // RealEstate::truncate();
        $data = [
            [
                'city_id' => 1,
                'real_estate_center_id' => 1,
                'name' => 'Imobiliária 1A',
                'slug' => null,
                'address' => fake()->address(),
            ],
            [
                'city_id' => 1,
                'real_estate_center_id' => 1,
                'name' => 'Imobiliária 2B',
                'slug' => null,
                'address' => fake()->address(),
            ],
            [
                'city_id' => 1,
                'real_estate_center_id' => 1,
                'name' => 'Imobiliária 3C',
                'slug' => null,
                'address' => fake()->address(),
            ],
            [
                'city_id' => 1,
                'real_estate_center_id' => 1,
                'name' => 'Imobiliária 4D',
                'slug' => null,
                'address' => fake()->address(),
            ],
        ];

        foreach ($data as $row) {
            // $row['name'] = Str::of($row['name'])
            //     ->squish();

            $row['slug'] = Str::of($row['name'])
                ->replace('/', ' ')
                ->slug('-', 'pt_BR')
                .
                uniqid();

            RealEstate::factory()->create($row);
        }

        // Sync de usuários com algumas imobiliárias
        (RealEstate::query()->find(1))
            ->users()
            ->sync([1, 2, 3]);
        (RealEstate::query()->find(2))
            ->users()
            ->sync([1, 2]);
        (RealEstate::query()->find(4))
            ->users()
            ->sync([1]);

        // Randomic Items
        $totalRowsForIterate = config('options.fake.real_estates') ?? 10;
        $total = RealEstate::count('id');

        for ($i = 0; $i <= $totalRowsForIterate; $i++) {
            RealEstateFactory::new()
                ->create();
        }
    }
}
