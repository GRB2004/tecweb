<?php

  namespace myapi\Delete;
  use myapi\Database\Database as Database;
  require_once __DIR__ . '/../Database/Database.php';

  class Delete extends DataBase {
    private $data = NULL;
    public function __construct($user='root', $pass='23102005', $db) {
      $this->data = array();
      parent::__construct($user, $pass, $db);
    }

    public function delete($id) {
      // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
      $this->data = array();
      $sql = "UPDATE productos SET eliminado=1 WHERE id = {$id}";
      if ( $this->conexion->query($sql) ) {
          $this->data['status'] =  "success";
          $this->data['message'] =  "Producto eliminado";
  } else {
          $this->data['message'] = "ERROR: No se ejecuto $sql. " . mysqli_error($this->conexion);
      }
  $this->conexion->close();
    }

    public function getData() {
      return json_encode($this->data, JSON_PRETTY_PRINT);
    }

  }

?>