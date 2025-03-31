<?php
    use TECWEB\CONTROLLER\ProductsController;
    use TECWEB\MODEL\ProductModel;
    use TECWEB\VIEWS\ProductView;

    require_once __DIR__ . '/../Model/ProductModel.php';
    require_once __DIR__ . '/../Views/productView.php';
    require_once 'ProductsController.php';

    try {
        $modelo = new ProductModel('root', '23102005', 'marketzone');
        $vista = new ProductView();
        $controlador = new ProductsController($modelo, $vista);
        
        // Obtener solo el cuerpo de la tabla
        $html = $controlador->list(true); // Nuevo parámetro para indicar que solo queremos el tbody
        echo $html;

    } catch (Exception $e) {
        echo json_encode([
            'error' => true,
            'message' => $e->getMessage()
        ]);
    }

?>