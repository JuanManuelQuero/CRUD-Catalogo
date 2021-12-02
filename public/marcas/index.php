<?php
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Catalogo\Marcas;

(new Marcas)->generarDatos(10);
$datos = (new Marcas)->readAll();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title></title>
</head>

<body>
    <div class="container mt-2">
        <h3 class="text-center">Marcas</h3>
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<p class='p-2 my-2 text-white bg-dark rounded'>
                <i class='fas fa-info-circle'></i> {$_SESSION['mensaje']}</p>";
            unset($_SESSION['mensaje']);
        }
        ?>
        <a href="createM.php" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> Nueva Marca</a>
        <a href="../index.php" class="btn btn-dark mb-3"><i class="fas fa-home"></i> Menu</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Imagen</th>
                    <th scope="col">Ciudad</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $datos->fetch(PDO::FETCH_OBJ)) {
                    $i = serialize($fila);
                    echo <<<TXT
                    <tr>
                        <th scope="row">{$fila->id}</th>
                        <td>{$fila->nombre}</td>
                        <td><img src='{$fila->img}' width='80rem' height='80rem' class='img-thumbnail'></td>
                        <td>{$fila->ciudad}</td>
                        <td>
                            <form name='a' action='deleteM.php' method='POST'>
                                <input type='hidden' name='id' value='$i'>
                                <a href='updateM.php?id={$fila->id}' class='btn btn-primary'><i class='fas fa-edit'></i> Editar</a>
                                <button type='submit' class='btn btn-danger'><i class='fas fa-trash'></i> Borrar</button>
                            </form>
                        </td>
                    </tr>
                TXT;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>