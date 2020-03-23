<?php

namespace App\Providers;

use App\Services\Utilities\Holidays;
use App\Services\Utilities\AppCarbon;
use Illuminate\Support\ServiceProvider;
use App\Services\Utilities\DoctorSchedule;
use App\Services\Utilities\BusinessSchedule;

class UtilityServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->instance('app-carbon', new AppCarbon);
        $this->app->instance('holidays', new Holidays);
        $this->app->instance('business-schedule', new BusinessSchedule);
        $this->app->instance('doctor-schedule', new DoctorSchedule);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
