<?php
if (!isset($_GET['id'])) {
    header("Location:index.php");
    die();
}
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Catalogo\Moviles;

$datos = (new Moviles)->detallesMovil($_GET['id']);
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
        <h3 class="text-center">Detalles Móvil(<?php echo $datos->id; ?>)</h3>
        <div class="my-2 p-4 mx-auto border border-4 text-center" style="width:40rem">
            <b>Modelo: </b><?php echo $datos->modelo; ?><br><br>
            <b>Color: </b><?php echo $datos->color; ?><br><br>
            <b>Bateria: </b><?php echo $datos->bateria; ?><br><br>
            <b>Marca: </b><a href="filtrarMo.php?campo=marca_id&valor=<?php echo $datos->marca_id; ?>" class="bg-info text-dark rounded" style="text-decoration: none;"><?php echo $datos->nombre; ?></a>
            <div class="mt-3">
                <a href="index.php" class="btn btn-secondary"><i class="fas fa-backward"></i> Volver</a>
            </div>
        </div>
    </div>
</body>

</html>