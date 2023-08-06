<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Message;
use App\Chat;
use App\User;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Message::class, function (Faker $faker) {
    return [
        'chat_id' => function () {
            return factory(Chat::class)->create()->id;
        },
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'content' => $faker->paragraph,
    ];
});
