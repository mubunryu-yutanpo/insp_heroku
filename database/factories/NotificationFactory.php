<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Notification;
use App\User;
use App\Chat;
use App\Idea;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

$factory->define(Notification::class, function (Faker $faker) {
    return [
        'receiver_id' => function () {
            return factory(User::class)->create()->id;
        },
        'sender_id' => function () {
            return factory(User::class)->create()->id;
        },
        'chat_id' => function () {
            return factory(Chat::class)->create()->id;
        },
        'idea_id' => function () {
            return factory(Idea::class)->create()->id;
        },
        'read' => false,
        'content' => $faker->sentence,
    ];
});
