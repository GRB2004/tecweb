<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ejemplo 3 de POO en PHP</title>
</head>
<body>
  <?php
  use EJEMPLOS\POO\Cabecera2 as Cabecera2;
  require_once __DIR__. '/Cabecera.php';

  /*
  $cab1 = new Cabecera('El rincón del Programador', 'center');
  $cab1->graficar();
  */

  $cab1 = new Cabecera2('El Rincón del Programador', 'center', 'https://www.deepseek.com');
  $cab1->graficar();
  ?>
</body>
</html>