<?php

// function getPDO() = PDO; {

try {


$mysqlClient = new PDO("mysql:host=localhost;dbname=boutique;charset=utf8","boutique","motdepasse");

}
catch (Exception $e)
{
   die('Erreur : '. $e->getMessage()); 
}


$sqlQuery = ('SELECT * FROM products');
$produits = $mysqlClient -> prepare($sqlQuery);
$produits -> execute();
$products = $produits -> fetchAll(mode: PDO::FETCH_ASSOC); 


?>