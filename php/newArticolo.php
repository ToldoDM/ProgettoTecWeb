<?php
    require_once __DIR__ . "/setterTemplate.php";
    require_once __DIR__ . '/utente-class.php';

    session_start();

    $setterPagina = new setterTemplate("..");

    $setterPagina->setTitle("Aggiungi Articolo | The Darksoulers");
    $setterPagina->setDescription("Pagina iniziale del sito The Darksoulers");  

    $setterPagina->setNavBar(file_get_contents(__DIR__ . "/contents/home-nav.php"));

	//controllo se l'utente e' loggato
	if ($_SESSION['loggedin']) {
        $utenteMobile = str_replace("<SegnapostoNomeMobile />", $_SESSION['user']->getNome(), file_get_contents(__DIR__ . "/contents/userLoginMobile.php"));
        $utenteFull = str_replace("<SegnapostoNome />", $_SESSION['user']->getNome(), file_get_contents(__DIR__ . "/contents/userLogin.php"));
        $setterPagina->setLoginContent($utenteFull, $utenteMobile);
        }
    else{
        $setterPagina->setLoginContent(file_get_contents(__DIR__ . "/contents/logRegContent.php"),file_get_contents(__DIR__ . "/contents/logRegMobileContent.php") );
        }
	
    $setterPagina->setPercorso("Aggiungi articolo");

    $newArtCon = file_get_contents(__DIR__ . "/contents/newArticoloContent.php");

    if ( $_SESSION["giono-non-trovato"] == true ){
        $_SESSION["giono-non-trovato"] = false;
        $newArtCon = str_replace("<SegnapostoGioconontrovato />",
        "<h2><span class=\"errore-credenziali\"> Il gioco che hai insertio non esiste nel database, 
        devi inserirlo prima dal pannello utente</span></h2>",$newArtCon);
    }else{
        $newArtCon = str_replace("<SegnapostoGioconontrovato />","",$newArtCon);
    }



    $setterPagina->setContent($newArtCon);
    $setterPagina->setFooter();

    $setterPagina->validate();
