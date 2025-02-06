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
                    }
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
            }
}
?>
