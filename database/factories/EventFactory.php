<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Event;
use Carbon\Carbon;
use Faker\Generator as Faker;

$factory->define(Event::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'start' => $start = Carbon::today()->addDays(rand(1,5))->startOfHour()->addHours(rand(9,15)),
    ];
});
