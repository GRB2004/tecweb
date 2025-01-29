<hr/>
<?php
/*
    $_SERVER['PHP_SELF']: Variable superglobal que contiene la ruta del script actual en ejecución
    &nbsp espacio en blanco no separable
*/
echo "<div><h1 style=\"border-width:3;border-style:groove; background-color:
#ffcc99;\"> Final de la página PHP Vínculos útiles : <a href=\"php.net\">php.net</a>
&nbsp; <a href=\"mysql.org\">mysql.org</a></h1>"; 
echo "Nombre del archivo ejecutado: ", $_SERVER['PHP_SELF'],"&nbsp;&nbsp; &nbsp;";
// Muestra la ruta completa del archivo actual
echo "Nombre del archivo incluido: ", __FILE__ ,"</div>";
?>
</body>
</html>