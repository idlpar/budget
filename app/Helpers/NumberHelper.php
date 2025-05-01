<?php

namespace App\Helpers;

class NumberHelper
{
    /**
     * Format a number in Bangladeshi/Indian numbering style
     *
     * @param float|int|string $number The number to format
     * @param int $decimalPlaces Number of decimal places to show (default: 2)
     * @param bool $showZeroDecimals Whether to show .00 for whole numbers (default: false)
     * @return string Formatted number in Bangladeshi/Indian style
     */
    public static function bdNumber($number, $decimalPlaces = 2, $showZeroDecimals = false)
    {
        // Convert to float and handle invalid numbers
        $number = (float)$number;
        if (!is_numeric($number)) {
            return $number; // Return original if not numeric
        }

        // Split into integer and decimal parts
        $parts = explode('.', (string)$number);
        $integerPart = $parts[0];
        $decimalPart = isset($parts[1]) ? substr($parts[1], 0, $decimalPlaces) : '';

        // Format the integer part with Bangladeshi/Indian numbering system
        $lastThree = substr($integerPart, -3);
        $otherNumbers = substr($integerPart, 0, -3);

        if ($otherNumbers != '') {
            $lastThree = ',' . $lastThree;
        }

        $formattedInteger = preg_replace("/\B(?=(\d{2})+(?!\d))/", ",", $otherNumbers) . $lastThree;

        // Handle decimal part
        $formattedNumber = $formattedInteger;
        if (!empty($decimalPart)) {
            $formattedNumber .= '.' . $decimalPart;
        } elseif ($showZeroDecimals && $decimalPlaces > 0) {
            $formattedNumber .= '.' . str_repeat('0', $decimalPlaces);
        }

        return $formattedNumber;
    }
}
