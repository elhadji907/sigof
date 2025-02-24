<?php
if (!function_exists('remove_accents_uppercase')) {
    function remove_accents_uppercase($string) {
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        return mb_strtoupper($string, 'UTF-8');
    }
}
