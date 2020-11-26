<?php

namespace App\Support;

class NumberHelper
{
    public static function format(
        $number,
        int $decimalPlaces = 2,
        string $decimalPoint = ',',
        string $thousandsSeparator = '.'
    ): string {
        return number_format($number, $decimalPlaces, $decimalPoint, $thousandsSeparator);
    }

    public static function toFloat(
        string $maskedNumber,
        string $currentDecimalPoint = ',',
        string $currentThousandsSeparator = '.'
    ): float {
        if ($currentDecimalPoint === $currentThousandsSeparator) {
            $message = 'Decimal point separator and thousand separator cannot be equals';
            throw new \InvalidArgumentException($message);
        }

        $formattedNumber = str_replace(
            [$currentThousandsSeparator, $currentDecimalPoint],
            ['', '.'],
            $maskedNumber
        );

        if (!is_numeric($formattedNumber)) {
            throw new \InvalidArgumentException("The param [$maskedNumber] is not a valid number.");
        }

        return floatval($formattedNumber);
    }
}
