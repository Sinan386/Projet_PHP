<?php
require_once "my-functions.php";
require_once "catalog.php";

session_start();

// 1. Gestion du panier persistant
// Si un POST contient des quantités (clés correspondant à des produits), on remplit $order et on met à jour la session.
// Sinon, on récupère $order depuis la session (ou un tableau vide par défaut).
if (!empty($_POST)) {
    $order = [];
    foreach ($_POST as $key => $value) {
        if ($key === 'carrier') {
            continue;
        }
        $quantity = filter_var(
            $value,
            FILTER_VALIDATE_INT,
            ['options' => ['min_range' => 0]]
        );
        if ($quantity !== false && $quantity > 0 && isset($product[$key])) {
            $order[$key] = $quantity;
        }
    }
    $_SESSION['cart'] = $order;
} else {
    $order = $_SESSION['cart'] ?? [];
}

// 2. Calcul du poids total et montant TTC
$totalWeight = 0;
$totalTTC = 0;
foreach ($order as $key => $qty) {
    $unitTTC    = (int)$product[$key]['price'];
    $unitWeight = (int)$product[$key]['weight'];
    $totalTTC   += $unitTTC * $qty;
    $totalWeight += $unitWeight * $qty;
}

// 3. Lecture du transporteur (uniquement depuis POST)
$carrier = $_POST['carrier'] ?? '';
$shippingCost = 0;
if ($carrier === 'Chrono') {
    $shippingCost = shippingChrono($totalWeight, $totalTTC);
} elseif ($carrier === 'Poste') {
    $shippingCost = shippingPoste($totalWeight, $totalTTC);
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Mon Panier Persistant</title>
  <style>
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
    th { background: #f5f5f5; }
  </style>
</head>
<body>

<?php if (empty($order)): ?>
  <p><em>Aucun produit sélectionné.</em></p>
<?php else: ?>
  <table>
    <tr>
      <th>Produit</th>
      <th>Quantité</th>
      <th>Total TTC</th>
      <th>Total HT</th>
      <th>Remise (%)</th>
      <th>Prix en Promotion TTC</th>
    </tr>
    <?php foreach ($order as $key => $qty):
        $item         = $product[$key];
        $unitTTC      = (int)$item['price'];
        $unitPromoTTC = discountedPrice($unitTTC, $item['discount']);
        $totalTTCProd = $unitTTC * $qty;
        $totalPromo   = $unitPromoTTC * $qty;
        $unitHT       = priceExcludingVAT($unitTTC);
        $totalHTProd  = $unitHT * $qty;
    ?>
      <tr>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td><?= $qty ?></td>
        <td><?= formatPrice($totalTTCProd) ?></td>
        <td><?= formatPrice($totalHTProd) ?></td>
        <td><?= (int)$item['discount'] ?> %</td>
        <td><?= formatPrice($totalPromo) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <p>Poids total : <?= $totalWeight ?> g</p>
  <p>Frais de port pour <?= htmlspecialchars($carrier) ?> : <?= formatPrice($shippingCost) ?></p>
<?php endif; ?>

<form method="post" action="cart.php">
  <!-- Réinjection des quantités pour garder l'état du panier -->
  <?php foreach ($order as $key => $qty): ?>
    <input type="hidden" name="<?= htmlspecialchars($key) ?>" value="<?= $qty ?>">
  <?php endforeach; ?>

  <label for="carrier">Transporteur :</label>
  <select name="carrier" id="carrier" required>
    <option value="">-- Sélectionnez --</option>
    <option value="Chrono" <?= $carrier === 'Chrono' ? 'selected' : '' ?>>Chrono</option>
    <option value="Poste"  <?= $carrier === 'Poste'  ? 'selected' : '' ?>>La Poste</option>
  </select>

  <button type="submit">Mettre à jour les frais de port</button>
</form>

</body>
</html>
