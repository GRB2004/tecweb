<?php namespace myapi\Read;

  use myapi\Database\Database as Database;
  require_once __DIR__ . '/../Database/Database.php';
  
  class Read extends Database {
    private $data = NULL;
    public function __construct($user='root', $pass='23102005', $db) {
      $this->data = array();
      parent::__construct($user, $pass, $db);
    }

    public function list() {
      // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA JSON
      $this->data = array();
      // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
      if ($result = $this->conexion->query("SELECT * FROM productos WHERE eliminado = 0")) {
        // SE OBTIENEN LOS RESULTADOS
        $rows = $result->fetch_all(MYSQLI_ASSOC);
        if (!is_null($rows)) {
          // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
          foreach($rows as $num => $row) {
            foreach($row as $key => $value) {
              $this->data[$num][$key] = $value;
            }
          }
        }
        $result->free();
      } else {
        die('Query Error: '.mysqli_error($this->conexion));
      }
      $this->conexion->close();
    }

    public function single($id) {
      $this->data = array();
      // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
      if ( $result = $this->conexion->query("SELECT * FROM productos WHERE id = {$id}") ) {
          // SE OBTIENEN LOS RESULTADOS
          $row = $result->fetch_assoc();
  
          if(!is_null($row)) {
              // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
              foreach($row as $key => $value) {
                  $this->data[$key] = utf8_encode($value);
              }
          } else {
              $this->data['error'] = 'Producto no encontrado';
          }
          $result->free();
      } else {
          $this->data['error'] = 'Query Error: '.mysqli_error($this->conexion);
      }
      $this->conexion->close();
    }

    public function singleByName($nombre) {
      $this->data = array();
      // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
      if ( $result = $this->conexion->query("SELECT * FROM productos WHERE nombre = '{$nombre}'") ) {
        // SE OBTIENEN LOS RESULTADOS
        $row = $result->fetch_assoc();
  
        if(!is_null($row)) {
            // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
            foreach($row as $key => $value) {
                $this->data[$key] = utf8_encode($value);
            }
        }
        $result->free();
    } else {
        die('Query Error: '.mysqli_error($this->conexion));
    }
    $this->conexion->close();
    }


    public function getData() {
      return json_encode($this->data, JSON_PRETTY_PRINT);
    }
  
  }


?>