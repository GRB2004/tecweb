<?php
  // product-edit.php

  // Indicamos que la respuesta se devolverá como JSON
  header('Content-Type: application/json; charset=utf-8');

  include_once __DIR__.'/database.php';

  // 1. Leemos el cuerpo crudo de la petición (en formato JSON)
  $rawData = file_get_contents('php://input');
  $data = json_decode($rawData, true);

  // 2. Validamos que exista contenido JSON válido
  if (!$data) {
      echo json_encode([
          'status'  => 'error',
          'message' => 'No se recibió JSON válido'
      ]);
      exit;
  }

  // 3. Extraemos campos desde el array $data
  //    Ajusta estos nombres a lo que envías desde tu JavaScript
  $productId = isset($data['productId']) ? (int)$data['productId'] : null;
  $nombre    = isset($data['nombre'])    ? trim($data['nombre'])    : '';
  $precio    = isset($data['precio'])    ? (float)$data['precio']   : 0;
  $unidades  = isset($data['unidades'])  ? (int)$data['unidades']   : 0;
  $modelo    = isset($data['modelo'])    ? trim($data['modelo'])    : '';
  $marca     = isset($data['marca'])     ? trim($data['marca'])     : '';
  $detalles  = isset($data['detalles'])  ? trim($data['detalles'])  : '';
  $imagen    = isset($data['imagen'])    ? trim($data['imagen'])    : '';

  // 4. Validamos si falta algún campo importante (por ejemplo, el ID del producto)
  if (!$productId) {
      echo json_encode([
          'status'  => 'error',
          'message' => 'No se proporcionó un ID de producto válido'
      ]);
      exit;
  }

  // 5. Preparamos la consulta para editar el producto
  //    Ajusta las columnas y su orden a tu tabla de "productos"
  $query = "UPDATE productos
            SET nombre = ?,
                precio = ?,
                unidades = ?,
                modelo = ?,
                marca = ?,
                detalles = ?,
                imagen = ?
            WHERE id = ?";

  $stmt = $conexion->prepare($query);
  if (!$stmt) {
      echo json_encode([
          'status'  => 'error',
          'message' => 'Error al preparar la consulta: ' . $conexion->error
      ]);
      exit;
  }

  // 6. Asociamos parámetros a la consulta
  //    - s: string
  //    - d: double (float)
  //    - i: integer
  //    - Si el orden cambia, ajusta correspondientemente
  $stmt->bind_param("sdissssi",
      $nombre,    // s
      $precio,    // d (float)
      $unidades,  // i
      $modelo,    // s
      $marca,     // s
      $detalles,  // s
      $imagen,    // s
      $productId  // i
  );

  // 7. Ejecutamos la consulta
  if ($stmt->execute()) {
      echo json_encode([
          'status'  => 'success',
          'message' => 'Producto editado correctamente'
      ]);
  } else {
      echo json_encode([
          'status'  => 'error',
          'message' => 'Error al editar el producto: ' . $stmt->error
      ]);
  }

?>