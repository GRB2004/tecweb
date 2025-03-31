<?php

    use TECWEB\CONTROLLER\ProductsController;
    use TECWEB\MODEL\ProductModel;
    use TECWEB\VIEWS\ProductView;

    require_once __DIR__ . '/../Model/ProductModel.php';
    require_once __DIR__ . '/../Views/productView.php';
    require_once 'ProductsController.php';

    $modelo = new ProductModel('root', '23102005', 'marketzone');
    $vista = new ProductView();
    $controlador = new ProductsController($modelo, $vista);

    if(isset($_GET['search']) ) {
        $search = $_GET['search'];
        $controlador->search($search);
    } else {
        die('Query Error: '.mysqli_error($this->conexion));
    }
    
?>