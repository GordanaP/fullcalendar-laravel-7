<?php

namespace App\Rules;

use Illuminate\Support\Facades\App;
use Illuminate\Contracts\Validation\Rule;

class IsLimitedMaximumAge implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
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
        $app_carbon = App::make('app-carbon');

        if ($app_carbon->isValidDate($value)) {

            $age = $app_carbon->parse($value)->age;

            return $age <= 110;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The age can be 110 years maximum';
    }
}
