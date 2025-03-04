<?php
include_once __DIR__.'/database.php';

// Obtener datos como JSON
$data = json_decode(file_get_contents('php://input'), true);

if ($data) {
    $nombre = $conexion->real_escape_string($data['nombre']);
    $marca = $conexion->real_escape_string($data['marca']);
    $modelo = $conexion->real_escape_string($data['modelo']);
    $precio = floatval($data['precio']);
    $detalles = $conexion->real_escape_string($data['detalles']);
    $unidades = intval($data['unidades']);
    $imagen = $conexion->real_escape_string($data['imagen']);

    $sql = "INSERT INTO productos (nombre, marca, modelo, precio, detalles, unidades, imagen) 
            VALUES ('$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen')";

    if ($conexion->query($sql)) {
        echo json_encode(['success' => true, 'message' => 'Producto insertado exitosamente']);
        echo '<h2>Producto Insertado Exitosamente</h2>';
    } else {
        echo json_encode(['success' => false, 'message' => 'Error al insertar: ' . $conexion->error]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Datos inválidos']);
}

$conexion->close();
?>