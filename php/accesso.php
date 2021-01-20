<?php
    require_once __DIR__ . "/setterTemplate.php";

    session_start();

    $setterPagina = new setterTemplate("..");

    $setterPagina->setTitle("Login | The Darksoulers");
    $setterPagina->setDescription("Pagina di login");  
    
    $setterPagina->setNavBar(
        preg_replace(
            "((?s)<a href=\"<rootFolder />/php/accesso.php\">Accedi</a>)",
            "<a href=\"#header\" class=\"active\">Accedi</a>",
            preg_replace(
                "((?s)<li class=\"elementomenu\"><a href=\"<rootFolder />/php/accesso.php\">Accedi</a></li>)",
                "<li id=\"currentLink\" class=\"elementomenu\">Accedi</li>",
                file_get_contents(__DIR__ . "/contents/home-nav.php"))));

	//controllo se ha fatto il login
    $setterPagina->setLoginContent(file_get_contents(__DIR__ . "/contents/logRegContent.php"), file_get_contents(__DIR__ . "/contents/logRegMobileContent.php"));
	
    $setterPagina->setPercorso("Accedi");
    
    //da sistemare una volta implementato il db
    $accCon = file_get_contents(__DIR__ . "/contents/accessoContent.php");
    if ($_SESSION["err-credenziali"]==true) {
        $accCon = str_replace("<SegnapostoCredenziali />", " Hai inserito Email o Password sbagliata ",$accCon);
        $_SESSION["err-credenziali"]=false;
    }

    $setterPagina->setContent($accCon);
    $setterPagina->setFooter();

    $setterPagina->validate();
?>