<?php
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Catalogo\Moviles;
use Catalogo\Marcas;

$marcas = (new Marcas)->devolverMarcas();
$error = false;
function validarCampos($n, $v)
{
    global $error;
    if (strlen($v) == 0) {
        $_SESSION[$n] = "El campo $n esta vacio, por favor rellenelo";
        $error = true;
    }
}

if (isset($_POST['crear'])) {
    $modelo = trim(ucfirst($_POST['modelo']));
    $color = trim(ucfirst($_POST['color']));
    $bateria = trim($_POST['bateria']);
    $marca_id = $_POST['marca_id'];

    validarCampos('modelo', $modelo);
    validarCampos('color', $color);
    validarCampos('bateria', $bateria);

    if (!$error) {
        (new Moviles)->setModelo($modelo)
            ->setColor($color)
            ->setBateria($bateria)
            ->setMarca_id($marca_id)
            ->create();
        $_SESSION['mensaje'] = "Móvil creado correctamente";
        header("Location:index.php");
    } else {
        header("Location:{$_SERVER['PHP_SELF']}");
    }
} else {
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
            <h3 class="text-center">Nuevo Móvil</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="c" method="POST">
                <div class="my-2 p-4 mx-auto border border-4" style="width:40rem">
                    <div class="mb-3">
                        <label for="m" class="form-label">Modelo Móvil</label>
                        <input type="text" name="modelo" id="m" placeholder="Modelo" class="form-control" required>
                        <?php
                        if (isset($_SESSION['modelo'])) {
                            echo "<p class='my-2 p-2 text-danger'>{$_SESSION['modelo']}</p>";
                            unset($_SESSION['modelo']);
                        }
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="c" class="form-label">Color Móvil</label>
                        <input type="text" name="color" id="c" placeholder="Color" class="form-control">
                        <?php
                        if (isset($_SESSION['color'])) {
                            echo "<p class='my-2 p-2 text-danger'>{$_SESSION['color']}</p>";
                            unset($_SESSION['color']);
                        }
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="b" class="form-label">Bateria Móvil</label>
                        <input type="text" name="bateria" id="b" class="form-control" placeholder="Bateria">
                        <?php
                        if (isset($_SESSION['bateria'])) {
                            echo "<p class='my-2 p-2 text-danger'>{$_SESSION['bateria']}</p>";
                            unset($_SESSION['bateria']);
                        }
                        ?>
                    </div>
                    <div class="mb-3">
                        <label for="mid" class="form-label">Marca Móvil</label>
                        <select name="marca_id" id="mid" class="form-control">
                            <?php
                            foreach ($marcas as $item) {
                                echo "<option value='{$item->id}'>{$item->nombre}</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <button type="submit" name="crear" class="btn btn-primary"><i class="fas fa-check-circle"></i> Crear</button>
                        <button type="reset" class="btn btn-danger"><i class="fas fa-broom"></i> Borrar</button>
                        <a href="index.php" class="btn btn-secondary"><i class="fas fa-backward"></i> Volver</a>
                    </div>
                </div>
            </form>
        </div>
    </body>

    </html>
<?php } ?>