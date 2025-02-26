<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Formulario Productos</title>
  <style>
    li {
      list-style-type: none;
    }
  </style>
  <script>
    function validarFormulario() {
      // Obtener los valores de los campos
      const nombre = document.getElementById('form-name').value.trim();
      const marca = document.getElementById('marca').value.trim();
      const modelo = document.getElementById('form-modelo').value.trim();
      const precio = document.getElementById('form-precio').value.trim();
      const detalles = document.getElementById('form-detalles').value.trim();
      const imagen = document.getElementById('form-imagen').value.trim();
      const alfanumerico = /^[a-zA-Z0-9]+$/; // Solo letras y números

      // Validar que los campos no estén vacíos
      if (nombre === "" || marca ==="" || modelo === "" || precio === "") {
        alert("Todos los campos son obligatorios.");
        return false;
      }

      //Imagen por defecto
      if (imagen === "") {
        imagen = "tecweb/practicas/p09/imagen.png";
        alert(imagen);
      }

      //Nombre tiene que tener 100 caracteres o menos
      if (nombre.length > 100) {
          alert("El nombre tiene que tener 100 caracteres o menos");
          return false;
      }

      if (modelo.length > 25) {
        alert("El modelo tiene que ser de 25 caracteres o menos");
        return false;
      }

      // Validar que el modelo sea alfanumérico
      if (!alfanumerico.test(modelo)) {
        alert("El modelo debe ser alfanúmerico");
        return false;
    }

      // Validar que el precio sea un número
      if (isNaN(precio)) {
        alert("El precio debe ser un número.");
        return false;
      }

      if (precio <= 99.9) {
        alert("El precio tiene que ser mayor a 99.9");
      }

      // Validar la longitud de los detalles
      if (detalles.length > 250) {
        alert("Los detalles no deben exceder los 250 caracteres.");
        return false;
      }

      // Si todo está bien, permitir el envío del formulario
      return true;
    }
  </script>
</head>
<body>
  <form id="formulario_producto" method="post" action="http://localhost/tecweb/practicas/p09/formulario_productos_v2.php" onsubmit="return validarFormulario() ">
    <fieldset>
      <legend>Actualizar Producto</legend>
      <ul>
        <input type="hidden" value="<?=$_POST['id']?>" name="id">
        <li><label for="form-name">Nombre:</label> <br> <input type="text" value="<?= !empty($_POST['nombre'])?$_POST['nombre']:$_GET['nombre'] ?>" name="nombre" id="form-name"></li> <br>
        <li>
          <label for="">Selecciona una marca:</label>
    <select id="marca" name="marca">
        <option value="">Seleccione una opción</option>

        <optgroup label="Libros">
            <option value="penguin" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'penguin') ? 'selected' : ''?>>Penguin</option>
            <option value="planeta" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'planeta') ? 'selected' : ''?>>Planeta</option>
            <option value="anagrama" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'anagrama') ? 'selected' : ''?>>Anagrama</option>
            <option value="alfaguara" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'Alfaguara') ? 'selected' : ''?>>Alfaguara</option>
        </optgroup>

        <optgroup label="Electrónicos">
            <option value="sony" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'sony') ? 'selected' : ''?>>Sony</option>
            <option value="lg" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'lg') ? 'selected' : ''?>>LG</option>
            <option value="samsung" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'samsung') ? 'selected' : ''?>>Samsung</option>
            <option value="apple" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'apple') ? 'selected' : ''?>>Apple</option>
        </optgroup>

        <optgroup label="Relojes">
            <option value="rolex" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'rolex') ? 'selected' : ''?>>Rolex</option>
            <option value="casio" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'casio') ? 'selected' : ''?>>Casio</option>
            <option value="seiko" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'seiko') ? 'selected' : ''?>>Seiko</option>
            <option value="tag_heuer" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'tag_huer') ? 'selected' : ''?>>Tag Heuer</option>
        </optgroup>

        <optgroup label="Smartphones">
            <option value="iphone" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'iphone') ? 'selected' : ''?>>iPhone</option>
            <option value="samsung_galaxy" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'samsung_galaxy') ? 'selected' : ''?>>Samsung Galaxy</option>
            <option value="xiaomi" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'xiaomi') ? 'selected' : ''?>>Xiaomi</option>
            <option value="motorola" <?= (!empty($_GET['marca']) && $_GET['marca'] == 'motorola') ? 'selected' : ''?>>Motorola</option>
        </optgroup>
        
    </select>
        </li> 
        
        <br>

        <li><label for="form-modelo" >Modelo:</label> <br> <input type="text" value="<?= !empty($_POST['modelo'])?$_POST['modelo']:$_GET['modelo'] ?>" name="modelo" id="form-modelo"></li> <br>
        <li><label for="form-precio">Precio:</label> <br> <input type="number" value="<?= !empty($_POST['precio'])?$_POST['precio']:$_GET['precio'] ?>" name="precio" id="form-precio"></li> <br>
        <li>
        <label for="form-detalles">Detalles (opcional):</label><br>
        <textarea name="detalles" rows="4" cols="60" id="form-detalles" placeholder="No más de 250 caracteres de longitud"> <?= !empty($_POST['detalles']) ? $_POST['detalles'] : $_GET['detalles'] ?>
        </textarea>
        </li> <br>
        <li><label for="form-unidades">Unidades:</label> <input type="number" value="<?= !empty($_POST['unidades'])?$_POST['unidades']:$_GET['unidades'] ?>" name="unidades" id="form-unidades"></li> <br>
        <li><label for="form-imagen">Imagen (opcional):</label> <br> <input type="text" name="imagen" value="<?= !empty($_POST['imagen'])?$_POST['imagen']:$_GET['imagen'] ?>" id="form-imagen"></li>
      </ul>
    </fieldset>

    <p>
      <input type="submit"  value="Enviar">
      <input type="reset" value="Limpiar">
    </p>
  </form>
  <?php
    /* MySQL Conexion*/
      $link = mysqli_connect("localhost", "root", "23102005", "marketzone");
      // Chequea coneccion
      if($link === false){
      die("ERROR: No pudo conectarse con la DB. " . mysqli_connect_error());
      }

      // Obtener datos del formulario
      if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $marca = $_POST['marca'];
        $modelo = $_POST['modelo'];
        $precio = $_POST['precio'];
        $detalles = $_POST['detalles'];
        $unidades = $_POST['unidades'];
        $imagen = $_POST['imagen'];
        // ...
        // Actualizar los datos del producto
      $sql = "UPDATE productos SET nombre = '{$nombre}', marca = '{$marca}', modelo = '{$modelo}', precio =   '{$precio}', detalles = '{$detalles}', unidades = '{$unidades}', imagen = '{$imagen}' WHERE id = '{$id}'";
      if(mysqli_query($link, $sql)){
      echo "Registro actualizado.";
      } else {
      echo "ERROR: No se ejecuto $sql. " . mysqli_error($link);
      }
      // Cierra la conexion
      mysqli_close($link);
    }
    
  ?>
</body>
</html>


