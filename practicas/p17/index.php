<?php

  use Psr\Http\Message\ResponseInterface as Response;
  use Psr\Http\Message\ServerRequestInterface as Request;
  use Slim\Factory\AppFactory;

  require 'vendor/autoload.php';
  $app = AppFactory::create();
  $app->setBasePath("/tecweb/practicas/p17");

  $app->get('/', function ( $request, $response, $args) { 
  
      $response->getBody()->write("Hola Mundo Slim!!");
      return $response;
  });

  $app->get("/hola/{nombre}", function( $request, $response, $args ){
      $response->getBody()->write("Hola, " . $args["nombre"]);
      return $response;
  });

  $app->post("/pruebapost", function( $request, $response, $args) {
    $reqPost = $request->getParsedBody();
    // Valida que los parámetros existan
    $val1 = $reqPost["val1"];
    $val2 = $reqPost["val2"];

    $response->getBody()->write("Valores: " . $val1 . " - " . $val2);
    return $response;
  });

  $app->post("/testjson", function( $request, $response, $args){ 
    $data[0]["nombre"]="Gabriel";
    $data[0]["apellidos"]="Ramírez Bañuelos";
    $data[1]["nombre"]="Liz";
    $data[1]["apellidos"]="Meactl Toxcoyoa";
    $response->getBody()->write(json_encode($data, JSON_PRETTY_PRINT));
    return $response;
  });

  $app->run();
?>