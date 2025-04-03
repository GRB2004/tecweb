<?php
  namespace myapi\Database;
  
  abstract class DataBase {
    protected $conexion;
    public function __construct($user, $pass, $db) {
      $this->conexion = @mysqli_connect(
        'localhost',
        $user,
        $pass,
        $db
      );
      /**
       * NOTA: si la conexión falló $conexion contendrá false
       */
      if(!$this->conexion) {
        die('Base de datos no conectada!!');
      }
    }

    public function getData() {
      return json_encode($this->data, JSON_PRETTY_PRINT);
    }
  }
?>