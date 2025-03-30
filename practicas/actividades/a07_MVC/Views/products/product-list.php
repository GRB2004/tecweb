<?php

    use TECWEB\CONTROLLER\ProductsController as ProductsController;
    require_once __DIR__ . '/../../Controller/ProductsController.php';

    $prodObj = new ProductsController('root', '23102005','marketzone');
    $prodObj->list();

    echo $prodObj->getData();
?>