<?php

    use TECWEB\CONTROLLER\ProductsController as ProductsController;
    require_once 'ProductsController.php';

// Se crea la instancia de Products
$prodObj = new ProductsController('root', '23102005','marketzone');

// Clase Producto con referencia estática a la instancia de Products
class Producto {
    // Referencia a la instancia de Products para poder llamar a productAdd()
    private static $productsObj;
    
    private $nombre;
    private $marca;
    private $modelo;
    private $precio;
    private $unidades;
    private $detalles;
    private $imagen;

    // Método estático para asignar la instancia de Products
    public static function setProductsObject($productsObj) {
        self::$productsObj = $productsObj;
    }

    // Constructor completo: asigna propiedades y llama a productAdd()
    public function __construct($name, $marca, $modelo, $precio, $unidades, $detalles, $imagen) {
        $this->nombre   = $name;
        $this->marca    = $marca;
        $this->modelo   = $modelo;
        $this->precio   = $precio;
        $this->unidades = $unidades;
        $this->detalles = $detalles;
        $this->imagen   = $imagen;
        
        // Llamada a productAdd() si se ha asignado la instancia de Products
        if (self::$productsObj) {
            self::$productsObj->productAdd($this);
        }
    }

    // Métodos getter para acceder a los atributos
    public function getNombre() {
        return $this->nombre;
    }
    public function getMarca() {
        return $this->marca;
    }
    public function getModelo() {
        return $this->modelo;
    }
    public function getPrecio() {
        return $this->precio;
    }
    public function getUnidades() {
        return $this->unidades;
    }
    public function getDetalles() {
        return $this->detalles;
    }
    public function getImagen() {
        return $this->imagen;
    }
}

    // Asignamos la instancia de Products a la clase Producto
    Producto::setProductsObject($prodObj);


    $nombre   = $_POST['nombre']   ?? '';
    $marca    = $_POST['marca']    ?? '';
    $modelo   = $_POST['modelo']   ?? '';
    $precio   = is_numeric($_POST['precio'] ?? '') ? $_POST['precio'] : 0;
    $unidades = is_numeric($_POST['unidades'] ?? '') ? $_POST['unidades'] : 0;
    $detalles = $_POST['detalles'] ?? '';
    $imagen   = $_POST['imagen']   ?? '';

    // Al crear el objeto Producto, en el constructor se invoca productAdd() automáticamente.
    $producto = new Producto($nombre, $marca, $modelo, $precio, $unidades, $detalles, $imagen);

    // Finalmente, mostramos el resultado de la operación
    echo $prodObj->getData();
/*
include_once __DIR__.'/database.php';

$data = array(
    'status'  => 'error',
    'message' => 'No se pudo procesar la solicitud'
);

// Verificamos si recibimos los datos necesarios (nombre es obligatorio)
if(isset($_POST['nombre']) && !empty($_POST['nombre'])) {
    // Escapamos todos los valores para prevenir inyección SQL
    $conexion->set_charset("utf8");
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $marca = $conexion->real_escape_string($_POST['marca'] ?? '');
    $modelo = $conexion->real_escape_string($_POST['modelo'] ?? '');
    
    // Aseguramos que precio y unidades sean números
    $precio = is_numeric($_POST['precio']) ? $_POST['precio'] : 0;
    $unidades = is_numeric($_POST['unidades']) ? $_POST['unidades'] : 0;
    
    $detalles = $conexion->real_escape_string($_POST['detalles'] ?? '');
    $imagen = $conexion->real_escape_string($_POST['imagen'] ?? '');
    
    // Verificamos si ya existe un producto con ese nombre
    $sql = "SELECT id FROM productos WHERE nombre = '$nombre' AND eliminado = 0";
    $result = $conexion->query($sql);
    
    if ($result) {
        if ($result->num_rows == 0) {
            // No existe un producto con ese nombre, podemos insertarlo
            $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
                    VALUES ('$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen', 0)";
            
            if($conexion->query($sql)){
                $data['status'] = "success";
                $data['message'] = "Producto agregado correctamente";
            } else {
                $data['message'] = "Error al insertar el producto: " . $conexion->error;
            }
        } else {
            $data['message'] = "Ya existe un producto con ese nombre";
        }
        $result->free();
    } else {
        $data['message'] = "Error al verificar si el producto existe: " . $conexion->error;
    }
    
    // Cierra la conexión
    $conexion->close();
} else {
    $data['message'] = "Falta el nombre del producto";
}

// Aseguramos que la respuesta sea JSON
header('Content-Type: application/json');
echo json_encode($data, JSON_PRETTY_PRINT);

*/
?>