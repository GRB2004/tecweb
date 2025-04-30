<?php

use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;
use Slim\Factory\AppFactory;
use myapi\Read\Read as Read;

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

$app->run();

?>