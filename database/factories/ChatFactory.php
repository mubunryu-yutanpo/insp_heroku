<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Chat;
use App\User;
use App\Idea;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Chat::class, function (Faker $faker) {
    return [
        'buyer_id' => function () {
            return factory(User::class)->create()->id;
        },
        'seller_id' => function () {
            return factory(User::class)->create()->id;
        },
        'idea_id' => function () {
            return factory(Idea::class)->create()->id;
        },
    ];
});
