<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'start_at', 'outcome'
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
     * Get the event end time.
     */
    public function getEndAtAttribute(): string
    {
        return $this->start_at->addMinutes(30)->toDateTimeString();
    }

    // public function getRenderingAttribute()
    // {
    //     return $this->start_at->isPast() ? 'background' : '';
    // }

    /**
     * Get the event color.
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
     * Get the event editable attribute.
     */
    public function getIsEditableAttribute(): string
    {
        return ! $this->start_at->isPast() ? true : false;
    }

    /**
     * Determine if the event is completed.
     */
    public function isCompleted(): bool
    {
        return $this->outcome == 'completed';
    }

    /**
     * Determine if the event is canceled.
     */
    public function isCanceled(): bool
    {
        return $this->outcome == 'canceled';
    }

    /**
     * Determine if the event is missed.
     */
    public function isMissed(): bool
    {
        return $this->outcome == 'missed';
    }

    /**
     * Determine if the event is pending.
     */
    public function isPending(): bool
    {
        return $this->outcome == 'pending';
    }
}
