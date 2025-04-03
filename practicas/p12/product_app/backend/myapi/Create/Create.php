<?php
  namespace myapi\Create;

  use myapi\Database\Database as Database;
  require_once __DIR__ . '/../Database/Database.php';

  class Create extends DataBase {
    private $data = NULL;
    public function __construct($user='root', $pass='23102005', $db) {
      $this->data = array();
      parent::__construct($user, $pass, $db);
    }

    public function productAdd($producto) {
      // Verificamos si recibimos los datos necesarios (nombre es obligatorio)
      // Escapamos todos los valores para prevenir inyección SQL
      $this->data = array();
      $this->conexion->set_charset("utf8");
      $nombre = $producto->getNombre();
      $marca = $producto->getMarca();
      $modelo = $producto->getModelo();
      
      // Aseguramos que precio y unidades sean números
      $precio = $producto->getPrecio();
      $unidades = $producto->getUnidades();
      
      $detalles = $producto->getDetalles();
      $imagen = $producto->getImagen();
      
      // Verificamos si ya existe un producto con ese nombre
      $sql = "SELECT id FROM productos WHERE nombre = '$nombre' AND eliminado = 0";
      $result = $this->conexion->query($sql);
          
      if ($result) {
          if ($result->num_rows == 0) {
              // No existe un producto con ese nombre, podemos insertarlo
              $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
                      VALUES ('$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen', 0)";
              
              if($this->conexion->query($sql)){
                  $this->data['status'] = "success";
                  $this->data['message'] = "Producto agregado correctamente";
              } else {
                  $this->data['message'] = "Error al insertar el producto: " . $this->conexion->error;
              }
          } else {
              $this->data['message'] = "Ya existe un producto con ese nombre";
          }
          $result->free();
      } else {
          $this->data['message'] = "Error al verificar si el producto existe: " . $this->conexion->error;
      }
      
      // Cierra la conexión
      $this->conexion->close();
    }

    public function getData() {
      return json_encode($this->data, JSON_PRETTY_PRINT);
    }



  }

?>