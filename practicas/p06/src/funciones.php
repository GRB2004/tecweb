<?php
    // Función para verificar si un número es múltiplo de 5 y 7
    function multiplo($numero) {
        if ($numero % 5 == 0 && $numero % 7 == 0) {
            echo '<h3>R= El número ' . $numero . ' SÍ es múltiplo de 5 y 7.</h3>';
        } else {
            echo '<h3>R= El número ' . $numero . ' NO es múltiplo de 5 y 7.</h3>';
        }
    }
?>