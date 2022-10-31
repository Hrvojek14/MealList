<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Ingredients;
use App\Models\IngredientTranslation;
use App\Helpers\SeederHelper;
use Faker\Factory as Faker;
use Carbon\Carbon;

class IngredientsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require_once 'vendor\fakerphp\faker\src\autoload.php';
        
        $langs = SeederHelper::getLanguages();
        $num_langs = count($langs);

        foreach(range(1, 20) as $v){
            $faker = Faker::create();

            Ingredients::insert([
                'slug' => 'ingredient-'.$v,
                'created_at' => Carbon::now()->toDateTimeString(),
            ]);
            foreach($langs as $lang){
                IngredientTranslation::insert([
                    'title' => $faker->word(),
                    'slug' => 'ingredient-'.$v,
                    'locale' => $lang->lang,
                ]);
            }
        }
    }
}
