@extends('layouts.app')

@section('content')

    <table class="table">
    <tbody>
        @foreach ($patients as $patient)
            <tr>
                <td>{{ $patient->full_name }}</td>
                <td>
                    {{ $patient->doctor->last_name }}
                    <a href="{{ route('doctors.appointments.index',
                        [$patient->doctor] + ['patient' => $patient->id]) }}">
                        Schedule
                    </a>
                </td>
            </tr>
        @endforeach
    </tbody>
    </table>
@endsection
