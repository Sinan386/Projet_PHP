<?php
session_start();

require_once "my-functions.php";
require_once "catalog.php";
require_once "header.php";

// Debug ( facultatif )
// var_dump($_POST);
// echo "<br><br>";

// On parcourt $_POST qui est une super global pour récupérer et valider les quantités envoyées
if ($_SERVER['REQUEST_METHOD'] === 'POST') { //Si on arrive par le formulaire, on met à jour la session

if(isset($_POST['empty_cart'])) { // Si on a cliqué sur le bouton "Vider le panier"
    emptycart(); // On vide le panier
}
else {
  $order = []; // Je crée un tableau qui stockera, pour chaque produit, la quantité validé.
foreach ($_POST as $key => $value) { // $key reçoit watch1,2 etc.. value le nombre de montre
    $quantity = filter_var( // fonction Filtre pour s'assurer que la valeur est un entier >= 0
        $value,
        FILTER_VALIDATE_INT, // Filtre INT
        ['options' => ['min_range' => 0]] // on s'assure qu'on ne recup jamais un entier négatif
    ); // Si l'entier est valide, strictement positif, et que le produit existe...
    echo "if";
    if ($quantity !== false && $quantity > 0 && isset($product[$key])) { // vérifie que le filtre à renvoyé un INT, au moins 1 unité, Isset vérifie que la clé existe dans le tableau $product
        $order[$key] = $quantity;
        echo "test";

    }
}
$_SESSION['order'] = $order;
echo "1234";
var_dump($_SESSION);
}
}
echo "1234";
var_dump($_SESSION);

$order = $_SESSION['order'] ?? []; //  On relit  le panier en session
// Calcul du poids total et montant TTC
$totalWeight =  0;
$totalTTC = 0;
foreach ($order as $key => $qty) {
  $unitTTC = (int)$product[$key]['price'];
  $unitWeight = (int)$product[$key]['weight'];
  $totalTTC += $unitTTC * $qty;
  $totalWeight += $unitWeight* $qty;
  
}
$carrier      = $_POST['carrier'] ?? '';
$shippingCost = 0;
if ($carrier === 'Chronopost') {
    $shippingCost = shippingChrono($totalWeight, $totalTTC);
} elseif ($carrier === 'La Poste') {
    $shippingCost = shippingPoste($totalWeight, $totalTTC);
}
?>
  <style>
    table { border-collapse: collapse; width: 100%; }
    th, td { border: 1px solid #ccc; padding: 8px; text-align: center; }
    th { background: #C19A6B;; }
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
        $item         = $product[$key]; // On récupère les informations du produit  
        $unitTTC      = (int)$item['price']; // Prix unitaire TTC
        $unitPromoTTC = discountedPrice($unitTTC, $item['discount']); // Prix unitaire TTC après remise
        $totalTTCProd = $unitTTC * $qty;
        $totalPromo   = $unitPromoTTC * $qty;
        $unitHT       = priceExcludingVAT($unitTTC); // Prix unitaire HT en centimes
        $totalHTProd  = $unitHT * $qty;

    ?>
      <tr>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td><?= $qty ?></td>

        <td><?= formatPrice($totalTTCProd) ?></td>
        <td><?= formatPrice($totalHTProd) ?></td>
        <td><?= (int)$item['discount'] ?> %</td> <!-- Affichage du pourcentage -->
        <td><?= formatPrice($totalPromo) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>

  <p>Poids total <?= $totalWeight ?> g</p>
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
    <option value="Chronopost" <?= $carrier === 'Chronopost' ? 'selected' : '' ?>>Chronopost</option>
    <option value="La Poste"  <?= $carrier === 'La Poste'  ? 'selected' : '' ?>>La Poste</option>
  </select>

  <button type="submit">Mettre à jour les frais de port</button>
</form>

    <!-- Bouton Vider le panier -->
<form method="post" action="cart.php" style="display:inline">
  <?php // on peut réinjecter les quantités mais emptyCart() les supprimera ?>
  <button name="empty_cart" value="1" class="btn btn-danger" onclick="return confirm('Vider le panier ?')">
    Vider le panier
  </button>
</body>
</html>
