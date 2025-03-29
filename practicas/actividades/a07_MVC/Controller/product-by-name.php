<?php

    use TECWEB\CONTROLLER\ProductsController as ProductsController;
    require_once __DIR__ . '/Controller/ProductsController.php';

    $prodObj = new ProductsController('root', '23102005','marketzone');
    if(isset($_POST['name'])) {
        $name = $_POST['name'];
        $prodObj->singleByName($name);
    } else {
        die("No");
    }
    echo $prodObj->getData();

?>