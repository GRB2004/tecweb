<?php
    namespace TECWEB\CONTROLLER;

    use TECWEB\CONTROLLER\ProductsController;
    use TECWEB\MODEL\ProductModel;
    use TECWEB\VIEWS\ProductView;
    use TECWEB\MODEL\Producto;

    require_once __DIR__ . '/../Model/ProductModel.php';
    require_once __DIR__ . '/../Model/Producto.php';
    require_once __DIR__ . '/../Views/productView.php';
    require_once 'ProductsController.php';

    header('Content-Type: application/json');

    // TEMPORAL: Mostrar errores en pantalla
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    // Configurar logging
    ini_set('log_errors', 1);
    ini_set('error_log', __DIR__ . '/edit_errors.log');

try {
    // 1. Validar campos requeridos
    $requiredFields = ['id', 'nombre', 'marca', 'modelo', 'precio', 'unidades', 'detalles', 'imagen'];
    foreach ($requiredFields as $field) {
        if (!isset($_POST[$field])) {
            throw new Exception("El campo $field es requerido");
        }
    }

    // 2. Sanitización y conversión de tipos
    $productData = [
        'id' => (int)$_POST['id'],
        'nombre' => htmlspecialchars($_POST['nombre']),
        'marca' => htmlspecialchars($_POST['marca']),
        'modelo' => htmlspecialchars($_POST['modelo']),
        'precio' => (float)$_POST['precio'],
        'unidades' => (int)$_POST['unidades'],
        'detalles' => htmlspecialchars($_POST['detalles']),
        'imagen' => filter_var($_POST['imagen'], FILTER_SANITIZE_URL)
    ];

    // 3. Inicializar MVC
    $modelo = new ProductModel('root', '23102005', 'marketzone');
    $vista = new ProductView();
    $controlador = new ProductsController($modelo, $vista);

    // 4. Crear y actualizar producto
    $producto = new Producto($productData);
    $controlador->edit($producto);

    // Obtener y enviar los datos
    $response = $controlador->getData();
    
    // Agregar debug info
    $response['debug'] = [
        'timestamp' => date('Y-m-d H:i:s'),
        'received_data' => $_POST,
        'processed_data' => $productData
    ];
    
    echo json_encode($response);

} catch (Exception $e) {
    // Loggear error completo
    error_log("ERROR: " . $e->getMessage() . "\n" . $e->getTraceAsString());
    
    $response = [
        'status' => 'error',
        'message' => $e->getMessage(),
        'error_code' => $e->getCode(),
        'html' => (new ProductView())->mostrarStatus([
            'status' => 'error',
            'message' => $e->getMessage()
        ]),
        'debug' => [
            'timestamp' => date('Y-m-d H:i:s'),
            'trace' => $e->getTrace()
        ]
    ];
    echo json_encode($response);
}