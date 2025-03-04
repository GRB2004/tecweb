<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array();
    // SE VERIFICA HABER RECIBIDO EL ID
    if (isset($_POST['name'])) {
        $name = $_POST['name'];
        if ($result = $conexion->query("SELECT * FROM productos WHERE nombre LIKE '$name%'")) {
            while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
                $data[] = $row;
            }
            $result->free();
        } else {
            die('Query Error: ' . mysqli_error($conexion));
        }
        $conexion->close();
        echo json_encode($data, JSON_PRETTY_PRINT);
    }
    
?>