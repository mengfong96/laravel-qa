<?php

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
        factory(App\User::class, 3)->create()->each(function($u){ // create --> create record and store in database
            $u->questions()
            ->saveMany(
                factory(App\Question::class, rand(1,10))->make() //make --> generate object and store in memory only
            ); //method come from User::class model
        });
    }
}
