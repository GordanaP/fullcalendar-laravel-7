<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Doctor;
use Carbon\Carbon;
use App\Appointment;
use Faker\Generator as Faker;

$factory->define(Appointment::class, function (Faker $faker) {
    return [
        'title' => $faker->word,
        'doctor_id' => Doctor::inRandomOrder()->first()->id,
        'start_at' => Carbon::today()
            ->addDays(rand(1,5))
            ->startOfHour()
            ->addHours(rand(9,15)),
    ];
});
