<?php

namespace App\Http\Controllers\Appointment;

use App\Appointment;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AppointmentController extends Controller
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
        $appointment = Appointment::create([
            'title' => $request->app_title,
            'start_at' => $request->app_date . ' '. $request->app_time,
            'status' => 'pending',
        ]);

        return response([
            'appointment' => $appointment
        ]);
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
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Appointment $appointment)
    {
        $updated = $this->updated($appointment);

        return response([
            'appointment' => $updated
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Appointment  $appointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Appointment $appointment)
    {
        if(! $appointment->start_at->isPast())
        {
            $appointment->delete();
        }

        return response([
            'message' => 'Deleted'
        ]);
    }

    private function updated($appointment)
    {
        if($appointment->start_at->isPast()) {
            return tap($appointment)->update([
                'status' => request('app_status'),
            ]);
        } else {
            return tap($appointment)->update([
                'start_at' => request('app_date') . ' '. request('app_time'),
            ]);
        }
    }
}

