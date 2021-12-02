<?php
session_start();
if(!isset($_POST['id'])) {
    header("Location:index.php");
    die();
}

require dirname(__DIR__, 2)."/vendor/autoload.php";
use Catalogo\Moviles;

(new Moviles)->delete($_POST['id']);
$_SESSION['mensaje'] = "Móvil borrado correctamente";
header("Location:index.php");