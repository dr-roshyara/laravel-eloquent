<?php

use Illuminate\Database\Seeder;
use Laracasts\TestDummy\Factory;
use App\Post;
class PostSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        // Factory::times(3)->create('Post');
            factory('App\Post', 10)->create();
        // Factory::times(50)->create('App\Post');
    }
}
 