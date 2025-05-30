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
      <th>Remise (%)</th>
      <th>Prix en Promotion TTC</th>
    </tr>
    <?php foreach ($order as $key => $qty):
        // On récupère les informations du produit  
        $item =$product[$key];

        // On calcule le prix unitaire TTC, le total TTC, le prix unitaire HT et le total HT
        $unitTTC  = (int)$item['price']; // Prix unitaire TTC en centimes
        $unitPromoTTC = discountedPrice($unitTTC, $item['discount']); // Prix unitaire TTC après remise

        $totalTTC = $unitTTC * $qty; // Total TTC pour la quantité
        $totalPromoTTC = $unitPromoTTC * $qty; // Total TTC après remise pour la quantité

        // Prix unitaire HT 
        $unitHT   = priceExcludingVAT($unitTTC); // Prix unitaire HT en centimes
        $totalHT  = $unitHT * $qty; // Total HT pour la quantité
    ?>
      <tr>
        <td><?= htmlspecialchars($item['name']) ?></td>
        <td><?= $qty ?></td>
        <td><?= formatPrice($totalTTC) ?></td>
        <td><?= formatPrice($totalHT) ?></td>
        <td><?= $item['discount'] ?> %</td>  <!-- Affichage du pourcentage -->
        <td><?= formatPrice($totalPromoTTC) ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
<?php endif; ?>

</body>
</html>
