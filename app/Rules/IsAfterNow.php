<?php

namespace App\Rules;

use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Validation\Rule;

class IsAfterNow implements Rule
{
    /**
     *Appointment date.
     *
     * @var string
     */
    public $app_date;

    /**
     * Create a new rule instance.
     *
     * @param  string $doctor
     */
    public function __construct($app_date)
    {
        $this->app_date = $app_date;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $dateTime = $this->app_date. ' ' . $value;

        return App::make('app-carbon')->parse($dateTime)->isFuture();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The appointment must be scheduled from now on.';
    }
}
