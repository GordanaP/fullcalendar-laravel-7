@extends('layouts.app')

@section('content')

    <table class="table">
        <tbody>
            @foreach ($doctors as $doctor)
                <tr>
                    <td>{{ $doctor->full_name }}</td>
                    <td>
                        <a href="{{ route('doctors.appointments.create', $doctor) }}">
                            Schedule
                        </a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
