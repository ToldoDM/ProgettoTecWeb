<?php
require_once __DIR__ . '/db-handler.php';
require_once __DIR__ . '/utente-class.php';


session_start();

$_SESSION["nickname"]   =   $_POST['nickname'];
$_SESSION["email"]      =   $_POST['email'];
$_SESSION["password"]   =   $_POST['password1'];

// Funzioni di controllo ???



$connection = new DBConnection();
/*$queryperincremento= query("SELECT COUNT(nome) FROM utente");
$queryperincremento++;*/
$query      = "INSERT INTO utente (nome,cognome,email,img_path,passw) 
                VALUES ('prova','prova','email di prova','prova','prova')";

$prova= $connection->query($query);



if (!$prova) {
    throw new Exception ("User doesn't exixst", 1);
    exit;
}



//$user = new Utente($_POST['nickname']);

// ALTRE INFO DI SESSIONE

header("Location: ./utente.php");



?>