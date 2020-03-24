<?php

namespace App\Http\Controllers\Doctor;

use App\Doctor;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\AppointmentRepository;

class DoctorAppointmentController extends Controller
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
     * @param App\Doctor $doctor
     */
    public function index(Doctor $doctor): View
    {
        return view('appointments.index')->with([
            'doctor' => $doctor,
            'patient' => ''
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param App\Doctor $doctor
     */
    public function store(Request $request, Doctor $doctor): Response
    {
        $appointment = $this->appointments->schedule($request->all());

        return response([
            'appointment' => $appointment->load('patient')
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
