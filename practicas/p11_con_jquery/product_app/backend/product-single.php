<?php

include_once __DIR__.'/database.php';

$id = $_POST['id'];

// Usar sentencias preparadas para evitar SQL injection
$query = "SELECT nombre, detalles, id FROM productos WHERE id = ?";
$stmt = $conexion->prepare($query);
$stmt->bind_param("i", $id);
$stmt->execute();

$result = $stmt->get_result();
if (!$result) {
    die('Consulta fallida');
}

$json = array();
if ($row = $result->fetch_assoc()) {
    $json[] = array(
        'name' => $row['nombre'],
        'description' => $row['detalles'],
        'id' => $row['id']
    );
}

$jsonstring = json_encode($json[0]);
echo $jsonstring;

?>

