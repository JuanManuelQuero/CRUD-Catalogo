<?php
namespace Catalogo;

use PDO;
use PDOException;

class Conexion {
    protected static $conexion;

    public function __construct()
    {
        if(self::$conexion == null) {
            self::crearConexion();
        }
    }

    public static function crearConexion() {
        $fichero = dirname(__DIR__, 1)."/.config";
        $opciones = parse_ini_file($fichero);
        $usuario = $opciones["usuario"];
        $pass = $opciones["pass"];
        $base = $opciones["base"];
        $host = $opciones["host"];

        $dns = "mysql:host=$host;dbname=$base;charset=utf8mb4";

        try {
            self::$conexion = new PDO($dns, $usuario, $pass);
            self::$conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $ex) {
            die("Error al conectar con la base de datos:".$ex->getMessage());
        }
    }
}