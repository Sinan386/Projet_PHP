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

<img
    
