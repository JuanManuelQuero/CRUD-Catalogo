<?php
session_start();
require dirname(__DIR__, 2) . "/vendor/autoload.php";

use Catalogo\Marcas;
use Catalogo\Imagen;

$URL_APP = "http://localhost/proyectos/tema4/practicas/catalogo/public/";
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
    $nombre = trim(ucfirst($_POST['nombre']));
    $ciudad = trim(ucfirst($_POST['ciudad']));

    validarCampos("nombre", $nombre);
    validarCampos("ciudad", $ciudad);

    $marca = new Marcas;

    if(is_uploaded_file($_FILES['img']['tmp_name'])) {
        if((new Imagen)->isImagen($_FILES['img']['type'])) {
            $imagen = new Imagen;
            $imagen->setAppUrl("http://localhost/proyectos/tema4/practicas/catalogo/public/");
            $imagen->setDirStorage(dirname(__DIR__)."/img/marcas/");
            $imagen->setNombreF($_FILES['img']['name']);
            if($imagen->guardarImagen($_FILES['img']['tmp_name'])) {
                $marca->setImg($imagen->getUrlImagen('marcas'));
            } else {
                $error = true;
                $_SESSION['error_img'] = "No se puedo guardar la imagen";
            }
        } else {
            $error = true;
            $_SESSION['error_img'] = "El fichero debe ser una imagen";
        }
    } else {
        $imagen = new Imagen;
        $imagen->setAppUrl("http://localhost/proyectos/tema4/practicas/catalogo/public/");
        $marca->setImg($imagen->guardarDefault('marcas'));
    }

    if(!$error) {
        $marca->setNombre($nombre)
        ->setCiudad($ciudad)
        ->create();
        $_SESSION['mensaje'] = "Marca creada correctamente";
        header("Location:index.php");
    } else {
        header("Location:{$_SERVER['PHP_SELF']}");
        die();
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
        <title>Nueva Marca</title>
    </head>

    <body>
        <div class="container mt-2">
            <h3 class="text-center">Nueva Marca</h3>
            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" name="a" method="POST" enctype="multipart/form-data">
                <div class="my-2 p-4 mx-auto border border-4" style="width:40rem">
                    <div class="mb-3">
                        <label for="n" class="form-label">Nombre Marca</label>
                        <input type="text" name="nombre" id="n" placeholder="Nombre" class="form-control" required>
                        <?php
                        if(isset($_SESSION['nombre'])){
                            echo "<p class='text-danger mt-1'>{$_SESSION['nombre']}</p>";
                            unset($_SESSION['nombre']);
                        }
                    ?>  
                    </div>
                    <div class="mb-3">
                        <label for="c" class="form-label">Ciudad</label>
                        <input type="text" name="ciudad" id="c" placeholder="Ciudad" class="form-control">
                        <?php
                        if(isset($_SESSION['ciudad'])){
                            echo "<p class='text-danger mt-1'>{$_SESSION['ciudad']}</p>";
                            unset($_SESSION['ciudad']);
                        }
                    ?>  
                    </div>
                    <div class="mb-3">
                        <label for="i" class="form-label">Imagen</label>
                        <input type="file" name="img" id="i" class="form-control">
                        <?php
                        if(isset($_SESSION['error_img'])){
                            echo "<p class='text-danger mt-1'>{$_SESSION['error_img']}</p>";
                            unset($_SESSION['error_img']);
                        }
                    ?>  
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