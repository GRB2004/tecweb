<!DOCTYPE html>
<html lang="es">
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
      let nombre = document.getElementById('form-name').value.trim();
      let marca = document.getElementById('marca').value.trim();
      let modelo = document.getElementById('form-modelo').value.trim();
      let precio = document.getElementById('form-precio').value.trim();
      let detalles = document.getElementById('form-detalles').value.trim();
      let imagen = document.getElementById('form-imagen').value.trim();
      const alfanumerico = /^[a-zA-Z0-9]+$/; // Solo letras y números

      // Validar que los campos obligatorios no estén vacíos
      if (nombre === "" || marca === "" || modelo === "" || precio === "") {
        alert("Todos los campos obligatorios deben estar llenos.");
        return false;
      }

      // Imagen por defecto
      if (imagen === "") {
        imagen = "tecweb/practicas/p09/imagen.png";
        document.getElementById('form-imagen').value = imagen;
      }

      // Validar longitud del nombre
      if (nombre.length > 100) {
          alert("El nombre tiene que tener 100 caracteres o menos");
          return false;
      }

      // Validar longitud del modelo
      if (modelo.length > 25) {
        alert("El modelo tiene que ser de 25 caracteres o menos");
        return false;
      }

      // Validar que el modelo sea alfanumérico
      if (!alfanumerico.test(modelo)) {
        alert("El modelo debe ser alfanumérico");
        return false;
      }

      // Validar que el precio sea un número
      if (isNaN(precio)) {
        alert("El precio debe ser un número.");
        return false;
      }

      if (Number(precio) <= 99.9) {
        alert("El precio tiene que ser mayor a 99.9");
        return false;
      }

      // Validar longitud de los detalles
      if (detalles.length > 250) {
        alert("Los detalles no deben exceder los 250 caracteres.");
        return false;
      }

      // Si todo está bien, se permite el envío
      return true;
    }
  </script>
</head>
<body>
  <form id="formulario_producto" method="post" action="update_productos.php" onsubmit="return validarFormulario()">
    <fieldset>
      <legend>Actualizar Producto</legend>
      <ul>
        <!-- Se mantiene el valor actual para el id -->
        <input type="hidden" value="<?= isset($_POST['id']) ? $_POST['id'] : (isset($_GET['id']) ? $_GET['id'] : '') ?>" name="id">
        <li>
          <label for="form-name">Nombre:</label><br>
          <input type="text" value="<?= isset($_POST['nombre']) ? $_POST['nombre'] : (isset($_GET['nombre']) ? $_GET['nombre'] : '') ?>" name="nombre" id="form-name">
        </li>
        <br>
        <li>
          <label for="marca">Selecciona una marca:</label>
          <select id="marca" name="marca">
            <option value="">Seleccione una opción</option>
            <optgroup label="Libros">
                <option value="penguin" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'penguin') || (isset($_GET['marca']) && $_GET['marca'] == 'penguin')) ? 'selected' : '' ?>>Penguin</option>
                <option value="planeta" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'planeta') || (isset($_GET['marca']) && $_GET['marca'] == 'planeta')) ? 'selected' : '' ?>>Planeta</option>
                <option value="anagrama" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'anagrama') || (isset($_GET['marca']) && $_GET['marca'] == 'anagrama')) ? 'selected' : '' ?>>Anagrama</option>
                <option value="alfaguara" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'alfaguara') || (isset($_GET['marca']) && $_GET['marca'] == 'alfaguara')) ? 'selected' : '' ?>>Alfaguara</option>
            </optgroup>
            <optgroup label="Electrónicos">
                <option value="sony" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'sony') || (isset($_GET['marca']) && $_GET['marca'] == 'sony')) ? 'selected' : '' ?>>Sony</option>
                <option value="lg" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'lg') || (isset($_GET['marca']) && $_GET['marca'] == 'lg')) ? 'selected' : '' ?>>LG</option>
                <option value="samsung" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'samsung') || (isset($_GET['marca']) && $_GET['marca'] == 'samsung')) ? 'selected' : '' ?>>Samsung</option>
                <option value="apple" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'apple') || (isset($_GET['marca']) && $_GET['marca'] == 'apple')) ? 'selected' : '' ?>>Apple</option>
            </optgroup>
            <optgroup label="Relojes">
                <option value="rolex" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'rolex') || (isset($_GET['marca']) && $_GET['marca'] == 'rolex')) ? 'selected' : '' ?>>Rolex</option>
                <option value="casio" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'casio') || (isset($_GET['marca']) && $_GET['marca'] == 'casio')) ? 'selected' : '' ?>>Casio</option>
                <option value="seiko" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'seiko') || (isset($_GET['marca']) && $_GET['marca'] == 'seiko')) ? 'selected' : '' ?>>Seiko</option>
                <option value="tag_heuer" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'tag_heuer') || (isset($_GET['marca']) && $_GET['marca'] == 'tag_heuer')) ? 'selected' : '' ?>>Tag Heuer</option>
            </optgroup>
            <optgroup label="Smartphones">
                <option value="iphone" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'iphone') || (isset($_GET['marca']) && $_GET['marca'] == 'iphone')) ? 'selected' : '' ?>>iPhone</option>
                <option value="samsung_galaxy" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'samsung_galaxy') || (isset($_GET['marca']) && $_GET['marca'] == 'samsung_galaxy')) ? 'selected' : '' ?>>Samsung Galaxy</option>
                <option value="xiaomi" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'xiaomi') || (isset($_GET['marca']) && $_GET['marca'] == 'xiaomi')) ? 'selected' : '' ?>>Xiaomi</option>
                <option value="motorola" <?= ((isset($_POST['marca']) && $_POST['marca'] == 'motorola') || (isset($_GET['marca']) && $_GET['marca'] == 'motorola')) ? 'selected' : '' ?>>Motorola</option>
            </optgroup>
          </select>
        </li>
        <br>
        <li>
          <label for="form-modelo">Modelo:</label><br>
          <input type="text" value="<?= isset($_POST['modelo']) ? $_POST['modelo'] : (isset($_GET['modelo']) ? $_GET['modelo'] : '') ?>" name="modelo" id="form-modelo">
        </li>
        <br>
        <li>
          <label for="form-precio">Precio:</label><br>
          <input type="number" value="<?= isset($_POST['precio']) ? $_POST['precio'] : (isset($_GET['precio']) ? $_GET['precio'] : '') ?>" name="precio" id="form-precio" step="0.01">
        </li>
        <br>
        <li>
          <label for="form-detalles">Detalles (opcional):</label><br>
          <textarea name="detalles" rows="4" cols="60" id="form-detalles" placeholder="No más de 250 caracteres"><?= isset($_POST['detalles']) ? $_POST['detalles'] : (isset($_GET['detalles']) ? $_GET['detalles'] : '') ?></textarea>
        </li>
        <br>
        <li>
          <label for="form-unidades">Unidades:</label><br>
          <input type="number" value="<?= isset($_POST['unidades']) ? $_POST['unidades'] : (isset($_GET['unidades']) ? $_GET['unidades'] : '') ?>" name="unidades" id="form-unidades">
        </li>
        <br>
        <li>
          <label for="form-imagen">Imagen (opcional):</label><br>
          <input type="text" name="imagen" value="<?= isset($_POST['imagen']) ? $_POST['imagen'] : (isset($_GET['imagen']) ? $_GET['imagen'] : '') ?>" id="form-imagen">
        </li>
      </ul>
    </fieldset>
    <p>
      <input type="submit" value="Enviar">
      <input type="reset" value="Limpiar">
    </p>
  </form>
</body>
</html>



