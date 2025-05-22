<?php

function formatPrice(int $centimes): string {
    $euros = $centimes / 100;
    // number_format(nombre, décimales, séparateur décimal, séparateur milliers)
    return number_format($euros, 2, ',', ' ') . ' €';
}



?>      