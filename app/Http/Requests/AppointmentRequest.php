<?php

namespace App\Http\Requests;

use App\Rules\IsAfterNow;
use App\Rules\IsValidDate;
use Illuminate\Support\Arr;
use App\Rules\IsBusinessDay;
use Illuminate\Validation\Rule;
use App\Rules\IsDoctorOfficeDay;
use App\Rules\IsDoctorOfficeHour;
use App\Rules\IsLimitedMaximumAge;
use Illuminate\Support\Facades\App;
use App\Rules\IsNotDoctorAbsenceDay;
use App\Rules\IsDoctorSchedulingSlot;
use App\Services\Utilities\AppCarbon;
use App\Rules\IsDoctorFreeSchedulingSlot;
use Illuminate\Foundation\Http\FormRequest;

class AppointmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $doctor = $this->isMethod('post') ? $this->doctor : $this->appointment->doctor;

        $rules = [
            'first_name' => [
                'filled', 'max:50'
            ],
            'last_name' => [
                'filled', 'max:50'
            ],
            'birthday' => [
                'filled',
                new isValidDate,
                new IsLimitedMaximumAge,
            ],
            'app_date' => [
                'filled',
                new isValidDate,
                'after_or_equal:today',
            ],
            'app_time' => [
                'filled', 'date_format:H:i',
            ],
            'app_status' => [
                Rule::in(['completed', 'canceled', 'missed'])
            ],
        ];

        $rules = $this->addNew($rules, 'app_date', $this->dateRules($doctor, $this->app_date));

        $rules = $this->addNew($rules, 'app_time', $this->timeRules($doctor, $this->app_date, $this->app_time));

        return $rules;
    }

    /**
     * Add the new rules.
     *
     * @param array $rules
     * @param string $member
     * @param array $add
     */
    private function addNew($rules, $member, $add): array
    {
        $pulled = Arr::pull($rules, $member);
        $rules[$member] = array_merge($pulled, $add);

        return $rules;
    }

    /**
     * The rules for the appointment time.
     *
     * @param \App\Doctor $doctor
     * @param string $date
     * @param string $time
     */
    private function timeRules($doctor, $date, $time): array
    {
        return  App::make('app-carbon')->isValidTimeFormat($time) &&
            App::make('doctor-schedule')->setDoctor($doctor)->isValidOfficeDay($date)
            ? $this->newAppTimeRules($doctor, $date)
            :  [];
    }

    /**
     * Add appointment date rules.
     *
     * @param \App\Doctor $doctor
     * @param string $date
     */
    private function dateRules($doctor, $date): array
    {
        return App::make('app-carbon')->isValidDate($date)
            ? $this->newAppDateRules($doctor) : [];
    }

    /**
     * The appointment time rules.
     *
     * @param  \App\Doctor $doctor
     * @param  string $date
     */
    private function newAppTimeRules($doctor, $date): array
    {
        return [
            new IsAfterNow($date),
            new IsDoctorOfficeHour($doctor, $date),
            new IsDoctorSchedulingSlot($doctor, $date),
            new IsDoctorFreeSchedulingSlot($doctor, $date),
        ];
    }

    /**
     * The rules for the appointment date.
     *
     * @param  \App\Doctor $doctor
     */
    private function newAppDateRules($doctor): array
    {
        return [
            new IsBusinessDay,
            new IsDoctorOfficeDay($doctor),
            new IsNotDoctorAbsenceDay($doctor),
        ];
    }
}
