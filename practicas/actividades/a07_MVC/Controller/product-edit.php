<?php
    use TECWEB\CONTROLLER\ProductsController as ProductsController;
    require_once 'ProductsController.php';

    $prodObj = new ProductsController('root', '23102005','marketzone');

    if(isset($_POST['id'])) {
        $productData = [
            'id' => $_POST['id'],
            'nombre' => $_POST['nombre'],
            'marca' => $_POST['marca'],
            'modelo' => $_POST['modelo'],
            'precio' => $_POST['precio'],
            'detalles' => $_POST['detalles'],
            'unidades' => $_POST['unidades'],
            'imagen' => $_POST['imagen']
        ];
        
        $prodObj->edit($productData);
        echo $prodObj->getData();
    }
?>