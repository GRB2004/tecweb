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

    if(isset($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $controlador->sugerenciasNombres($searchTerm);
    } else {
        echo '<div class="alert alert-warning">No se recibió término de búsqueda</div>';
    }
?>