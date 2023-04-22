<?php

if (!function_exists('unMaskPrice')) {

    function unMaskPrice($price) {
        return (double)str_replace(",", ".", str_replace(".", " ", $price));
    }
}
