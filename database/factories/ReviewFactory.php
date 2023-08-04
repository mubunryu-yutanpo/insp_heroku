<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Review;
use App\User;
use App\Idea;
use Faker\Generator as Faker;

$factory->define(Review::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'idea_id' => function () {
            return factory(Idea::class)->create()->id;
        },
        'comment' => $faker->paragraph,
        'score' => $faker->numberBetween(1, 5),
    ];
});
