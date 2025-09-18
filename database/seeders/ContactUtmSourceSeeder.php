<?php

namespace Database\Seeders;

use App\Models\ContactUtmSource;
use Illuminate\Database\Seeder;

class ContactUtmSourceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactUtmSource::truncate();

        $data = [
            [
                'title' => 'Cadastro Manual',
                'is_active' => true,
            ],
            [
                'title' => 'Blogs',
                'is_active' => true,
            ],
            [
                'title' => 'Publicidade',
                'is_active' => true,
            ]
        ];

        foreach ($data as $row) {
            ContactUtmSource::factory()->create($row);
        }
    }
}
