<?php

    use TECWEB\CONTROLLER\ProductsController as ProductsController;
    use TECWEB\MODEL\Producto as Producto;
    require_once __DIR__ . '/../Model/Producto.php';
    require_once 'ProductsController.php';

    $prodObj = new ProductsController('root', '23102005','marketzone');

    // Asignar el controlador al modelo
    Producto::setProductsObject($prodObj);

    // Crear instancia de Producto con ID (esto disparará edit() automáticamente)
    $producto = new Producto(
        $_POST['nombre'],
        $_POST['marca'],
        $_POST['modelo'],
        $_POST['precio'],
        $_POST['unidades'],
        $_POST['detalles'],
        $_POST['imagen'],
        $_POST['id'] // <-- ID proporcionado
    );

    // Obtener respuesta
    echo $prodObj->getData();
?>