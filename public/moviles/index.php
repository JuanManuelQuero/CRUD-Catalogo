<?php
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Catalogo\Moviles;

(new Moviles)->generearMoviles(50);
$datos = (new Moviles)->readAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrZj/k7ujTnHg4CGR2D7kSs0v4LLanw2qksYuRlEzO+tcaEPQogQ0KaoGN26/zrn20ImR1DfuLWnOo7aBA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.datatables.net/1.11.3/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <title>Móviles</title>
</head>

<body>
    <div class="container mt-2">
        <h3 class="text-center">Móviles</h3>
        <?php
        if (isset($_SESSION['mensaje'])) {
            echo "<p class='p-2 my-2 text-white bg-dark rounded'>
                <i class='fas fa-info-circle'></i> {$_SESSION['mensaje']}</p>";
            unset($_SESSION['mensaje']);
        }
        ?>
        <a href="createMo.php" class="btn btn-success mb-3"><i class="fas fa-plus-circle"></i> Nuevo Movil</a>
        <a href="../index.php" class="btn btn-dark mb-3"><i class="fas fa-home"></i> Menu</a>
        <table class="table" id="moviles">
            <thead>
                <tr>
                    <th scope="col">Detalles</th>
                    <th scope="col">Modelo</th>
                    <th scope="col">Color</th>
                    <th scope="col">Acciones</th>
                </tr>
            </thead>
            <tbody>
                <?php
                while ($fila = $datos->fetch(PDO::FETCH_OBJ)) {
                    echo <<<TXT
                    <tr>
                        <th scope="row">
                        <a href="detalleMo.php?id={$fila->id}" class="btn btn-warning"><i class="fas fa-info-circle"></i> Detalle</a>
                        </th>
                        <td>{$fila->modelo}</td>
                        <td>{$fila->color}</td>
                        <td>
                            <form method='POST' action='deleteMo.php' name='s'> 
                                <input type='hidden' name='id' value={$fila->id}'>
                                <a href='updateMo.php?id={$fila->id}' class='btn btn-primary'><i class='fas fa-edit'></i> Editar</a>
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#moviles').DataTable();
        });
    </script>
</body>

</html>