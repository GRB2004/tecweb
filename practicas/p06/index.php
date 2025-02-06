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
    /*
         include 'C:/xampp/htdocs/tecweb/practicas/p06/src/funciones.php';
         matriz();
    */
    ?>
    <h2>Ejercicio 3</h2>
    <p>Utiliza un ciclo while para encontrar el primer número entero obtenido aleatoriamente,
pero que además sea múltiplo de un número dado.</p>
    <form action="http://localhost/tecweb/practicas/p06/index.php" method="GET">
        Numero: <input type="text" name="numero"><br>
        <input type="submit" name="submit">
    </form>
    <br>
    <?php
         /*include 'C:/xampp/htdocs/tecweb/practicas/p06/src/funciones.php';
         primerAleatorio();
         variante_aleatorio();*/
    ?>

    <h2>Ejercicio 4</h2>
    <p>Crear un arreglo cuyos índices van de 97 a 122 y cuyos valores son las letras de la ‘a’
a la ‘z’. Usa la función chr(n) que devuelve el caracter cuyo código ASCII es n para poner
el valor en cada índice.</p>
    <form action="http://localhost/tecweb/practicas/p06/index.php" method="post">
        Numero: <input type="text" name="numero"><br>
        <input type="submit" name="submit">
    </form>
    <br>
    <?php
        //include 'C:/xampp/htdocs/tecweb/practicas/p06/src/funciones.php';
        //$arreglo = arreglo_ascii(); // Llamamos a la función
        ?>

    <table border="1">
        <thead>
            <tr>
                <th>Clave</th>
                <th>Valor</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($arreglo)): ?>
                <?php foreach ($arreglo as $key => $value): ?>
                    <tr>
                        <td><?= htmlspecialchars($key) ?></td>
                        <td><?= htmlspecialchars($value) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="2">No se ha generado ningún arreglo.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>

    <h2>Ejercicio 5</h2>
    <p>Usar las variables $edad y $sexo en una instrucción if para identificar una persona de
sexo “femenino”, cuya edad oscile entre los 18 y 35 años y mostrar un mensaje de
bienvenida apropiado.</p>
    <form action="http://localhost/tecweb/practicas/p06/index.php" method="post">
        Edad: <input type="text" name="edad"><br>
        <br> 
        <label for="Masculino"><input id="Masculino"  name="sexo" type="radio" value="Masculino" checked />Masculino</label>
        <label for="Masculino"><input id="Masculino"  name="sexo" type="radio" value="Femenino"/>Femenino</label>
        <br>
        <input type="submit" name="submit">
    </form>
    <br>
    <?php
        /*
        include 'C:/xampp/htdocs/tecweb/practicas/p06/src/funciones.php';
        rango_edad();
        */
    ?>
    <h2>Ejercicio 6</h2>
    <p>Crea en código duro un arreglo asociativo que sirva para registrar el parque vehicular de
una ciudad.</p>
    <form action="http://localhost/tecweb/practicas/p06/index.php" method="post">
        Ingrese la matricula: <input type="text" name="matricula"><br>
        <input type="submit" name="submit">
        <br>
        Mostrar todos los autos registrados <br>
        <input type="submit" name="todos">
        <br>
    </form>
    <?php
         include 'C:/xampp/htdocs/tecweb/practicas/p06/src/funciones.php';
         autos();
    ?>
</body>
</html>