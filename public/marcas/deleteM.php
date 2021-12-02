<?php
if(!isset($_POST['id'])) {
    header("Location:index.php");
    die();
}

session_start();
$marca = unserialize($_POST['id']);
require dirname(__DIR__, 2)."/vendor/autoload.php";
use Catalogo\Marcas;
use Catalogo\Imagen;

(new Marcas)->delete($marca->id);
if(basename($marca->img) != 'default.png') {
    $imagen = (new Imagen)->setDirStorage(dirname(__DIR__)."/img/marcas/");
    $imagen->borrarFichero(basename($marca->img));
}

$_SESSION['mensaje'] = "Marca borrada correctamente";
header("Location:index.php");