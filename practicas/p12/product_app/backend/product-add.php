<?php

    use myapi\Create\Create as Create;
    require_once __DIR__ . '/start.php';
    require_once __DIR__ . '/myapi/Producto.php';

    $prodObj = new Create('root', '23102005','marketzone');


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
?>