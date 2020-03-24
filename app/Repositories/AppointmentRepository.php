<?php

namespace App\Repositories;

use App\Doctor;
use App\Appointment;
use App\Traits\Schedulable;
use App\Services\Utilities\DeleteModel;
use Illuminate\Support\Facades\Request;

class AppointmentRepository extends DeleteModel
{
    use Schedulable;

    /**
     * The doctor
     *
     * @var integer
     */
    private $doctor;

    /**
     * Create a new repository instance.
     */
    public function __construct()
    {
        $this->model = Appointment::class;
        $this->doctor = Doctor::find(Request::route('doctor'));
    }

    /**
     * Schedule an appointment.
     *
     * @param  array $data
     */
    public function schedule($data, $patient = null): Appointment
    {
        $appointment = $this->appointment($data, $patient);

        $this->doctor->addAppointment($appointment);

        return $appointment;
    }

    /**
     * Reschedule the appointment.
     *
     * @param App\Appointment $appointment
     * @param  array $data
     */
    public function reschedule($appointment, $data): Appointment
    {
        return $appointment->start_at->isPast()
            ? $this->updatePast($appointment, $data)
            : $this->updatePending($appointment, $data);
    }
}
