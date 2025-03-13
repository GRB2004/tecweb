<?php
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
?>