<?php
// session_start(); 
require_once("my-functions.php");
require_once("catalog.php");
?>
<main>

<!-- <form action="cart.php" method="POST">-->
 <?php 

// $order = $_SESSION['order'] ?? [];
//   $qty = $order[$key] ?? 0;

// tous les produits affichés avec foreach
foreach ($products as $watch => $caract): ?>

  <div class="card">
    <h3><?= ($caract['name']) ?></h3>
    <p>Prix TTC : <?= formatPrice ($caract['price']); ?></p>
    <p>Prix HT :<?= formatPrice (priceExcludingVAT($caract['price'])); ?></p>
    
    </p> 
    
    <img
      src="<?= ($caract['image_url']) ?>"
      alt="<?= ($caract['name']) ?>">
    <div class="quantity">
        <input type="number" id="count" name="<?= $watch?>" style="width: 33%" value="0">
        <input type="submit" value='Commander'>
    </div>
  </div>


<?php endforeach; ?>
<!-- </form> -->
</main>

<!-- <div class="card"> 
    <h3><?= $product["watch"]["name"] ?></h3>
    <p>Prix : <?= $product["watch"] ['price'] ?></p>
    <img src="<?= $product["watch"]['picture_url'] ?>"
    alt="<?= $product["watch"]['picture_url'] ?>">
</div>
<div class="card">
    <h3><?= $product["watch2"]["name"] ?></h3>
    <p>Prix : <?= $product["watch2"] ['price'] ?></p>
    <img src="<?= $product["watch2"]['picture_url'] ?>"
    alt="<?= $product["watch2"]['picture_url'] ?>">
</div>
<div class="card">
    <h3><?= $product["watch3"]["name"] ?></h3>
    <p>Prix : <?= $product["watch3"] ['price'] ?></p>
    <img src="<?= $product["watch3"]['picture_url'] ?>"
    alt="<?= $product["watch3"]['picture_url'] ?>">
</div>
</div> -->