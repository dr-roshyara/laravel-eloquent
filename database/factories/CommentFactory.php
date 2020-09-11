<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Comment;
use Faker\Generator as Faker;

$factory->define(Comment::class, function (Faker $faker) {
    return [
        //
        // 'user_id'=> factory(App\User::class)->create(),
        // 'post_id'=> factory(App\Post::class)->create(),        
        'user_id'=> function(){return factory(App\User::class)->create()->id;},
        'post_id'=> function(){return factory(App\Post::class)->create()->id;},
        // 'user_id'=> App\User::all()->random(),
        'title'=>$faker->sentence,
        'body'=>$faker->paragraph,
    ];
});
