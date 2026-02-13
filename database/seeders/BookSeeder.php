<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Book;

class BookSeeder extends Seeder
{
    public function run(): void
    {
        $books = [
            [
                'category_id' => 1,
                'title' => 'Laskar Pelangi',
                'author' => 'Andrea Hirata',
                'isbn' => '9789793062792',
                'publisher' => 'Bentang Pustaka',
                'publication_year' => 2005,
                'stock' => 5,
                'description' => 'Novel tentang perjuangan anak-anak di Belitung'
            ],
            [
                'category_id' => 3,
                'title' => 'Clean Code',
                'author' => 'Robert C. Martin',
                'isbn' => '9780132350884',
                'publisher' => 'Prentice Hall',
                'publication_year' => 2008,
                'stock' => 3,
                'description' => 'Panduan menulis kode yang bersih dan maintainable'
            ],
            [
                'category_id' => 5,
                'title' => 'Sapiens',
                'author' => 'Yuval Noah Harari',
                'isbn' => '9780062316097',
                'publisher' => 'Harper',
                'publication_year' => 2015,
                'stock' => 4,
                'description' => 'Sejarah singkat umat manusia'
            ],
        ];

        foreach ($books as $book) {
            Book::create($book);
        }
    }
}