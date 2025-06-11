<?php require_once("header.php"); 
require_once("database.php");


 require_once("multidimensional-catalog.php"); 
 require_once("my-functions.php"); 
//  require_once("catalog-with-keys.php"); 
 $sqlQuery = ('SELECT * FROM products');
 $produits = $mysqlClient -> prepare($sqlQuery);
 $produits -> execute();
 $products = $produits -> fetchAll(mode: PDO::FETCH_ASSOC); 
var_dump($products) ;

 require_once("footer.php"); ?>





