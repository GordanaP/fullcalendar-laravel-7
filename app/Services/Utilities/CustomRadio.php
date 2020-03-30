<?php

namespace App\Services\Utilities;

class CustomRadio
{
    /**
     * The radio input name.
     *
     * @var string
     */
    public $name;

    /**
     * The radio input values.
     *
     * @var array
     */
    public $inputs = [];

    /**
     * Get the radio values.
     */
    public function values(): array
    {
        return array_values($this->inputs);
    }

    /**
     * Get the radio key for a specific value.
     *
     * @param  string $value
     */
    public function key($value): string
    {
        return array_search($value, $this->inputs);
    }
}