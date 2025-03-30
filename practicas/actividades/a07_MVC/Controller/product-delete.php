<?php

    use TECWEB\CONTROLLER\ProductsController as ProductsController;
    require_once 'ProductsController.php';

    $prodObj = new ProductsController('root', '23102005','marketzone');

    // SE VERIFICA HABER RECIBIDO EL ID
    if( isset($_GET['id']) ) {
        $id = $_GET['id'];
        $prodObj->delete($id);
    } 

    echo $prodObj->getData();
?>