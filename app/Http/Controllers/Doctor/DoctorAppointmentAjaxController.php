<?php

namespace App\Http\Controllers\Doctor;

use App\Doctor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\AppointmentResource;

class DoctorAppointmentAjaxController extends Controller
{
    public function index(Doctor $doctor)
    {
        return AppointmentResource::collection($doctor->appointments);
    }
}
