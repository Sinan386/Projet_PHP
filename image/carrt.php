<?php
session_start();
require_once "my-functions.php";
require_once "catalog.php";

// 1) Validation du panier ($_POST → $order)
$order = [];
foreach ($_POST as $key => $value) {
    if ($key === 'carrier') continue;
    $quantity = filter_var($value, FILTER_VALIDATE_INT, ['options' => ['min_range' => 0]]);
    if ($quantity !== false && $quantity > 0 && isset($product[$key])) {
        $order[$key] = $quantity;
    }
}

// 2) Calcul poids total et montant total TTC
$totalWeight = 0;
$totalTTC    = 0;
foreach ($order as $key => $qty) {
    $unitTTC     = (int)$product[$key]['price'];
    $unitWeight  = (int)$product[$key]['weight'];
    $totalTTC   += $unitTTC * $qty;
    $totalWeight += $unitWeight * $qty;
}

// 3) Calcul des frais de port
$carrier      = $_POST['carrier'] ?? '';
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
  <title>Mon Panier</title>
  <style>
    table { border-collapse: collapse; width: 100%; margin-bottom: 20px; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
    th { background: #f5f5f5; }
    form { margin-top: 20px; }
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

  <p>Poids total du colis : <?= $totalWeight ?> g</p>
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

  <button type="submit">Mettre à jour les frais</button>
</form>

</body>
</html>
