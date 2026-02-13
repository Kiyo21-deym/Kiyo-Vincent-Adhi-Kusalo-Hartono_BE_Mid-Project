<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            ['name' => 'Fiksi', 'description' => 'Buku-buku fiksi dan novel'],
            ['name' => 'Non-Fiksi', 'description' => 'Buku pengetahuan umum'],
            ['name' => 'Teknologi', 'description' => 'Buku tentang teknologi dan komputer'],
            ['name' => 'Sejarah', 'description' => 'Buku sejarah dan biografi'],
            ['name' => 'Sains', 'description' => 'Buku sains dan penelitian'],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }
    }
}