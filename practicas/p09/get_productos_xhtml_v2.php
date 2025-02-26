<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN"
"http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
	<?php
	if(isset($_GET['tope']))
		$tope = $_GET['tope'];

	if (!empty($tope))
	{
		/** SE CREA EL OBJETO DE CONEXION */
		@$link = new mysqli('localhost', 'root', '23102005', 'marketzone');	

		/** comprobar la conexión */
		if ($link->connect_errno) 
		{
			die('Falló la conexión: '.$link->connect_error.'<br/>');
			    /** NOTA: con @ se suprime el Warning para gestionar el error por medio de código */
		}

		/** Crear una tabla que devuelve un conjunto de resultados */
		if ( $result = $link->query("SELECT * FROM productos WHERE unidades <= $tope") ) 
		{
			$rows = $result->fetch_all(MYSQLI_ASSOC);
			/** útil para liberar memoria asociada a un resultado con demasiada información */
			$result->free();
		}

		$link->close();
	}
	?>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
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
                // se obtiene el id de la fila donde está el botón presinado
                var rowId = event.target.parentNode.parentNode.id;
								//var row = event.target.closest("tr");
                // se obtienen los datos de la fila en forma de arreglo
                var data = document.getElementById(rowId).querySelectorAll(".row-data");
                /**
                querySelectorAll() devuelve una lista de elementos (NodeList) que 
                coinciden con el grupo de selectores CSS indicados.
                (ver: https://developer.mozilla.org/en-US/docs/Web/CSS/CSS_Selectors)

                En este caso se obtienen todos los datos de la fila con el id encontrado
                y que pertenecen a la clase "row-data".
                */

                var nombre = data[1].innerHTML;
                var marca = data[2].innerHTML;
								var modelo = data[3].innerHTML;
								var precio = data[4].innerHTML;
								var unidades = data[5].innerHTML;
								var detalles = data[6].innerHTML;
								var imagen = data[7].firstChild.getAttribute('src');


                alert("Nombre: " + nombre + "\nMarca: " + marca + "\nModelo: " + modelo + "\nPrecio: " + precio + "\nUnidades: " + unidades + "\nDetalles: " + detalles + "\nImagen: " + imagen);

                send2form(nombre, marca, modelo, precio, unidades, detalles, imagen);
            }
		</script>
	</head>
	<body>
		<h3>PRODUCTOS</h3>
		
		<?php if( isset($rows) && !empty($rows) ) : ?>

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
					<tr id="fila-<?= $row['id'] ?>">
						<th scope="row" class="row-data"><?= $row['id'] ?></th>
						<td class="row-data"><?= $row['nombre'] ?></td>
						<td class="row-data"><?= $row['marca'] ?></td>
						<td class="row-data"><?= $row['modelo'] ?></td>
						<td class="row-data"><?= $row['precio'] ?></td>
						<td class="row-data"><?= $row['unidades'] ?></td>
						<td class="row-data"><?= utf8_encode($row['detalles']) ?></td>
						<td class="row-data"><img src="<?= $row['imagen'] ?>" alt="producto" width="100"/></td>
						<td><button onclick="show()" value="submit">Modificar</button></td>
					</tr>
					<?php endforeach; ?>
				</tbody>
			</table>

		<?php elseif(!empty($tope)) : ?>

			<script type="text/javascript">
        alert('El ID del producto no existe');
      </script>

		<?php endif; ?>

		<p>
    <a href="https://validator.w3.org/markup/check?uri=referer"><img
      src="https://www.w3.org/Icons/valid-xhtml11" alt="Valid XHTML 1.1" height="31" width="88" /></a>
  </p>

			<script>
				function send2form(nombre, marca, modelo, precio, unidades, detalles, imagen) {
                var form = document.createElement("form");

                var nombreIn = document.createElement("input");
                nombreIn.type = 'text';
                nombreIn.name = 'nombre';
                nombreIn.value = nombre;
                form.appendChild(nombreIn);

								var selectMarca = document.createElement("select");

                var defaultOption = document.createElement("option");
								defaultOption.value = "";
								defaultOption.textContent = "Seleccione una opción";
								selectMarca.appendChild(defaultOption);

								// Definir las categorías y sus marcas
								var categorias = {
										"Libros": ["Penguin", "Planeta", "Anagrama", "Alfaguara"],
										"Electrónicos": ["Sony", "LG", "Samsung", "Apple"],
										"Relojes": ["Rolex", "Casio", "Seiko", "Tag Heuer"],
										"Smartphones": ["iPhone", "Samsung Galaxy", "Xiaomi", "Motorola"]
								};

								// Recorrer las categorías para crear <optgroup> y sus <option>
								for (var categoria in categorias) {
										var optgroup = document.createElement("optgroup");
										optgroup.label = categoria;

										categorias[categoria].forEach(function(marca) {
												var option = document.createElement("option");
												option.value = marca.toLowerCase().replace(/\s+/g, "_"); // Normaliza el valor
												option.textContent = marca;
												optgroup.appendChild(option);
										});

										selectMarca.appendChild(optgroup);
								}

								// Agregar el <select> al formulario o al documento
								document.body.appendChild(selectMarca);

								var modeloIn = document.createElement("input");
                modeloIn.type = 'text';
                modeloIn.name = 'modelo';
                modeloIn.value = modelo;
                form.appendChild(modeloIn);

								var precioIn = document.createElement("input");
                precioIn.type = 'number';
                precioIn.name = 'precio';
                precioIn.value = precio;
                form.appendChild(precioIn);

								var unidadIn = document.createElement("input");
                unidadIn.type = 'number';
                unidadIn.name = 'unidades';
                unidadIn.value = unidades;
                form.appendChild(unidadIn);

								var detalleIn = document.createElement("textarea");
                detalleIn.name = 'detalles';
								detalleIn.rows = '4';
								detalleIn.cols = '60';
								detalleIn.value = detalles;
                form.appendChild(detalleIn);

								var unidadesIn = document.createElement("input");
								unidadesIn.type = 'number';
								unidadesIn.name = 'unidades';
								unidadesIn.value = unidades;
								form.appendChild(unidadesIn);

								var imagenIn = document.createElement("input");
                imagenIn.type = 'text';
                imagenIn.name = 'imagen';
                imagenIn.value = imagen;
                form.appendChild(imagenIn);

                console.log(form);

                form.method = 'GET';
                form.action = 'formulario_productos_v2.php';  

                document.body.appendChild(form);
                form.submit();
            }
			</script>
	</body>
</html>