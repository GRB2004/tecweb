<?php
    // Incluye varios archivos externos y muestra el contenido en una página web
    include("encabezado.inc.php"); 
    echo "<hr />";
    include_once("cuerpo.inc.php"); 
    require("cuerpo.html"); 
    require_once("pie.inc.php");
?>