<?php
    $conexion = @mysqli_connect(
        'localhost',
        'root',
        '23102005',
        'marketzone'
    );

    /**
     * NOTA: si la conexión falló $conexion contendrá false
     **/
    if(!$conexion) {
        die('¡Base de datos NO conextada!');
    }
?>