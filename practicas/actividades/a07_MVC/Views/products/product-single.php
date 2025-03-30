<?php
    use TECWEB\CONTROLLER\ProductsController as ProductsController;
    require_once __DIR__ . '/../../Controller/ProductsController.php';

    $prodObj = new ProductsController('root', '23102005','marketzone');

    if(isset($_POST['id'])) {
        $id = $_POST['id'];
        $prodObj->single($id); // Ya incluye el echo de la vista
    } else {
        die(json_encode(['error' => 'No se recibió el ID']));
    }
?>






