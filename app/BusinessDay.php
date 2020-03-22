<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BusinessDay extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'day_iso', 'open', 'close'];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $dates = ['open', 'close'];

    /**
     * Find the business day by the iso index.
     *
     * @param  integer $iso
     */
    public static function findByIso($iso): BusinessDay
    {
        return static::where('iso', $iso)->firstOrFail();
    }
}
