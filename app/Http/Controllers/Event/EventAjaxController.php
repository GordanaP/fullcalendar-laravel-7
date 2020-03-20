<?php

namespace App\Http\Controllers\Event;

use App\Event;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EventResource;

class EventAjaxController extends Controller
{
    public function index()
    {
        return EventResource::collection(Event::all());
    }
}
