<?php

    use myapi\Update\Update as Update;
    require_once __DIR__ . '/start.php';
    require_once __DIR__ . '/myapi/ProductoEdit.php';

    // Se crea la instancia de Products
    $prodObj = new Update('root', '23102005','marketzone');

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
        
        // Asignamos la instancia de Products a la clase Producto
        ProductoEdit::setProductsObject($prodObj);

        // Al crear el objeto Producto, en el constructor se invoca productAdd() automáticamente.
        $producto = new ProductoEdit($id, $nombre, $marca, $modelo, $precio, $unidades, $detalles, $imagen);
        // Finalmente, mostramos el resultado de la operación
        echo $prodObj->getData();
    } 
?>