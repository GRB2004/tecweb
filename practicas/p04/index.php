<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.1//EN" "http://www.w3.org/TR/xhtml11/DTD/xhtml11.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="es">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Práctica 3</title>
</head>
<body>
    <h2>Ejercicio 1</h2>
    <p>Determina cuál de las siguientes variables son válidas y explica por qué:</p>
    <p>$_myvar,  $_7var,  myvar,  $myvar,  $var7,  $_element1, $house*5</p>
    <?php
        //AQUI VA MI CÓDIGO PHP
        $_myvar;
        $_7var;
        //myvar;       // Inválida
        $myvar;
        $var7;
        $_element1;
        //$house*5;     // Invalida

        echo '<h4>Respuesta:</h4>';   
    
        echo '<ul>';
        echo '<li>$_myvar es válida porque inicia con guión bajo.</li>';
        echo '<li>$_7var es válida porque inicia con guión bajo.</li>';
        echo '<li>myvar es inválida porque no tiene el signo de dolar ($).</li>';
        echo '<li>$myvar es válida porque inicia con una letra.</li>';
        echo '<li>$var7 es válida porque inicia con una letra.</li>';
        echo '<li>$_element1 es válida porque inicia con guión bajo.</li>';
        echo '<li>$house*5 es inválida porque el símbolo * no está permitido.</li>';
        echo '</ul>';

    ?>
    <h2>Ejercicio 2</h2>
    <p>Proporcionar los valores de $a, $b, $c como sigue:</p>
    <?php
        $a = "PHP server";
        $b = &$a;
        $c = &$a;
        echo '<ul>';
        echo "<li>Mostrando a $a</li>";
        echo "<li>Mostrando a $b</li>";
        echo "<li>Mostrando a $c</li>";
        echo '</ul>';
    ?>
        <p>Lo que ocurrio en el segundo bloque de asignaciones es que todas las variables tenian el valor de PHP server</p>
        <p>porque en la variable b se hacia una referencia a y en la c tambien se hacia una referencia a esta misma variable.</p>

    <h2>Ejercicio 3</h2>
    <p>
        Muestra el contenido de cada variable inmediatamente después de cada asignación,
        verificar la evolución del tipo de estas variables (imprime todos los componentes de los
        arreglo):
    </p>
    <?php
        $a = "PHP5";
        echo "<li>Mostrando variable a: $a</li>";
        $z[] = "MySQL";
        var_dump($z);
        $b = "5a version de PHP";
        echo "<li>Mostrando a variable b: $b</li>";
        $c = $b*10;
        echo "<li>Mostrando a variable c: $c</li>";
        $a .= $b;
        echo "<li>Mostrando a variable a: $a</li>";
        $b *= $c;
        echo "<li>Mostrando a variable b: $b</li>";
        
    ?>
    <h2>Ejercicio 4</h2>
    <?php
        $GLOBALS['a'];
        echo "\$GLOBALS['a'] = " . $GLOBALS['a'] . "\n";
        $GLOBALS['z'];
        var_dump($z);
        $GLOBALS['b'];
        echo "\$GLOBALS['b'] = " . $GLOBALS['b'] . "\n";
        $GLOBALS['c'];
        echo "\$GLOBALS['c'] = " . $GLOBALS['c'] . "\n";
    ?>

    <h2>Ejercicio 5</h2>
    <?php
        $a = "7 personas";
        $b = (integer) $a;
        $a = "9E3";
        $c = (double) $a;

        echo "\$a = $a <br>";
        echo "\$b = $b <br>";
        echo "\$c = $c <br>";
    ?>

    <h2>Ejercicio 6</h2>
    <?php
        $a = "0";
        $b = "TRUE";
        $c = FALSE;
        $d = ($a OR $b);
        $e = ($a AND $c);
        $f = ($a XOR $b);

        echo "Valor booleano de \$a: <br>";
        var_dump($a);
        echo "<br> Valor booleano de \$b: <br>";
        var_dump($b);
        echo "<br> Valor booleano de \$c: <br>";
        var_dump($c);
        echo "<br> Valor booleano de \$d: <br>";
        var_dump($d);
        echo "<br> Valor booleano de \$e: <br>";
        var_dump($e);
        echo "<br> Valor booleano de \$f: <br>";
        var_dump($f);

        //Transformando los valores
        function boolToString($bool) {
            return $bool ? 'true' : 'false';
        }

        // Mostrar los valores transformados con echo
        echo "<br> Valor de \$c transformado: " . boolToString($c) . "<br>";
        echo "<br> Valor de \$e transformado: " . boolToString($e) . "<br>";
    ?>

    <h2>Ejercicio 7</h2>
    <?php
        $a = "7 personas";
        $b = (integer) $a;
        $a = "9E3";
        $c = (double) $a;

        echo "\$a = $a <br>";
        echo "\$b = $b <br>";
        echo "\$c = $c <br>";
    ?>
    
</body>
</html>