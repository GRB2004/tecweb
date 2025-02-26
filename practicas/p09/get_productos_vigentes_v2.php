<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Productos</title>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" />
  <style>
    button {
      border: none;
      color: white;
      background-color: green;
    }
  </style>
  <script>
    function show() {
      // Se obtiene la fila donde se presionó el botón
      var row = event.target.closest("tr");
      var data = row.querySelectorAll(".row-data");

      var id = data[0].textContent;
      var nombre = data[1].textContent;
      var marca = data[2].textContent.toLowerCase(); // Aseguramos que el valor coincida con los option
      var modelo = data[3].textContent;
      var precio = data[4].textContent;
      var unidades = data[5].textContent;
      var detalles = data[6].textContent;
      // Para la imagen se obtiene el atributo src
      var imgElement = data[7].querySelector("img");
      var imagen = imgElement ? imgElement.getAttribute("src") : "";

			alert("id " + id + "\nNombre:" + nombre + "\nMarca:" + marca + "\nModelo:" + modelo + "\nPrecio:" + precio + "\nUnidades" + unidades + "\nDetalles" + "\nimagen: " + imagen );

      // Enviar datos al formulario
      send2form(id, nombre, marca, modelo, precio, unidades, detalles, imagen);
    }

    function send2form(id, nombre, marca, modelo, precio, unidades, detalles, imagen) {
      // Crear un formulario dinámico con método POST
      var form = document.createElement("form");
      form.method = "POST";
      form.action = "formulario_productos_v2.php";

      // Campo oculto para el id
      var idIn = document.createElement("input");
      idIn.type = "hidden";
      idIn.name = "id";
      idIn.value = id;
      form.appendChild(idIn);

      // Nombre
      var nombreIn = document.createElement("input");
      nombreIn.type = "text";
      nombreIn.name = "nombre";
      nombreIn.value = nombre;
      form.appendChild(nombreIn);

      // Marca (select)
      var selectMarca = document.createElement("select");
      selectMarca.name = "marca";

      // Opción por defecto
      var defaultOption = document.createElement("option");
      defaultOption.value = "";
      defaultOption.textContent = "Seleccione una opción";
      selectMarca.appendChild(defaultOption);

      // Categorías y sus marcas (valores en minúsculas para consistencia)
      var categorias = {
        "Libros": ["penguin", "planeta", "anagrama", "alfaguara"],
        "Electrónicos": ["sony", "lg", "samsung", "apple"],
        "Relojes": ["rolex", "casio", "seiko", "tag_heuer"],
        "Smartphones": ["iphone", "samsung_galaxy", "xiaomi", "motorola"]
      };

      for (var categoria in categorias) {
        var optgroup = document.createElement("optgroup");
        optgroup.label = categoria;
        categorias[categoria].forEach(function(item) {
          var option = document.createElement("option");
          option.value = item;
          // Para mostrar la marca con la primera letra en mayúscula
          option.textContent = item.charAt(0).toUpperCase() + item.slice(1);
          if (item === marca) {
            option.selected = true;
          }
          optgroup.appendChild(option);
        });
        selectMarca.appendChild(optgroup);
      }
      form.appendChild(selectMarca);

      // Modelo
      var modeloIn = document.createElement("input");
      modeloIn.type = "text";
      modeloIn.name = "modelo";
      modeloIn.value = modelo;
      form.appendChild(modeloIn);

      // Precio
      var precioIn = document.createElement("input");
      precioIn.type = "number";
      precioIn.name = "precio";
      precioIn.value = precio;
      precioIn.step = "0.01";
      form.appendChild(precioIn);

      // Unidades
      var unidadesIn = document.createElement("input");
      unidadesIn.type = "number";
      unidadesIn.name = "unidades";
      unidadesIn.value = unidades;
      form.appendChild(unidadesIn);

      // Detalles
      var detalleIn = document.createElement("textarea");
      detalleIn.name = "detalles";
      detalleIn.rows = 4;
      detalleIn.cols = 60;
      detalleIn.textContent = detalles;
      form.appendChild(detalleIn);

      // Imagen
      var imagenIn = document.createElement("input");
      imagenIn.type = "text";
      imagenIn.name = "imagen";
      imagenIn.value = imagen;
      form.appendChild(imagenIn);

      document.body.appendChild(form);
      form.submit();
    }
  </script>
</head>
<body>
  <h3>PRODUCTOS</h3>
  <?php
    @$link = new mysqli('localhost', 'root', '23102005', 'marketzone');  
    if ($link->connect_errno) {
      die('Falló la conexión: ' . $link->connect_error . '<br/>');
    }
    if ($result = $link->query("SELECT * FROM productos WHERE eliminado != 1")) {
      $rows = $result->fetch_all(MYSQLI_ASSOC);
      $result->free();
    }
    $link->close();
  ?>
  <?php if (isset($rows) && !empty($rows)) : ?>
  <table class="table">
    <thead class="thead-dark">
      <tr>
        <th scope="col">#</th>
        <th scope="col">Nombre</th>
        <th scope="col">Marca</th>
        <th scope="col">Modelo</th>
        <th scope="col">Precio</th>
        <th scope="col">Unidades</th>
        <th scope="col">Detalles</th>
        <th scope="col">Imagen</th>
        <th scope="col">Modificar</th>
      </tr>
    </thead>
    <tbody>
      <?php foreach ($rows as $row) : ?>
      <tr>
        <td class="row-data"><?= $row['id'] ?></td>
        <td class="row-data"><?= $row['nombre'] ?></td>
        <td class="row-data"><?= $row['marca'] ?></td>
        <td class="row-data"><?= $row['modelo'] ?></td>
        <td class="row-data"><?= $row['precio'] ?></td>
        <td class="row-data"><?= $row['unidades'] ?></td>
        <td class="row-data"><?= utf8_encode($row['detalles']) ?></td>
        <td class="row-data"><img src="<?= $row['imagen'] ?>" alt="producto" width="100"/></td>
        <td><button onclick="show()" type="button">Modificar</button></td>
      </tr>
      <?php endforeach; ?>
    </tbody>
  </table>
  <?php endif; ?>
  <p>
    <a href="https://validator.w3.org/markup/check?uri=referer">
      <img src="https://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="31" width="88" />
    </a>
  </p>
</body>
</html>
