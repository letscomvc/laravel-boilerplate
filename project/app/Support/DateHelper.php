<?php

namespace App\Support;

use Carbon\Carbon;

class DateHelper
{
    /**
    * Retorna o formato atual para o tipo 'date'.
    *
    * @return string
    */
    public static function getDateFormat()
    {
        return __('dates.php.dateFormat');
    }

    /**
    * Retorna o formato atual para o tipo 'datetime'.
    *
    * @return string
    */
    public static function getDateTimeFormat()
    {
        return __('dates.php.dateTimeFormat');
    }

    /**
     * Dado uma data inicial e uma final, retorna todos os dias entre elas
     * @param  Carbon $startDate Data inicial
     * @param  Carbon $end_date   Data final
     * @return array
     */
    public static function generateDateRange(Carbon $startDate, Carbon $endDate)
    {
        if ($startDate->gt($endDate)) {
            list($startDate, $endDate) = [$endDate, $startDate];
        }

        for ($date = $startDate; $date->lte($endDate); $date->addDay()) {
            $dates[] = clone $date;
        }
        return $dates ?? [];
    }

     /**
     * Dado um intervalo em string, converte para uma array com os devidos formatos
     *  para o banco de dados
     *
     * @param  string  $period
     * @param  string  $periodSeparator
     * @return array
     */
    public static function convertDateInterval(string $period, string $periodSeparator = '-')
    {
        $dateInterval = explode($periodSeparator, $period);

        if (sizeof($dateInterval) > 2) {
            throw new \RuntimeException("Invalid period [{$period}]");
        }

        $dateInterval[0] = static::formatDate(
            trim($dateInterval[0]),
            'Y-m-d 00:00:00',
            static::getDateFormat()
        );

        $dateInterval[1] = static::formatDate(
            trim($dateInterval[1] ?? $period),
            'Y-m-d 23:59:59',
            static::getDateFormat()
        );

        return $dateInterval;
    }

    public static function convertToFormat($date, $fromFormat = 'd/m/Y', $toFormat = 'Y-m-d')
    {
        $carbonDate = Carbon::createFromFormat($fromFormat, $date);
        return $carbonDate->format($toFormat);
    }
}
