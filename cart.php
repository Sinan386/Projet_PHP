<?php 
require_once("my-functions.php");
require_once("catalog.php");

var_dump($_POST);
echo"<br><br>";

foreach($_POST as $key => $value) {
    echo"$key : $value<br>";
    var_dump($product[$key]);
    echo "<br>";
}
?>
  
<table border="1"> 
    <tr>
        <th>Produit</th>
        <th>Quantité</th>
        <th>Prix Total TTC</th>
        <th>Prix HT</th>
    </tr>

</table>



