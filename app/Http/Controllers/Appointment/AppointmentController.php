<?php

namespace App\Http\Controllers\Appointment;

use App\Appointment;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Repositories\AppointmentRepository;

class AppointmentController extends Controller
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
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Appointment  $appointment
     */
    public function update(Request $request, Appointment $appointment): Response
    {
        $updated = $this->appointments->reschedule($appointment, $request->all());

        return response([
            'appointment' => $updated
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointment
     */
    public function destroy(Appointment $appointment = null): Response
    {
        if(! $appointment->start_at->isPast())
        {
            $this->appointments->delete($appointment);
        }

        return response([
            'message' => 'Deleted'
        ]);
    }
}
