<?php
use Illuminate\Database\Seeder;


use Laracasts\TestDummy\Factory;
use App\Post;
use App\User;
class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UserSeeder::class);
        $this->call(PostSeeder::class);
    }
} 
