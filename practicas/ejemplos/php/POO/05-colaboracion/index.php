<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejemplo 5 de POO en PHP</title>
</head>
<body>
    <?php
    require_once __DIR__ . '/Pagina.php';

    $pag1 = new Pagina('El ático del programador', "El sótano del Programador");
    for ($i=0; $i<15; $i++) {
      $pag1->insertar_cuerpo('Este es el parrafo No.'.($i).' que debe aparecer en la Página.');
    }

    $pag1->graficar();

    ?>
</body>
</html>