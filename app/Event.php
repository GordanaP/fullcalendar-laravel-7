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
        'end_at'
    ];

    /**
     * Get the event end time.
     */
    public function getEndAtAttribute(): string
    {
        return $this->start_at->addMinutes(30)->toDateTimeString();
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
