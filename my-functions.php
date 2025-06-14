<?php
// Formate un prix (centime => euros) : "1 000, 56€"
function formatPrice(float $centimes): string {
    $euros = $centimes / 100;
    // number_format(nombre, décimales, séparateur décimal, séparateur milliers)
    return number_format($euros, 2, ',', ' ') . ' €';
}
/**
 * Calcule le prix remisé (TTC) en centimes.
 *
 * @param int $ttcCentimes Prix TTC en centimes
 * @param int $discount    Pourcentage de remise (0–100)
 * @return int             Prix après remise en centimes
 */


// function priceExcludingVAT (float $ttc) {
//     return $ttc /1.2;
// }
function priceExcludingVAT(int $ttcCentimes): int {
    return (int) round($ttcCentimes / 1.2);
}

 /**
 * Calcule le prix HT à partir du TTC (TVA 20%) en centimes.
 *
 * @param int $ttcCentimes Prix TTC en centimes
 * @param float $discount    Pourcentage de remise (0–100)
 * @return int             Prix HT en centimes
 */

function discountedPrice(int $ttcCentimes, float $discount): int {
    // Sécurisation de la remise
    if ($discount < 0 || $discount > 100) {
        throw new InvalidArgumentException('Promotion comprise entre 0 et 100');
    }
    // Calcul et arrondi
    return (int) round($ttcCentimes * (1 - $discount / 100));
}
/**
 * Calcule le prix remisé (TTC) en centimes.
 *
 * @param int $ttcCentimes Prix TTC en centimes
 * @param int $discount    Pourcentage de remise (0–100)
 * @return int             Prix après remise en centimes
 */
 
// function discountedPrice(int $ttc, float $discount) {
//     return $ttc * (1 - $discount / 100); 
// }
//  if ($discount <0 || $discount >100)  {  reduction compris entre 0 et 100
// j'ai éssaié de le mettre dans mon catalogue mais sa ne fonctionne pas

function shippingChrono(int $weight, int $totalTTC): int {
    if ($weight <= 500) {
        return 500;                   // 5 € en centimes
    }
    if ($weight <= 2000) {
        return (int) round($totalTTC * 0.10);
    }
    return 0;
}

// Exemple d'un second transporteur, mêmes barèmes (peut différer si besoin)
function shippingPoste(int $weight, int $totalTTC): int {
    if ($weight <= 500) {
        return 500;
    }
    if ($weight <= 2000) {
        return (int) round($totalTTC * 0.10);
    }
    return 0;
}

// fonction qui vide le panier
function emptyCart() {
    // soit on supprime la clé…
    unset($_SESSION['order']);
    // …soit on la réinitialise vide
    // $_SESSION['order'] = [];
}
?>      
