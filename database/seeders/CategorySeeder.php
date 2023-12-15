<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Technology'],
            ['name' => 'Travel'],
            ['name' => 'Food'],
            ['name' => 'Health'],
            ['name' => 'Fashion'],
            ['name' => 'Sports'],
            ['name' => 'Science'],
            ['name' => 'Business'],
            ['name' => 'Entertainment'],
            ['name' => 'Education'],
        ];

        Category::insert($categories);
    }
}
