<?php
/**
 * All files in this folder will be included in the application.
 */

use App\Support\DateHelper;

if (! function_exists('format_of_date')) {
    /**
     * Retorna o formato corrente de 'date'
     *
     * @return string
     */
    function format_of_date()
    {
        return DateHelper::getDateFormat();
    }
}

if (! function_exists('format_of_datetime')) {
    /**
     * Retorna o formato corrente de 'datetime'
     *
     * @return string
     */
    function format_of_datetime()
    {
        return DateHelper::getDateTimeFormat();
    }
}

if (! function_exists('generate_date_range')) {
    /**
     * Dado uma data inicial e uma final, retorna todos os dias entre elas
     * @param  Carbon $start_date Data inicial
     * @param  Carbon $end_date   Data final
     * @return array
     */
    function generate_date_range(\Carbon\Carbon $start_date, \Carbon\Carbon $end_date)
    {
        return DateHelper::generateDateRange($start_date, $end_date);
    }
}

if (!function_exists('convert_date_interval')) {
    /**
     * Transforma uma string de período em uma array separando-as e formatando
     * @param  string $period
     * @param  string $separator
     * @param  $fromFormat
     * @return array
     */
    function convert_date_interval($period, $separator = '-', $fromFormat = null)
    {
        return DateHelper::convertDateInterval($period, $separator, $fromFormat);
    }
}
