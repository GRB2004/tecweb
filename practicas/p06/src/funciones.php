<?php
    function numero() {
        if(isset($_GET['numero']))
        {
            $num = $_GET['numero'];
            if ($num%5==0 && $num%7==0)
            {
                echo '<h3>R= El número '.$num.' SÍ es múltiplo de 5 y 7.</h3>';
            }
            else
            {
                echo '<h3>R= El número '.$num.' NO es múltiplo de 5 y 7.</h3>';
            }
        }
    }


        function matriz() {
            $numeros = range(0, 9); // Array con números del 0 al 9
            $matriz = [];
            $cantidad_numeros = 0;
            $iteraciones = 0;
            if(isset($_POST['submit'])) {
                // Crear matriz 4x3
                for ($i = 1; $i <= 4; $i++) {  // 4 filas
                    for ($j = 1; $j <= 3; $j++) {  // 3 columnas
                        do {
                            // Generar un número de tres dígitos aleatorios
                            $digitos = [];
                            for ($k = 0; $k < 3; $k++) {
                                $indice = mt_rand(0, 9);
                                $digitos[] = $numeros[$indice];
                            }
                            $num = intval(implode('', $digitos)); // Convertir a número entero
                        } while (($num % 2 == 0 && $j % 2 != 0) || ($num % 2 != 0 && $j % 2 == 0)); 
                        // Repetir si el número no coincide con la columna par/impar

                        // Asignar el número generado a la matriz
                        $matriz[$i][$j] = $num;
                        $cantidad_numeros++;
                    }
                    $iteraciones++;
                }
                // Generar la tabla HTML
                echo '<table border="1" cellpadding="10" style="border-collapse: collapse; text-align: center;">';
                foreach ($matriz as $fila) {
                    echo '<tr>';
                    foreach ($fila as $valor) {
                        echo '<td>' . $valor . '</td>';
                    }
                    echo '</tr>';
                }
                echo '</table>';
                // Mostrar estadísticas al final
                echo "<p><strong>Cantidad de numeros:</strong> $cantidad_numeros</p>";
                echo "<p><strong>Total iteraciones:</strong> $iteraciones</p>";
            }

        }

        function primerAleatorio() {
            if(isset($_GET['numero']))
            {
                $multiplo = $_GET['numero'];
                // Versión con ciclo while
                $numero_aleatorio = mt_rand(1, 1000); // Generar un número inicial
                while($numero_aleatorio%$multiplo != 0)
                {
                    $numero_aleatorio = mt_rand(1, 1000);
                }
                echo "<strong>Número encontrado(While):</strong> $numero_aleatorio (<strong>múltiplo de $multiplo</strong>)<br>";
            } 
        }

        function variante_aleatorio() {
            if(isset($_GET['numero']))
            {
                $multiplo = $_GET['numero'];
                // Versión con ciclo while
                do{

                    $numero_aleatorio = mt_rand(1, 1000); // Generar un número inicial
                } while($numero_aleatorio%$multiplo != 0);

                echo "<strong>Número encontrado (do-While):</strong> $numero_aleatorio (<strong>múltiplo de $multiplo</strong>)<br>";
            } 
        }

        function arreglo_ascii() {
            $arreglo = []; // Inicializar el arreglo vacío

            if(isset($_POST['submit']))
            {
                for ($i = 97; $i <=122; $i++)
                {
                    $arreglo[$i] = chr($i);
                }
                
                return $arreglo;
            }
        }
?>
