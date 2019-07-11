<?php

use Faker\Generator as Faker;
use Carbon\Carbon;

$factory->define(App\Models\Concert::class, function (Faker $faker) {
    return [
        'title' => $faker->title,
        'subtitle' => $faker->sentence(3),
        'date' => now()->toDateString(),
        'ticket_price' => $faker->numberBetween(100, 5000),
        'venue' => $faker->sentence(3),
        'venue_address' => $faker->streetAddress,
        'city' => $faker->city,
        'state' => $faker->state,
        'zip' => $faker->postcode,
        'additional_information' => $faker->phoneNumber,
    ];
});

$factory->state(App\Models\Concert::class, 'published', function ($faker) {
    return [
        'published_at' => Carbon::parse('-1 week'),
    ];
});


$factory->state(App\Models\Concert::class, 'unpublished', function ($faker) {
    return [
        'published_at' => null
    ];
});