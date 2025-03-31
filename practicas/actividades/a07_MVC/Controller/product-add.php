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
    
       

try {
    
    $modelo = new ProductModel('root', '23102005', 'marketzone');
    $vista = new ProductView();
    $controlador = new ProductsController($modelo, $vista);

    $datosProducto = [
        'nombre' => $_POST['nombre'],
        'marca' => $_POST['marca'],
        'modelo' => $_POST['modelo'],
        'precio' => (float)$_POST['precio'],
        'unidades' => (int)$_POST['unidades'],
        'detalles' => $_POST['detalles'],
        'imagen' => $_POST['imagen']
    ];

    $producto = new Producto($datosProducto);

    // 5. Ejecución del flujo MVC
    $controlador->productAdd($producto);
    
} catch (Exception $e) {
    // 6. Manejo centralizado de errores
    $response = [
        'status' => 'error',
        'message' => $e->getMessage(),
        'html' => (new ProductView())->mostrarStatus([
            'status' => 'error',
            'message' => $e->getMessage()
        ])
    ];
    echo json_encode($response);
    exit;
}

?>