<?php
  include_once __DIR__.'/database.php';

  $id = $_POST['id'];

  $query = "SELECT 
              id,
              nombre,
              precio,
              unidades,
              modelo,
              marca,
              detalles,
              imagen 
            FROM productos 
            WHERE id = ?";
  $stmt = $conexion->prepare($query);
  $stmt->bind_param("i", $id);
  $stmt->execute();

  $result = $stmt->get_result();

  if ($row = $result->fetch_assoc()) {
      $nombre = $row['nombre'];
      $json = array(
          'precio'   => $row['precio'],
          'unidades' => $row['unidades'],
          'modelo'   => $row['modelo'],
          'marca'    => $row['marca'],
          'detalles' => $row['detalles'],
          'imagen'   => $row['imagen']
      );

      // Incluimos el id en la respuesta JSON
      $output = array(
          'id'     => $row['id'],
          'nombre' => $nombre,
          'json'   => $json
      );

      echo json_encode($output);
  }
?>



