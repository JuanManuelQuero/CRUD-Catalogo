<?php
namespace Catalogo;

use PDO;
use PDOException;
use Faker;
use Catalogo\Marcas;

class Moviles extends Conexion {
    private $id;
    private $modelo;
    private $color;
    private $bateria;
    private $marca_id;

    public function __construct()
    {
        parent::__construct();
    }

    //### CRUD ###
    public function create() {
        $q = "insert into moviles(modelo, color, bateria, marca_id) values(:m, :c, :b, :mid)";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':m'=>$this->modelo,
                ':c'=>$this->color,
                ':b'=>$this->bateria,
                ':mid'=>$this->marca_id
            ]);
        }catch(PDOException $ex) {
            die("Error al crear el movil: ".$ex->getMessage());
        }
        parent::$conexion = null;
    }

    public function read($id) {
        $q = "select * from moviles where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i'=>$id
            ]);
        } catch(PDOException $ex) {
            die("Error al devolver los datos del móvil: ".$ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function update($id) {
        $q = "update moviles set modelo=:m, color=:c, bateria=:b, marca_id=:mid where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':m'=>$this->modelo,
                ':c'=>$this->color,
                ':b'=>$this->bateria,
                ':mid'=>$this->marca_id,
                ':i'=>$id
            ]);
        } catch(PDOException $ex) {
            die("Error al actualizar el movil: ".$ex->getMessage());
        }
        parent::$conexion = null;

    }

    public function delete($id) {
        $q = "delete from moviles where id=:i";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':i'=>$id
            ]);
        } catch(PDOException $ex) {
            die("Error al borrar el movil: ".$ex->getMessage());
        }
        parent::$conexion = null;
    }

    //### OTROS METODOS ###
    public function hayMoviles() {
        $q = "select * from moviles";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        }catch(PDOException $ex) {
            die("Error al comprobar si hay moviles: ".$ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->rowCount();
    }

    public function generearMoviles($cantidad) {
        if($this->hayMoviles() == 0) {
            $faker = Faker\Factory::create('es_ES');
            $idMarcas = (new Marcas)->getMarcasId();
            for($i = 0; $i < $cantidad; $i++) {
                $modelo = $faker->word();
                $color = $faker->colorName();
                $bateria = $faker->numberBetween(800, 2500);
                $marca_id = $faker->randomElement($idMarcas);
                (new Moviles)->setModelo($modelo)
                ->setColor($color)
                ->setBateria($bateria)
                ->setMarca_id($marca_id)
                ->create();
            }
        }
    }

    public function readAll() {
        $q = "select * from moviles order by modelo";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute();
        }catch(PDOException $ex) {
            die("Error al devolver los móviles: ".$ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt;
    }

    public function detallesMovil($id) {
        $q = "select moviles.*, nombre, ciudad from moviles, marcas where marcas.id=moviles.marca_id AND moviles.id=:id";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':id'=>$id
            ]);
        } catch(PDOException $ex) {
            die("Error al mostrar los detalles del movil: ".$ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt->fetch(PDO::FETCH_OBJ);
    }

    public function filtrarMoviles($c, $v) {
        $q = "select * from moviles where $c=:valor order by modelo";
        $stmt = parent::$conexion->prepare($q);
        try {
            $stmt->execute([
                ':valor'=>$v
            ]);
        } catch(PDOException $ex) {
            die("Error al filtrar los moviles: ".$ex->getMessage());
        }
        parent::$conexion = null;
        return $stmt;
    }



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
     * Get the value of modelo
     */ 
    public function getModelo()
    {
        return $this->modelo;
    }

    /**
     * Set the value of modelo
     *
     * @return  self
     */ 
    public function setModelo($modelo)
    {
        $this->modelo = $modelo;

        return $this;
    }

    /**
     * Get the value of color
     */ 
    public function getColor()
    {
        return $this->color;
    }

    /**
     * Set the value of color
     *
     * @return  self
     */ 
    public function setColor($color)
    {
        $this->color = $color;

        return $this;
    }

    /**
     * Get the value of marca_id
     */ 
    public function getMarca_id()
    {
        return $this->marca_id;
    }

    /**
     * Set the value of marca_id
     *
     * @return  self
     */ 
    public function setMarca_id($marca_id)
    {
        $this->marca_id = $marca_id;

        return $this;
    }

    /**
     * Get the value of bateria
     */ 
    public function getBateria()
    {
        return $this->bateria;
    }

    /**
     * Set the value of bateria
     *
     * @return  self
     */ 
    public function setBateria($bateria)
    {
        $this->bateria = $bateria;

        return $this;
    }
}