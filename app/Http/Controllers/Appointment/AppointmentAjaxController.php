<?php

namespace App\Http\Controllers\Appointment;

use App\Appointment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;

class AppointmentAjaxController extends Controller
{
    public function index()
    {
        return AppointmentResource::collection(Appointment::all());
    }
}
