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
     * Transforma uma string de período em uma array separando-as e formatando
     * @param  string $period
     * @param  string $separator
     * @param  $fromFormat
     * @return array
     */
    public static function convertDateInterval($period, $separator = '-', $fromFormat = null)
    {
        if (!$fromFormat) {
            $fromFormat = format_of_date();
        }

        $dateInterval = explode($separator, $period);
        $dateInterval = array_map(function($date) use ($fromFormat) {
            return \Carbon\Carbon::createFromFormat($fromFormat, trim($date));
        }, $dateInterval);

        $dateInterval[0] = $dateInterval[0]->startOfDay();
        $dateInterval[1] = $dateInterval[1]->endOfDay();

        return $dateInterval;
    }

    public static function convertToFormat($date, $fromFormat = 'd/m/Y', $toFormat = 'Y-m-d')
    {
        $carbonDate = Carbon::createFromFormat($fromFormat, $date);
        return $carbonDate->format($toFormat);
    }
}
