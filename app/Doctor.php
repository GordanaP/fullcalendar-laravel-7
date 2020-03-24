<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Doctor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'color', 'app_slot'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = ['full_name'];

    /**
     * The doctor's full name.
     */
    public function getFullNameAttribute(): string
    {
        return $this->first_name . ' ' . $this->last_name;
    }

    /**
     * The doctors' absences.
     */
    public function absences(): BelongsToMany
    {
        return $this->belongsToMany(Absence::class)
            ->as('day')
            ->withPivot('start_at', 'duration');
    }

    /**
     * The doctors' business days.
     */
    public function business_days(): BelongsToMany
    {
        return $this->belongsToMany(BusinessDay::class)
            ->as('hour')
            ->withPivot('start_at', 'end_at');
    }

    /**
     * The doctor's appointments.
     */
    public function appointments(): HasMany
    {
        return $this->hasMany(Appointment::class);
    }

    /**
     * The doctor's patients.
     */
    public function patients(): HasMany
    {
        return $this->hasMany(Patient::class);
    }

    /**
     * Add new patient.
     *
     * @param array $data
     */
    public function addPatient($data): Patient
    {
        return $this->patients()->create($data);
    }

    /**
     * Add new appointment.
     *
     * @param \App\Appointment $appointment
     */
    public function addAppointment($appointment): Appointment
    {
        return $this->appointments()->save($appointment);
    }
}
