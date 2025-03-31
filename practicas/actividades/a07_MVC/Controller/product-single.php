<?php
    use TECWEB\CONTROLLER\ProductsController;
    use TECWEB\MODEL\ProductModel;
    use TECWEB\VIEWS\ProductView;

    require_once __DIR__ . '/../Model/ProductModel.php';
    require_once __DIR__ . '/../Views/ProductView.php';
    require_once __DIR__ . '/ProductsController.php';

try {
    // Verifica si el ID existe en $_POST
    if (!isset($_POST['id'])) {
        throw new Exception("ID de producto no proporcionado");
    }

    $id = $_POST['id'];

    // 2. Configurar dependencias MVC
    $modelo = new ProductModel('root', '23102005', 'marketzone');
    $vista = new ProductView();
    $controlador = new ProductsController($modelo, $vista);

    // 3. Obtener y mostrar producto
    $controlador->single($id);

} catch (Exception $e) {
    // 4. Manejo de errores estructurado
    $response = [
        'status' => 'error',
        'message' => $e->getMessage()
    ];
    
    header('Content-Type: application/json');
    echo json_encode($response);
}






