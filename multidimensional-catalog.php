<?php 
$product = [
    "watch" => [
        "name"=> "Breguet Classique Tourbillon Extra-Plat 5377",
        "price"=> "208800",
        "weight"=> "200",
        "discount"=> "5",
        "picture_url"=> "https://www.edouardgenton.com/image/catalog/Breguet/montre-breguet-5377-5377pt-12-9wu.jpg",
    ],
    "watch2"=> [
        "name"=> "Audemars Piguet Royal Oak Selfwinding 15500ST",
        "price"=> "30000",
        "weight"=> "142",
        "discount"=> "10",
        "picture_url"=> "https://dynamicmedia.audemarspiguet.com/is/image/audemarspiguet/watch-598?size=568,0&dpr=off&fmt=avif-alpha&dpr=off",    
    ],
    "watch3"=> [
    "name"=> "Grand Seiko ",
    "price"=> "2500",
    "weight"=> "134",
    "discount"=> "30",
    "picture_url"=> "image/Grand_Seiko_SBGW231.png",    
    ],
];
?>
<main>
<div class="card"> <!-- Affichage des montres une par une -->
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
</div>
</main>

