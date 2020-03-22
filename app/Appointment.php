<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'start_at', 'status'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'start_at' => 'datetime'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'end_at', 'color', 'is_editable'
    ];

    /**
     * Get the appointment end time.
     */
    public function getEndAtAttribute(): string
    {
        return $this->start_at->addMinutes(30)->toDateTimeString();
    }

    /**
     * Get the appointment color.
     */
    public function getColorAttribute(): string
    {
        if($this->isCompleted()) {
            $color = '#68d391';
        } else if ($this->isCanceled()) {
            $color = '#fc8181';
        } else if ($this->isMissed()) {
            $color = '#cbd5e0';
        } else {
            $color = '#90cdf4';
        }

        return $color;
    }

    /**
     * Get the appointment editable attribute.
     */
    public function getIsEditableAttribute(): string
    {
        return ! $this->start_at->isPast() ? true : false;
    }

    /**
     * Determine if the appointment is completed.
     */
    public function isCompleted(): bool
    {
        return $this->status == 'completed';
    }

    /**
     * Determine if the appointment is canceled.
     */
    public function isCanceled(): bool
    {
        return $this->status == 'canceled';
    }

    /**
     * Determine if the appointment is missed.
     */
    public function isMissed(): bool
    {
        return $this->status == 'missed';
    }

    /**
     * Determine if the appointment is pending.
     */
    public function isPending(): bool
    {
        return $this->status == 'pending';
    }
}
