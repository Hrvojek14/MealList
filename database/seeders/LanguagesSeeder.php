<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Languages;
use Faker\Factory as Faker;
use Carbon\Carbon;

class LanguagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        require_once 'vendor\fakerphp\faker\src\autoload.php';

        foreach(range(1, 400) as $v){
            $faker = Faker::create();

            Languages::insert([
                'lang' => $faker->languageCode(),
                'created_at' => Carbon::now()->toDateTimeString(),
            ]);
        }
    }
}
