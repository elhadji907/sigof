<?php
if (!function_exists('remove_accents_uppercase')) {
    function remove_accents_uppercase($string) {
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);
        return mb_strtoupper($string, 'UTF-8');
    }
}

if (!function_exists('format_proper_name')) {
    function format_proper_name($string) {
        // Supprimer les accents
        $string = iconv('UTF-8', 'ASCII//TRANSLIT', $string);

        // Mettre en majuscule la première lettre de chaque mot
        return ucwords(strtolower($string));
    }
}

