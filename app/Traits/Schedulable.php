<?php

namespace App\Traits;

use App\Patient;
use App\Appointment;

trait Schedulable
{
    /**
     * Update the past appointment.
     *
     * @param  \App\Appointment $appointment
     * @param  array $data
     */
    protected function updatePast($appointment, $data): Appointment
    {
        return tap($appointment)->update([
            'status' => $data['app_status'],
        ]);
    }

    /**
     * Update the pending appointment.
     *
     * @param  \App\Appointment $appointment
     * @param  array $data
     */
    protected function updatePending($appointment, $data): Appointment
    {
        return tap($appointment)->update([
             'start_at' => $data['app_date'] . ' '. $data['app_time'],
         ]);
    }

    /**
     * Associate the appointment with the patient.
     *
     * @param  array $data
     */
    protected function appointment($data, $patient = null): Appointment
    {
        $schedulingPatient = $patient ?? $this->doctor->addPatient($data);

        $appointment = $this->appointmentFromForm($data);

        $appointment->patient()->associate($schedulingPatient);

        return $appointment;
    }

    /**
     * The appointment from form.
     *
     * @param  array $data
     */
    protected function appointmentFromForm($data): Appointment
    {
        return (new $this->model)->fill([
            'start_at' => $data['app_date'] . ' ' . $data['app_time'],
            'status' => 'pending',
        ]);
    }
}
