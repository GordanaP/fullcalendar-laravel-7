<?php


/**
 * Get the checked value.
 *
 * @param  string $value_1
 * @param  string $value_2
 */
function checked($value_1, $value_2): string
{
    return $value_1 == $value_2 ? 'checked' : '';
}

/**
 * Get the selected value.
 *
 * @param  string $value_1
 * @param  string $value_2
 */
function getSelected($value_1, $value_2): string
{
    return $value_1 == $value_2 ? 'selected' : '';
}

/**
 * Get the active value.
 *
 * @param  string $value_1
 * @param  string $value_2
 */
function active($value1, $value2): string
{
    return $value1 == $value2 ? 'active' : '';
}
