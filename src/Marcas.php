<?php

namespace Catalogo;

use PDOException;
use Faker;
use PDO;

class Marcas extends Conexion
{
    private $id;
    private $nombre;
    private $img;
    private $ciudad;

    public function __construct()
    {
        parent::__construct();
    }

    //### CRUD ###
    public function create()
    {
        $q = "insert into marcas(nombre, img, ciudad) values(:n, :i, :c)";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n' => $this->nombre,
                ':i' => $this->img,
                ':c' => $this->ciudad
            ]);
        } catch (PDOException $ex) {
            die("Error al crear la marca: " . $ex->getMessage());
        }
        parent::$conexion = null;
    }

    public function read($id)
    {
        $q = "select * from marcas where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i'=>$id
            ]);
        } catch(PDOException $ex) {
            die("Error al devolver los datos de la marca: ".$ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function update($id)
    {
        $q = "update marcas set nombre=:n, ciudad=:c, img=:i where id=:id";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':n'=>$this->nombre,
                ':c'=>$this->ciudad,
                ':i'=>$this->img,
                ':id'=>$id
            ]);
        } catch(PDOException $ex) {
            die("Error al actualizar la marca: ".$ex->getMessage());
        }
        parent::$conexion = null;
    }

    public function delete($id)
    {
        $q = "delete from marcas where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i'=>$id
            ]);
        } catch(PDOException $ex) {
            die("Error al borrar la marca: ".$ex->getMessage());
        }
        parent::$conexion = null;
    }

    //### OTROS METODOS ###
    public function generarDatos($cantidad)
    {
        $URL_APP = "http://localhost/proyectos/tema4/practicas/catalogo/public/";
        if ($this->hayMarcas() == 0) {
            $faker = Faker\Factory::create('es_ES');
            for ($i = 0; $i < $cantidad; $i++) {
                $nombre = $faker->unique->word();
                $ciudad = $faker->city();
                (new Marcas)->setNombre($nombre)
                    ->setImg($URL_APP . "img/marcas/default.png")
                    ->setCiudad($ciudad)
                    ->create();
            }
        }
    }

    public function hayMarcas()
    {
        $q = "select * from marcas";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al comprobar si ya hay marcas: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->rowCount();
    }

    public function readAll()
    {
        $q = "select * from marcas order by nombre";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al devolver los datos de marcas: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt;
    }

    public function getMarcasId()
    {
        $q = "select id from marcas";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al devolver el id de marcas: " . $ex->getMessage());
        }
        parent::$conexion = null;
        $id = [];
        while ($fila = $stmt->fetch(PDO::FETCH_OBJ)) {
            $id[] = $fila->id;
        }
        return $id;
    }

    public function devolverMarcas()
    {
        $q = "select id, nombre from marcas order by nombre";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        } catch (PDOException $ex) {
            die("Error al devolver el id y el nombre de marcas: " . $ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }


    //### GETTERS AND SETTERS ###


    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of nombre
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * Set the value of nombre
     *
     * @return  self
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;

        return $this;
    }

    /**
     * Get the value of img
     */
    public function getImg()
    {
        return $this->img;
    }

    /**
     * Set the value of img
     *
     * @return  self
     */
    public function setImg($img)
    {
        $this->img = $img;

        return $this;
    }

    /**
     * Get the value of ciudad
     */
    public function getCiudad()
    {
        return $this->ciudad;
    }

    /**
     * Set the value of ciudad
     *
     * @return  self
     */
    public function setCiudad($ciudad)
    {
        $this->ciudad = $ciudad;

        return $this;
    }
}
