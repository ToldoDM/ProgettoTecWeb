<?php
    require_once __DIR__ . "/setterTemplate.php";

    $setterPagina = new setterTemplate("..");

    $setterPagina->setTitle("Aggiungi Articolo | The Darksoulers");
    $setterPagina->setDescription("Pagina iniziale del sito The Darksoulers");  

    $setterPagina->setNavBar(file_get_contents(__DIR__ . "/contents/home-nav.php"));

    $setterPagina->setPercorso("Utente");
    
    $setterPagina->setContent("newArticoloContent.php");
    $setterPagina->setFooter();

    $setterPagina->validate();
?>