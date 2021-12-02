<?php
namespace Catalogo;

class Imagen{
    private $appUrl; 
    private $nombreF;
    private $dirStorage; 

    public function isImagen($tipo){

        $tiposBuenos=[
            'image/jpeg',
            'image/bmp',
            'image/png',
            'image/webp',
            'image/gif',
            'image/svg-xml',
            'image/x-icon'
        ];
        return in_array($tipo, $tiposBuenos);
    }
    public function guardarImagen($imagen){
        return move_uploaded_file($imagen, $this->nombreF);
    }
    public function getUrlImagen($dir){
        return $this->appUrl."img/$dir/".basename($this->nombreF);
    }
    public function guardarDefault($carpeta){
        return $this->appUrl."/img/$carpeta/default.png"; 
    }
    function borrarFichero($nombre){
        unlink($this->dirStorage.$nombre);
    }

    /**
     * Set the value of appUrl
     *
     * @return  self
     */ 
    public function setAppUrl($appUrl)
    {
        $this->appUrl = $appUrl;

        return $this;
    }

    /**
     * Set the value of nombreF
     *
     * @return  self
     */ 
    public function setNombreF($nombreF)
    {
        $this->nombreF = $this->dirStorage.uniqid()."_".$nombreF;

        return $this;
    }

    /**
     * Set the value of dirStorage
     *
     * @return  self
     */ 
    public function setDirStorage($dirStorage)
    {
        $this->dirStorage = $dirStorage;

        return $this;
    }
}