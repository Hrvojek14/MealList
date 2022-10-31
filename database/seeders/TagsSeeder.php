<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Tags;
use App\Models\TagTranslation;
use App\Helpers\SeederHelper;
use Faker\Factory as Faker;
use Carbon\Carbon;

class TagsSeeder extends Seeder
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

            Tags::insert([
                'slug' => 'tag-'.$v,
                'created_at' => Carbon::now()->toDateTimeString(),
            ]);
            foreach($langs as $lang){
                TagTranslation::insert([
                    'title' => $faker->word(),
                    'slug' => 'tag-'.$v,
                    'locale' => $lang->lang,
                ]);
            }
        }
    }
}
