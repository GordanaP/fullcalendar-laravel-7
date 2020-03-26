<?php

namespace App\Http\Controllers\Doctor;

use App\Doctor;
use App\Patient;
use App\Appointment;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AppointmentRequest;
use App\Repositories\AppointmentRepository;

class DoctorPatientAppointmentController extends Controller
{
    /**
     * The appointments.
     *
     * @var \App\Repositories\AppointmentRepository
     */
    private $appointments;

    /**
     * Create a new class instance.
     *
     * @param \App\Repositories\AppointmentRepository $appointments
     */
    public function __construct(AppointmentRepository $appointments)
    {
        $this->appointments = $appointments;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param App\Doctor $doctor
     * @param App\Patient $patient
     */
    public function create(Doctor $doctor, Patient $patient): View
    {
        return view('appointments.index', compact('doctor', 'patient'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param App\Doctor $doctor
     * @param App\Patient $patient
     */
    public function store(AppointmentRequest $request, Doctor $doctor, Patient $patient)
    {
        $appointment = $this->appointments->schedule($request->all(), $patient);

        return response([
            'appointment' => $appointment
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function show(Doctor $doctor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function edit(Doctor $doctor)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Doctor $doctor)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Doctor  $doctor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Doctor $doctor)
    {
        //
    }
}
