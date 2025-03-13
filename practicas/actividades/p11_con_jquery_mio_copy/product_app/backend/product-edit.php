<?php
    include_once __DIR__.'/database.php';

    // SE CREA EL ARREGLO QUE SE VA A DEVOLVER EN FORMA DE JSON
    $data = array(
        'status'  => 'error',
        'message' => 'La consulta falló'
    );

    // SE VERIFICA HABER RECIBIDO EL ID
    if(isset($_POST['id'])) {
        // Usando directamente las variables POST
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $precio = $_POST['precio'];
        $detalles = $_POST['detalles'];
        $unidades = $_POST['unidades'];
        $imagen = $_POST['imagen'];
        
        // Escapar variables para prevenir inyección SQL
        $conexion->set_charset("utf8");
        $id = $conexion->real_escape_string($id);
        $nombre = $conexion->real_escape_string($nombre);
        $marca = $conexion->real_escape_string($marca);
        $modelo = $conexion->real_escape_string($modelo);
        $precio = $conexion->real_escape_string($precio);
        $detalles = $conexion->real_escape_string($detalles);
        $unidades = $conexion->real_escape_string($unidades);
        $imagen = $conexion->real_escape_string($imagen);
        
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
        if($conexion->query($sql)) {
            $data['status'] = "success";
            $data['message'] = "Producto actualizado";
        } else {
            $data['message'] = "ERROR: No se ejecutó $sql. " . mysqli_error($conexion);
        }
        
        $conexion->close();
    } 
    
    // SE HACE LA CONVERSIÓN DE ARRAY A JSON
    echo json_encode($data, JSON_PRETTY_PRINT);
?>