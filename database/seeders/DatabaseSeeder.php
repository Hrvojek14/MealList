<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            LanguagesSeeder::class,
            TagsSeeder::class,
            CategoriesSeeder::class,
            IngredientsSeeder::class,
            MealsSeeder::class,
        ]);
    }
}
