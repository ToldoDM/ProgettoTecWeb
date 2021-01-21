<?php
require_once __DIR__ . "/setterTemplate.php";
require_once __DIR__ . "/query-articoli.php";

$setterPagina = new setterTemplate("..");


if (key_exists("pagina", $_GET)) {
    if (intval($_GET["pagina"] < 1)) {
        header("Location: error/404.php");
        exit;
    }
}

$pag = [
    "Risultati della ricerca",
    "Articoli",
    "Genere",
    "Top 10",
    "Nuove Uscite",
];

$currPag = array_key_exists('id', $_GET) ? $_GET['id'] : 0;

if ($currPag == 0 && !key_exists("termine-ricerca", $_GET)) {
    header("Location: error/400.php");
    exit;
}

$termineCerca = $_GET['termine-ricerca'];

if ($currPag < 0 || $currPag >= 5) {
    header("Location: error/404.php");
    exit;
}

$setterPagina->setTitle("$pag[$currPag] | The Darksoulers");
$nav = file_get_contents(__DIR__ . "/contents/home-nav.php");
$pageContent = ""; //bisogna inserire un default

switch ($currPag) {
    case 0:
        $setterPagina->setDescription("Elenco degli articoli il cui nome contiene il termine ricercato");
        $pageContent = "<div  id=\"contenutoArticoli\" class=\"contenutoGenerale\" >";
        $pageContent .= cercaArticoli($termineCerca, 0) . "</div>";
        break;
    case 1:
        $setterPagina->setDescription("Elenco di tutti gli articoli");
        $pageContent = "<div  id=\"contenutoArticoli\" class=\"contenutoGenerale\" >";
        $pageContent .= getArticoli(0, 10) . "</div>";
        break;
    case 2:
        $setterPagina->setDescription("Elenco dei generi dei videogames");
        $pageContent = file_get_contents(__DIR__ . "/contents/genereContent.php");
        break;
    case 3:
        $setterPagina->setDescription("Elenco dei top 10 giochi più votati");
        $pageContent = "<div class=\"contenutoGenerale\" id=\"contenutoArticoli\" >";
        $pageContent .= getTop10() . "</div>";
        break;    
    case 4:
        $setterPagina->setDescription("Nuove uscite");
        $pageContent = "<div  class=\"contenutoGenerale\" id=\"contenutoArticoli\" >";
        $pageContent .= getNuoveUscite() . "</div>";
        break;
}
$pageContent .= "<div class=\"torna-su\" ><a class=\"torna-su-link\" href=\"#header\">Torna su</a></div>";

$setterPagina->setContent($pageContent);

if ($currPag != 0) {
    $nav = preg_replace(
            "((?s)<a href=\"<rootFolder />/php/menu\.php\?id=$currPag\">.*?</a>)",
            "<a href=\"#header\" class=\"active\" xml:lang=\"en\">$pag[$currPag]</a>",
            preg_replace(
                "((?s)<li class=\"elementomenu\"><a href=\"<rootFolder />/php/menu\.php\?id=$currPag\">.*?</a></li>)",
                "<li xml:lang=\"en\" id=\"currentLink\" class=\"elementomenu\">$pag[$currPag]</li>",
                $nav));

    $setterPagina->setPercorso($pag[$currPag]);
} else {
    $setterPagina->setPercorso("Ricerca");
}

$setterPagina->setNavBar($nav);


//controllo se l'utente e' loggato
	if (!(isset($_SESSION['loggedin']) && $_SESSION['loggedin'])) {
		$setterPagina->setLoginContent(file_get_contents(__DIR__ . "/contents/logRegContent.php"),file_get_contents(__DIR__ . "/contents/logRegMobileContent.php") );
	}
	else {
		$utenteMobile = str_replace("<SegnapostoNomeMobile />", $_SESSION['user']->getNome(), file_get_contents(__DIR__ . "/contents/userLoginMobile.php"));
		$utenteFull = str_replace("<SegnapostoNome />", $_SESSION['user']->getNome(), file_get_contents(__DIR__ . "/contents/userLogin.php"));
		$setterPagina->setLoginContent($utenteFull, $utenteMobile);
	}

$setterPagina->setFooter();
$setterPagina->validate();