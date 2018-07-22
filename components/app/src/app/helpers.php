<?php

if (!function_exists('format_float')){
    /**
     * Format price to standardize output data
     *
     * @param $item
     * @return float
     */
    function formatFloat($item)
    {
        return round( (float) $item, 2);
    }
}