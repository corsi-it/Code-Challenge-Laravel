<?php

/**
 * This function rounds a number to given precision
 *
 * @param float $number
 * @param int $precision
 * @return float
 */
function roundNumber(float $number, int $precision = 2): float
{
    return round($number, $precision);
}


/**
 * This function returns total revenue in the second half of the month
 *
 * @param Collection $products
 * @return float
 */
function isFirstHalfDate(string $date): bool
{
    if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $date)) throw new \Exception('Invalid date format');
    $day = (int) explode('-', $date)[2];
    return $day <= 15;
}
