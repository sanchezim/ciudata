<?php

use Illuminate\Support\Str;

if (!function_exists('helper_to_array_camel')) {
    function helper_to_array_camel(array $array): array
    {
        $newArray = [];
        foreach ($array as $key => $value) {
            $newArray[Str::snake($key)] = $value;
        }
        return $newArray;
    }
}

if (!function_exists('helper_random_string')) {
    function helper_random_string(int $length = 4): string
    {
        return Str::random($length);
    }
}
