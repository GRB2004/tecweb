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
    <form action="http://localhost/tecweb/practicas/p06/index.php" method="GET">
        Numero: <input type="text" name="numero"><br>
        <input type="submit" name="submit">
    </form>
    <br>
    <?php
    /*
         include 'C:/xampp/htdocs/tecweb/practicas/p06/src/funciones.php';
         numero();
    */
    ?>
    <h2>Ejercicio 2</h2>
    <p>Crea un programa para la generación repetitiva de 3 números aleatorios hasta obtener una secuencia compuesta</p>
    <form action="http://localhost/tecweb/practicas/p06/index.php" method="post">
        <input type="submit" name="submit">
    </form>
    <br>
    <?php
         include 'C:/xampp/htdocs/tecweb/practicas/p06/src/funciones.php';
         matriz();
    ?>
</body>
</html>