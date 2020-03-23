<?php

use App\Doctor;
use Illuminate\Database\Seeder;

class DoctorsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Doctor', 2)->create();

        Doctor::first()->business_days()->sync([
            1 => [
                'start_at' => '10:00',
                'end_at' => '20:00'
            ],
            2 => [
                'start_at' => '10:00',
                'end_at' => '14:00'
            ],
            5 => [
                'start_at' => '12:00',
                'end_at' => '16:00'
            ],
        ]);
    }
}
