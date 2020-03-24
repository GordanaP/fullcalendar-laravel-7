<?php

use App\Doctor;
use Illuminate\Database\Seeder;

class AbsencesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $absences = [
            'vacation_leave', 'personal_leave', 'sick_leave',
            'family_and_medical_leave', 'sympathy_leave', 'jury_duty_leave',
            'military_leave', 'compensatory_time', 'unpaid_time_off'
        ];

        foreach ($absences as $absence) {
            factory('App\Absence')->create([
                'type' => $absence
            ]);
        }

        Doctor::first()->absences()->sync([
            1 => [
                'start_at' => '2020-04-21',
                'duration' => 8
            ],
            2 => [
                'start_at' => '2020-06-11',
                'duration' => 5
            ],
        ]);
    }
}
