<?php

namespace App\Http\Controllers\Doctor;

use App\Doctor;
use App\Patient;
use App\Appointment;
use Illuminate\View\View;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DoctorPatientAppointmentController extends Controller
{
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
     */
    public function create(Doctor $doctor, Patient $patient): View
    {
        return view('appointments.index', compact('doctor', 'patient'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Doctor $doctor, Patient $patient)
    {
        $appointment = (new Appointment)->fill([
            'start_at' => $request->app_date . ' ' . $request->app_time,
            'status' => 'pending',
        ]);

        $appointment->patient()->associate($patient);

        $doctor->appointments()->save($appointment);

        // $appointment = $doctor->appointments()->create([
        //     'patient_id' => $patient->id,
        //     'start_at' => $request->app_date . ' ' . $request->app_time,
        //     'status' => 'pending',
        // ]);

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
