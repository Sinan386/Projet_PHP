<?php
$watch = [
    "name" => "Breguet No. 1176",
    "price"=> "100000€",
    "weight"=> "200",
    "discount"=> "5",
    "picture_url"=> "https://monochrome-watches.com/wp-content/uploads/2018/05/Breguet-Tourbillon-pocket-watch-No-1176-1.jpg",
];
?>
<div>
    <h3><?= $watch['name'] ?></h3>
    <p>Prix : <?= $watch['price'] ?></p>
    <img src="<?= $watch['picture_url'] ?>"
    alt="<?= $watch['picture_url'] ?>">
</div>

<?php 

$products = [ $watch ];

// avec foreach
foreach ($products as $item): ?>
  <div class="product">
    <h3><?= ($item['name']) ?></h3>
    <p>Prix : <?= ($item['price']) ?></p>
    <img
      src="<?= ($item['picture_url']) ?>"
      alt="<?= ($item['name']) ?>"
    >
  </div>
<?php endforeach; ?>

<!-- // avec do while -->
<?php

$i = 0;
do {
    $item = $products[$i];
    ?>
    <div class="product">
      <h3><?= ($item['name']) ?></h3>
      <p>Prix : <?= ($item['price']) ?></p>
      <img
        src="<?= ($item['picture_url']) ?>"
        alt="<?= ($item['name']) ?>"
      >
    </div>
    <?php
    $i++;
} while ($i < count($products));
?>

<!-- avec For -->
<?php
for ($i = 0; $i < count($products); $i++) {
    $item = $products[$i];
    ?>
    <div class="product">
      <h3><?= ($item['name']) ?></h3>
      <p>Prix : <?= ($item['price']) ?></p>
      <img
        src="<?= ($item['picture_url']) ?>"
        alt="<?= ($item['name']) ?>"
      >
    </div>
    <?php
}
?>
 <!-- avec While -->
<?php
$i = 0;
while ($i < count($products)) {
    $item = $products[$i];
    ?>
    <div class="product">
      <h3><?= ($item['name']) ?></h3>
      <p>Prix : <?= ($item['price']) ?></p>
      <img
        src="<?= ($item['picture_url']) ?>"
        alt="<?= ($item['name']) ?>"
      >
    </div>
    <?php
    $i++;
}
?>
