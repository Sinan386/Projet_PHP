<?php 
session_start();


// <?php session_destroy(); ?>

 $_SESSION[''] = '';
?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Navbar Responsive</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css"rel="stylesheet">
<link rel="stylesheet" href="style.css">
</head>
<body>
<header>
<nav class="navbar navbar-expand-sm navbar-dark navbar-custom fixed-top">
  <div class="container-fluid">
    <!--logo à gauche -->
    <a class="navbar-brand" href="#">
      <img src="/image/4.png"
           alt="Mon Logo"
           height="200"
           style="width:auto;">
    </a>

    <!-- Bouton burger : data-bs-target doit matcher l’ID ci-dessous -->
    <button class="navbar-toggler"
            type="button"
            data-bs-toggle="collapse"
            data-bs-target="#mainNav"
            aria-controls="mainNav"
            aria-expanded="false"
            aria-label="Basculer la navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Contenu collapsible -->
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav ms-auto">
        <!-- Liens simples -->
        <li class="nav-item">
          <a class="nav-link" href="#">Accueil</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="#">Contact</a>
        </li>

        <!-- Dropdown Boutique -->
        <li class="nav-item dropdown">
          <a class="nav-link dropdown-toggle"
             href="#"
             role="button"
             data-bs-toggle="dropdown"
             aria-expanded="false">
            Boutique
          </a>
          <ul class="dropdown-menu dropdown-menu-end">
            <li><a class="dropdown-item" href="#">Item N°1</a></li>
            <li><a class="dropdown-item" href="#">Item N°2</a></li>
            <li><a class="dropdown-item" href="#">Item N°3</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</header>
</nav>


