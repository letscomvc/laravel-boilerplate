<?php
/**
 * All files in this folder will be included in the application.
 */

/**
 * Separar os ítens de uma array por vírgula.
 *
 * @param array $array Array que será dividida.
 * @return string
 */
function separe_by_comma($array)
{
    return implode(', ', $array);
}

/**
 * Separar os ítens de uma array por vírgula.
 *
 * @param Date $date Date to format.
 * @param string $format Format.
 * @param string $from_format Origin format.
 * @return string
 */
function format_date($date, $format = 'd/m/Y', $from_format = null)
{
    if ($from_format != null) {
        $date = Carbon::createFromFormat($from_format, $date);
    } else {
        $date = \Carbon\Carbon::parse($date);
    }
    return $date->format($format);
}
