<?php

  namespace myapi\Update;

  use myapi\Database\Database as Database;
  require_once __DIR__ . '/../Database/Database.php';

  class Update extends Database {
    private $data = NULL;
    public function __construct($user='root', $pass='23102005', $db) {
      $this->data = array();
      parent::__construct($user, $pass, $db);
    }

      public function edit($producto){
        $this->data = array();
        $id = $producto->getId();
        $nombre = $producto->getNombre();
        $marca = $producto->getMarca();
        $modelo = $producto->getModelo();
        
        // Aseguramos que precio y unidades sean números
        $precio = $producto->getPrecio();
        $unidades = $producto->getUnidades();
        
        $detalles = $producto->getDetalles();
        $imagen = $producto->getImagen();
        // Construir la consulta SQL
        $sql = "UPDATE productos SET
        nombre='$nombre', 
        marca='$marca', 
        modelo='$modelo', 
        precio=$precio, 
        detalles='$detalles', 
        unidades=$unidades, 
        imagen='$imagen' 
        WHERE id=$id";
        
        // Ejecutar la consulta
        if($this->conexion->query($sql)) {
        $this->data['status'] = "success";
        $this->data['message'] = "Producto actualizado";
        } else {
        $this->data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($this->conexion);
        }
    
        $this->conexion->close();
    }

    public function getData() {
      return json_encode($this->data, JSON_PRETTY_PRINT);
    }
  }



?>