<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Práctica 4</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Escribir programa para comprobar si un número es un múltiplo de 5 y 7</p>

    <!-- Formulario para ingresar el número -->
    <form action="http://localhost/tecweb/practicas/p06/index.php" method="post">
        Número: <input type="text" name="numero"><br>
        <input type="submit" name="submit">
    </form>

    <?php
    // Verificar si el formulario ha sido enviado
    // Incluir el archivo funciones.php
    include 'C:/xampp/htdocs/tecweb/practicas/p06/src/funciones.php';
    if (isset($_POST['submit'])) {
        if (isset($_POST['numero']) && !empty($_POST['numero'])) {
            $numero = $_POST['numero'];
            // Llamar a la función multiplo
            multiplo($numero);
        } else {
            echo '<p>Por favor, ingresa un número.</p>';
        }
    }
    ?>
</body>
</html>