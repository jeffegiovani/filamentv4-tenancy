<?php

namespace Database\Seeders;

use App\Models\ContactCategory;
use Illuminate\Database\Seeder;

class ContactCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ContactCategory::truncate();

        $data = [
            [
                'title' => 'Proprietário de Imóvel',
                'description' => null,
            ],
            [
                'title' => 'Locador de Imóvel',
                'description' => null,
            ],
            [
                'title' => 'Síndico',
                'description' => 'É sindico de condomínio(s) gerenciado(s) pela minha empresa',
            ]
        ];

        foreach ($data as $row) {
            ContactCategory::factory()->create($row);
        }
    }
}
