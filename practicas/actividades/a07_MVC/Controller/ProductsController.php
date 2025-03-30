<?php
namespace TECWEB\Controller;

use TECWEB\MODEL\DataBase as DataBase;
require_once __DIR__ . '/../Model/Database.php';
require_once __DIR__ . '/../Views/ProductView.php';
class ProductsController extends DataBase {
  private $data = NULL;
  private $view;
  public function __construct($user='root', $pass='23102005', $db) {
    $this->data = array();
    parent::__construct($user, $pass, $db);
    $this->view = new \ProductView();
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
      echo $this->view->mostrarListaCompleta($this->data);
    } else {
      die('Query Error: '.mysqli_error($this->conexion));
    }
    $this->conexion->close();
  }

  public function search($search) {
    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $this->data = array();
    // SE REALIZA LA QUERY DE BÚSQUEDA Y AL MISMO TIEMPO SE VALIDA SI HUBO RESULTADOS
    $sql = "SELECT * FROM productos WHERE (id = '{$search}' OR nombre LIKE '%{$search}%' OR marca LIKE '%{$search}%' OR detalles LIKE '%{$search}%') AND eliminado = 0";
    if ( $result = $this->conexion->query($sql) ) {
        // SE OBTIENEN LOS RESULTADOS
			  $rows = $result->fetch_all(MYSQLI_ASSOC);
        if(!is_null($rows)) {
          // SE CODIFICAN A UTF-8 LOS DATOS Y SE MAPEAN AL ARREGLO DE RESPUESTA
          foreach($rows as $num => $row) {
            foreach($row as $key => $value) {
              $this->data[$num][$key] = utf8_encode($value);
            }
          }
            }
      echo $this->view->buscarProducto($this->data);
			$result->free();
		$this->conexion->close();
    } 
  }

  public function sugerenciasNombres($searchTerm, $nombreIngresado) {
    $this->data = array();
    $searchTerm = $this->conexion->real_escape_string($searchTerm);
    
    $sql = "SELECT nombre FROM productos 
            WHERE nombre LIKE '%$searchTerm%' 
            AND eliminado = 0
            ORDER BY nombre ASC
            LIMIT 5";

    if ($result = $this->conexion->query($sql)) {
        $this->data = $result->fetch_all(MYSQLI_ASSOC);
        $result->free();
    }
    
    $this->conexion->close();
    echo $this->view->mostrarSugerencias($this->data, $nombreIngresado);
}

  public function single($id) {
    $this->data = array();
    
    if ($result = $this->conexion->query("SELECT * FROM productos WHERE id = {$id}")) {
        $row = $result->fetch_assoc();
        
        if(!empty($row)) {
            $this->data = array_map('utf8_encode', $row);
            // Usar la vista para generar la respuesta
            echo $this->view->mostrarSingle($this->data);
        } else {
            echo json_encode(['error' => 'Producto no encontrado']);
        }
        
        $result->free();
    } else {
        echo json_encode(['error' => 'Error de consulta: '.mysqli_error($this->conexion)]);
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