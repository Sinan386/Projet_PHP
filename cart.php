<?php
session_start();
require_once "my-functions.php";
require_once "catalog.php";

// Debug ( facultatif )
// var_dump($_POST);
// echo "<br><br>";

// On parcourt $_POST qui est une super global pour récupérer et valider les quantités envoyées
$order = []; // Je crée un tableau qui stockera, pour chaque produit, la quantité validé.
foreach ($_POST as $key => $value) { // $key reçoit watch1,2 etc.. value le nombre de montre
    $quantity = filter_var( // fonction Filtre pour s'assurer que la valeur est un entier >= 0
        $value,
        FILTER_VALIDATE_INT, // Filtre INT
        ['options' => ['min_range' => 0]] // on s'assure qu'on ne recup jamais un entier négatif
    ); // Si l'entier est valide, strictement positif, et que le produit existe...
    if ($quantity !== false && $quantity > 0 && isset($product[$key])) { // vérifie que le filtre à renvoyé un INT, au moins 1 unité, Isset vérifie que la clé existe dans le tableau $product
        $order[$key] = $quantity;
    }
}
// Calcul du poids total et montant TTC
$totalWeight =  0;
$totalTTC = 0;
foreach ($order as $key => qty) {
  $unitTTC = (int)$product[$key]['price'];
  $unitWeight = (int)$product[$key]['weight'];
  $totalWeight += $unitTTC * $unitWeight;
  $totalTTC += $unitWeight * $unitWeight;
}
?>
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
    </tr>
    <?php foreach ($order as $key => $qty): 
        $unitTTC  = (int)$product[$key]['price'];
        $totalTTC = $unitTTC * $qty;
        $unitHT   = priceExcludingVAT($unitTTC);
        $totalHT  = $unitHT * $qty;
    ?>
      <tr>
        <td><?= htmlspecialchars($product[$key]['name']) ?></td>
        <td><?= $qty ?></td>
        <td><?= formatPrice($totalTTC) ?></td>
        <td><?= formatPrice($totalHT) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>

</body>
</html>
