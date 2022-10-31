<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Meals;
use App\Models\MealCategory;
use App\Models\MealTag;
use App\Models\MealIngredient;
use App\Models\MealTranslation;
use App\Helpers\SeederHelper;
use Faker\Factory as Faker;
use Carbon\Carbon;

class MealsSeeder extends Seeder
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
            $num_categories = $faker->numberBetween(0, 5);
            $slug = 'meal-'.$v;
            
            Meals::insert([
                'slug' => $slug,
                'created_at' => Carbon::now()->toDateTimeString(),
            ]);
            foreach($langs as $lang){
                MealTranslation::insert([
                    'title' => $faker->word(),
                    'description' => $faker->word(),
                    'slug' => 'meal-'.$v,
                    'locale' => $lang->lang,
                ]);
            }

            if($num_categories > 0){
                for($i=0; $i<$num_categories; $i++){
                    MealCategory::insert([
                        'meal_slug' => $slug,
                        'category_slug' => 'category-'.$faker->numberBetween(1, 20),
                    ]);
                }
            }
            
            $num_tags = $faker->numberBetween(1, 5);
            for($i=0; $i<$num_tags; $i++){
                MealTag::insert([
                    'meal_slug' => $slug,
                    'tag_slug' => 'tag-'.$faker->numberBetween(1, 20),
                ]);
            }

            $num_igredients = $faker->numberBetween(1, 5);
            for($i=0; $i<$num_igredients; $i++){
                MealIngredient::insert([
                    'meal_slug' => $slug,
                    'ingredient_slug' => 'ingredient-'.$faker->numberBetween(1, 20),
                ]);
            }

        }
    }
}
