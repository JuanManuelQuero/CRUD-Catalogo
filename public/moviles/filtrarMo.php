<?php
if (!isset($_GET['campo']) && !isset($_GET['valor'])) {
    header("Location:index.php");
    die();
}

require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Catalogo\Moviles;

$moviles = (new Moviles)->filtrarMoviles($_GET['campo'], $_GET['valor']);

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Filtrar</title>
</head>

<body>
    <div class="container mt-2">
        <h3 class="text-center">Móviles de la misma Marca</h3>
        <a href="index.php" class="btn btn-success"><i class="fas fa-mobile-alt"></i> Móviles</a>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Detalles</th>
                    <th scope="col">ID</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Bateria</th>
                    <th scope="col">Color</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $moviles->fetch(PDO::FETCH_OBJ)) {
                    echo <<<TXT
                        <tr>
                            <th scope="row">
                            <a href="detalleMo.php?id={$fila->id}" class="btn btn-warning"><i class="fas fa-info-circle"></i> Detalle</a>
                            </th>
                            <td>{$fila->id}</td>
                            <td>{$fila->modelo}</td>
                            <td>{$fila->bateria}</td>
                            <td>{$fila->color}</td>
                        </tr>
                TXT;
                }
                ?>
            </tbody>
        </table>
    </div>
</body>

</html>