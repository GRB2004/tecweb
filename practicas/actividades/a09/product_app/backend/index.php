<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use myapi\Read\Read as Read;
use myapi\Create\Create as Create;
use myapi\Update\Update as Update;
use myapi\Delete\Delete as Delete;

require_once __DIR__ . '/myapi/Producto.php';
require_once __DIR__ . '/myapi/ProductoEdit.php';
require __DIR__ . '/../vendor/autoload.php'; // Si index.php está en "backend"

$app = AppFactory::create();
$app->setBasePath("/tecweb/practicas/actividades/a09/product_app/backend");

// Definir la ruta GET para obtener un producto por ID
$app->get('/product/{id}', function (Request $request, Response $response, $args) {
    // Obtener el ID de los parámetros de la ruta
    $id = $args['id'];
    
    // Crear instancia de Read con las credenciales correctas
    $prodObj = new Read('root', '23102005', 'marketzone');
    
    // Buscar el producto por ID
    $prodObj->single($id);
    
    // Obtener los datos y enviarlos como respuesta
    $data = $prodObj->getData();
    $response->getBody()->write($data);
    
    // Opcional: Establecer cabecera JSON si aplica
    return $response->withHeader('Content-Type', 'application/json');
});

// Definir la ruta GET para obtener un producto por ID
$app->get('/products', function (Request $request, Response $response, $args) {

    $prodObj = new Read('root', '23102005','marketzone');
    $prodObj->list();
    
    // Obtener los datos y enviarlos como respuesta
    $data = $prodObj->getData();
    $data = json_encode($data);
    $response->getBody()->write($data);
    
    // Opcional: Establecer cabecera JSON si aplica
    return $response->withHeader('Content-Type', 'application/json');
});

// Ruta GET para buscar productos (usa query parameters)
$app->get('/products/search', function (Request $request, Response $response, $args) {
    $prodObj = new Read('root', '23102005', 'marketzone');
    
    // Obtener el parámetro 'search' de la URL (ej: /products?search=apple)
    $search = $request->getQueryParams()['search'] ?? null;
    
    if ($search) {
        $prodObj->search($search);
        $data = $prodObj->getData();
        $response->getBody()->write($data);
    } else {
        // Retorna un JSON si no se envía 'search'
        $response->getBody()->write(json_encode(['error' => 'Parámetro "search" requerido']));
        $response = $response->withStatus(400);
    }
    
    return $response->withHeader('Content-Type', 'application/json');
});

$app->post('/product', function (Request $request, Response $response, $args) {
    try {
        
        // Crear instancia de Create
        $prodObj = new Create('root', '23102005', 'marketzone');

        // Asignar la instancia a la clase Producto
        Producto::setProductsObject($prodObj);

        // Obtener los datos del formulario
        $parsedBody = $request->getParsedBody();
        
        $nombre   = $parsedBody['nombre'] ?? '';
        $marca    = $parsedBody['marca'] ?? '';
        $modelo   = $parsedBody['modelo'] ?? '';
        $precio   = is_numeric($parsedBody['precio'] ?? '') ? $parsedBody['precio'] : 0;
        $unidades = is_numeric($parsedBody['unidades'] ?? '') ? $parsedBody['unidades'] : 0;
        $detalles = $parsedBody['detalles'] ?? '';
        $imagen   = $parsedBody['imagen'] ?? '';

        // Crear el producto (esto invoca productAdd() automáticamente)
        $producto = new Producto($nombre, $marca, $modelo, $precio, $unidades, $detalles, $imagen);

        // Obtener los datos de la operación
        $resultData = $prodObj->getData();
        
        // Preparar la respuesta JSON
        $response->getBody()->write($resultData);
        return $response->withHeader('Content-Type', 'application/json');
    } catch (Exception $e) {
        // En caso de error, devolver un mensaje JSON de error
        $errorResponse = json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
        
        $response->getBody()->write($errorResponse);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus(500);
    }
});

// Ruta PUT para actualizar producto (sin ID en la URL)
$app->put('/product', function (Request $request, Response $response) {
    try {
        // Obtener los datos del cuerpo de diferentes maneras
        $data = $request->getParsedBody(); // Esto puede no funcionar para PUT en Slim
        
        // Si $data está vacío, intentar obtener los datos de entrada brutos
        if (empty($data)) {
            // Intentar obtener los datos de php://input
            $inputData = file_get_contents('php://input');
            parse_str($inputData, $data);
            
            // Si aún está vacío, intentar obtener datos directamente de $_POST
            if (empty($data)) {
                $data = $_POST;
            }
        }
        
        // Depuración: Guardar lo que se está recibiendo (opcional)
        file_put_contents('debug_put.log', print_r([
            'parsed_body' => $request->getParsedBody(),
            'input_data' => file_get_contents('php://input'),
            'post' => $_POST,
            'final_data' => $data
        ], true));
        
        // Validar que el ID existe en el cuerpo
        if (!isset($data['id']) || !is_numeric($data['id'])) {
            throw new Exception("ID de producto inválido o faltante", 400);
        }

        $prodObj = new Update('root', '23102005', 'marketzone');
        ProductoEdit::setProductsObject($prodObj);

        // Validar campos requeridos
        $required = ['nombre', 'marca', 'modelo', 'precio', 'unidades', 'detalles', 'imagen'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                throw new Exception("El campo $field es requerido", 400);
            }
        }

        // Crear instancia de ProductoEdit
        $producto = new ProductoEdit(
            $data['id'],  // ID ahora viene del cuerpo
            $data['nombre'],
            $data['marca'],
            $data['modelo'],
            (float)$data['precio'],
            (int)$data['unidades'],
            $data['detalles'],
            $data['imagen']
        );

        // Obtener datos de la respuesta
        $responseData = $prodObj->getData();
        
        // Verificar si ya es un JSON válido
        $result = json_decode($responseData);
        if (json_last_error() === JSON_ERROR_NONE) {
            // Si ya es un JSON válido, lo enviamos directamente
            $response->getBody()->write($responseData);
            return $response->withHeader('Content-Type', 'application/json');
        } else {
            // Si no es un JSON válido, creamos uno
            $jsonResponse = json_encode([
                'status' => 'success',
                'message' => 'Producto actualizado',
                'data' => $responseData
            ]);
            
            $response->getBody()->write($jsonResponse);
            return $response->withHeader('Content-Type', 'application/json');
        }

    } catch (Exception $e) {
        $jsonError = json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
        
        $response->getBody()->write($jsonError);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($e->getCode() ?: 500);
    }
});

$app->delete('/product', function (Request $request, Response $response, $args) {
    try {
        
        
        // Crear instancia de Delete
        $prodObj = new \myapi\Delete\Delete('root', '23102005', 'marketzone');
        
        // Obtener los parámetros de la solicitud
        // Primero intentar obtener desde query params (similar a $_GET)
        $queryParams = $request->getQueryParams();
        $id = $queryParams['id'] ?? null;
        
        // Si no está en query params, intentar obtener del cuerpo (en caso de DELETE con body)
        if (!$id) {
            $parsedBody = $request->getParsedBody();
            $id = $parsedBody['id'] ?? null;
            
            // Si aún no hay ID, intentar obtener de php://input
            if (!$id) {
                $inputData = file_get_contents('php://input');
                parse_str($inputData, $data);
                $id = $data['id'] ?? null;
            }
        }
        
        // Verificar que se recibió el ID
        if (!$id) {
            throw new Exception("ID de producto no proporcionado", 400);
        }
        
        // Log para depuración
        file_put_contents('debug_delete.log', "ID recibido: $id\n", FILE_APPEND);
        
        // Ejecutar la eliminación
        $prodObj->delete($id);
        
        // Obtener datos de la respuesta y asegurar que sea un JSON válido
        // En lugar de confiar en getData(), creamos nuestra propia respuesta JSON
        $jsonResponse = json_encode([
            'status' => 'success',
            'message' => 'Producto eliminado correctamente',
            'id' => $id
        ]);
        
        $response->getBody()->write($jsonResponse);
        return $response->withHeader('Content-Type', 'application/json');
        
    } catch (Exception $e) {
        $jsonError = json_encode([
            'status' => 'error',
            'message' => $e->getMessage()
        ]);
        
        $response->getBody()->write($jsonError);
        return $response
            ->withHeader('Content-Type', 'application/json')
            ->withStatus($e->getCode() ?: 500);
    }
});

$app->run();

?>