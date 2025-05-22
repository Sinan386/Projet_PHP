<?php

function formatPrice(float $centimes): string {
    $euros = $centimes / 100;
    // number_format(nombre, décimales, séparateur décimal, séparateur milliers)
    return number_format($euros, 2, ',', ' ') . ' €';
}
function priceExcludingVAT (float $ttc) {
    return $ttc /1.2;
}
function discountedPrice(int $ttc, float $discount) {
    return $ttc * (1 - $discount / 100); 
}
//  if ($discount <0 || $discount >100)  {  reduction compris entre 0 et 100
// j'ai éssaié de le mettre dans mon catalogue mais sa ne fonctionne pas
?>      
