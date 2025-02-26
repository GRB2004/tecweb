<?php
    // Conexión a MySQL
    $link = mysqli_connect("localhost", "root", "23102005", "marketzone");
    if($link === false){
      die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
    }

    // Procesar la actualización del producto
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      $id = $_POST['id'];
      $nombre = $_POST['nombre'];
      $marca = $_POST['marca'];
      $modelo = $_POST['modelo'];
      $precio = $_POST['precio'];
      $detalles = $_POST['detalles'];
      $unidades = $_POST['unidades'];
      $imagen = $_POST['imagen'];

      $sql = "UPDATE productos SET 
                nombre = '{$nombre}', 
                marca = '{$marca}', 
                modelo = '{$modelo}', 
                precio = '{$precio}', 
                detalles = '{$detalles}', 
                unidades = '{$unidades}', 
                imagen = '{$imagen}' 
              WHERE id = '{$id}'";
      if(mysqli_query($link, $sql)){
        echo "Registro actualizado.";
        echo "<br>";
        echo "<a href='get_productos_vigentes_v2.php'>Ver get_productos_veigentes_v2.php </a>";
        echo "<br>";
        echo "<a href='get_productos_xhtml_v2.php'>Ver get_productos_xhtml_v2.php</a>";
      } else {
        echo "ERROR: No se ejecutó $sql. " . mysqli_error($link);
      }
      mysqli_close($link);
    }
  ?>