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
     * Dado um intervalo em string, converte para uma array com os devidos formatos
     * para o banco de dados
     *
     * @param  string  $period
     * @param  string  $periodSeparator
     * @return array
     */
    function convert_date_interval($period, string $periodSeparator = '-')
    {
        return DateHelper::convertDateInterval($period, $periodSeparator);
    }
}
