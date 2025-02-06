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

        function rango_edad() {
            if(isset($_POST['submit']))
            {
                $edad = $_POST['edad'];
                $sexo = $_POST['sexo'];
                if($edad>=18 || $edad<=35){
                    if($sexo=='Masculino')
                    {
                        echo 'Bienvenido, usted está en el rango de edad permitido.';
                    } else {
                        echo 'Bienvenida, usted está en el rango de edad permitido.';
                    }
                } else {
                    echo 'Usted no está en el rango de edad permitido.';
                }
            }
        }

        function autos() {
            $autos = array(
                'AWL2389' => [
                    'auto' => [
                        'Marca' => 'Honda',
                        'Modelo' => 'Civic',
                        'Tipo' => 'Sedan',
                    ],
                    'propietario' => [
                        'Nombre' => 'Juan',
                        'Ciudad' => 'Puebla',
                        'Direccion' => 'EL CENTRO'
                    ],
                ],
            
                'FDO4859' => [
                    'auto' => [
                        'Marca' => 'Ford',
                        'Modelo' => 'Bronco',
                        'Tipo' => 'Hatchback',
                    ],
                    'propietario' => [
                        'Nombre' => 'Pedro',
                        'Ciudad' => 'Nuevo Leon',
                        'Direccion' => 'PINOS LOCALES 18'
                    ],
                ],
            
                'OLR9078' => [
                    'auto' => [
                        'Marca' => 'Tesla',
                        'Modelo' => 'Y',
                        'Tipo' => 'Sedan',
                    ],
                    'propietario' => [
                        'Nombre' => 'Alan',
                        'Ciudad' => 'Tijuana',
                        'Direccion' => 'BENITO J. 210'
                    ],
                ],
            
                'XYZ1234' => [
                    'auto' => [
                        'Marca' => 'Toyota',
                        'Modelo' => 'Corolla',
                        'Tipo' => 'Sedan',
                    ],
                    'propietario' => [
                        'Nombre' => 'Maria',
                        'Ciudad' => 'Guadalajara',
                        'Direccion' => 'AV. INDEPENDENCIA 456'
                    ],
                ],
            
                'ABC5678' => [
                    'auto' => [
                        'Marca' => 'Chevrolet',
                        'Modelo' => 'Camaro',
                        'Tipo' => 'Coupe',
                    ],
                    'propietario' => [
                        'Nombre' => 'Carlos',
                        'Ciudad' => 'Monterrey',
                        'Direccion' => 'CALLE PRINCIPAL 789'
                    ],
                ],
            
                'DEF9101' => [
                    'auto' => [
                        'Marca' => 'Nissan',
                        'Modelo' => 'Sentra',
                        'Tipo' => 'Sedan',
                    ],
                    'propietario' => [
                        'Nombre' => 'Laura',
                        'Ciudad' => 'Cancun',
                        'Direccion' => 'AV. TULUM 123'
                    ],
                ],
            
                'GHI1121' => [
                    'auto' => [
                        'Marca' => 'Volkswagen',
                        'Modelo' => 'Jetta',
                        'Tipo' => 'Sedan',
                    ],
                    'propietario' => [
                        'Nombre' => 'Roberto',
                        'Ciudad' => 'Queretaro',
                        'Direccion' => 'CALLE 5 DE MAYO 67'
                    ],
                ],
            
                'JKL3141' => [
                    'auto' => [
                        'Marca' => 'BMW',
                        'Modelo' => 'X5',
                        'Tipo' => 'SUV',
                    ],
                    'propietario' => [
                        'Nombre' => 'Sofia',
                        'Ciudad' => 'Ciudad de Mexico',
                        'Direccion' => 'REFORMA 890'
                    ],
                ],
            
                'MNO5161' => [
                    'auto' => [
                        'Marca' => 'Audi',
                        'Modelo' => 'A4',
                        'Tipo' => 'Sedan',
                    ],
                    'propietario' => [
                        'Nombre' => 'Fernando',
                        'Ciudad' => 'Merida',
                        'Direccion' => 'CALLE 60 1234'
                    ],
                ],
            
                'PQR7181' => [
                    'auto' => [
                        'Marca' => 'Hyundai',
                        'Modelo' => 'Tucson',
                        'Tipo' => 'SUV',
                    ],
                    'propietario' => [
                        'Nombre' => 'Ana',
                        'Ciudad' => 'Oaxaca',
                        'Direccion' => 'AV. LIBERTAD 567'
                    ],
                ],
            
                'STU9202' => [
                    'auto' => [
                        'Marca' => 'Kia',
                        'Modelo' => 'Rio',
                        'Tipo' => 'Sedan',
                    ],
                    'propietario' => [
                        'Nombre' => 'Javier',
                        'Ciudad' => 'Veracruz',
                        'Direccion' => 'CALLE PRIMERA 890'
                    ],
                ],
            
                'VWX1222' => [
                    'auto' => [
                        'Marca' => 'Mazda',
                        'Modelo' => 'CX-5',
                        'Tipo' => 'SUV',
                    ],
                    'propietario' => [
                        'Nombre' => 'Carmen',
                        'Ciudad' => 'Toluca',
                        'Direccion' => 'AV. HIDALGO 345'
                    ],
                ],
            
                'YZA3242' => [
                    'auto' => [
                        'Marca' => 'Subaru',
                        'Modelo' => 'Outback',
                        'Tipo' => 'SUV',
                    ],
                    'propietario' => [
                        'Nombre' => 'Ricardo',
                        'Ciudad' => 'Chihuahua',
                        'Direccion' => 'CALLE 12 678'
                    ],
                ],
            
                'BCD5262' => [
                    'auto' => [
                        'Marca' => 'Jeep',
                        'Modelo' => 'Wrangler',
                        'Tipo' => 'SUV',
                    ],
                    'propietario' => [
                        'Nombre' => 'Patricia',
                        'Ciudad' => 'Saltillo',
                        'Direccion' => 'AV. REVOLUCION 901'
                    ],
                ],
            
                'EFG7282' => [
                    'auto' => [
                        'Marca' => 'Mercedes-Benz',
                        'Modelo' => 'C-Class',
                        'Tipo' => 'Sedan',
                    ],
                    'propietario' => [
                        'Nombre' => 'Alejandro',
                        'Ciudad' => 'Leon',
                        'Direccion' => 'CALLE 20 234'
                    ],
                ],
            );
            
            if(isset($_POST['todos']))
            {   
                echo "<pre>";
                echo "Todos los autos registrados <br>";
                print_r($autos);
                echo "<pre>";
            } else if(isset($_POST['matricula'])) {
                // Buscar por matrícula
                $matricula = $_POST['matricula']; 

                if (array_key_exists($matricula, $autos)) {
                    echo "<pre>";
                    print_r($autos[$matricula]);
                    echo "</pre>";
                } else {
                    echo "La matrícula '$matricula' no existe en el registro.";
                }
            }
            
        }
?>
