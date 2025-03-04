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

    // Validar existencia del producto
    $sqlCheck = "SELECT id 
                FROM productos 
                WHERE eliminado = 0 
                AND (
                    (nombre = '$nombre' AND marca = '$marca') 
                    OR 
                    (marca = '$marca' AND modelo = '$modelo')
                )";
    $result = $conexion->query($sqlCheck);

    if ($result->num_rows > 0) {
        // Producto ya existe
        echo json_encode([
            'success' => false,
            'message' => 'Producto duplicado: Ya existe un registro activo con estos datos'
        ]);
    } else {
        $sqlInsert = "INSERT INTO productos 
                    (nombre, marca, modelo, precio, detalles, unidades, imagen) 
                    VALUES 
                    ('$nombre', '$marca', '$modelo', $precio, '$detalles', $unidades, '$imagen')";

        if ($conexion->query($sqlInsert)) {
            echo json_encode([
                'success' => true,
                'message' => 'Producto insertado exitosamente'
            ]);
        } else {
            echo json_encode([
                'success' => false,
                'message' => 'Error al insertar: ' . $conexion->error
            ]);
        }
    }
} else {
    echo json_encode([
        'success' => false,
        'message' => 'Datos inválidos'
    ]);
}

$conexion->close();
?>