<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
use App\Post;
use Faker\Generator as Faker;

$factory->define(Post::class, function (Faker $faker) {
    return [
        //
        'user_id'=> factory(App\User::class),
        // 'user_id'=> App\User::all()->random(),
        'title'=>$faker->sentence,
        'body'=>$faker->paragraph,


    ]; 
});
