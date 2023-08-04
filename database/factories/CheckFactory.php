<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Check;
use App\User;
use App\Idea;
use Faker\Generator as Faker;

$factory->define(Check::class, function (Faker $faker) {
    return [
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'idea_id' => function () {
            return factory(Idea::class)->create()->id;
        },
    ];
});
