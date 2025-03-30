<?php

    use TECWEB\CONTROLLER\ProductsController as ProductsController;
    require_once __DIR__ . '/../../Controller/ProductsController.php';

    $prodObj = new ProductsController('root', '23102005','marketzone');

    if(isset($_GET['search']) ) {
        $search = $_GET['search'];
        $prodObj->search($search);
    } else {
        die('Query Error: '.mysqli_error($this->conexion));
    }
    
?>