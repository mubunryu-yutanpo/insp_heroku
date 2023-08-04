<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\Idea;
use App\Category;
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(App\Idea::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(App\User::class)->create()->id;
        },
        'category_id' => function () {
            return factory(App\Category::class)->create()->id;
        },
        'title' => $faker->sentence,
        'thumbnail' => '/uploads/thumbnail-default.png',
        'summary' => $faker->sentence,
        'description' => $faker->paragraph,
        'price' => $faker->numberBetween(100, 10000), // 100から1000のランダムな数値
    ];
});