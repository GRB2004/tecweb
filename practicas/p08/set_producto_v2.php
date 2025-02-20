<?php
// Configuración de la conexión a la base de datos
$servername = "localhost";
$username = "root";
$password = "23102005";
$dbname = "marketzone";

// Crear conexión
$conn = new mysqli($servername, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die("Conexión fallida: " . $conn->connect_error);
}

// Función para validar si un producto ya existe en la base de datos
function productoExiste($conn, $nombre, $marca, $modelo) {
    $stmt = $conn->prepare("SELECT id FROM productos WHERE nombre = ? AND marca = ? AND modelo = ?");
    $stmt->bind_param("sss", $nombre, $marca, $modelo);
    $stmt->execute();
    $stmt->store_result();
    return $stmt->num_rows > 0;
}

// Obtener datos del formulario
$nombre = $_POST['name'];
$marca = $_POST['marca'];
$modelo = $_POST['modelo'];
$precio = $_POST['precio'];
$detalles = $_POST['detalles'];
$unidades = $_POST['unidades'];
$imagen   = 'img/imagen.png';

// Validar que los datos no estén vacíos
if (empty($nombre) || empty($marca) || empty($modelo) || empty($precio) || empty($detalles) || empty($unidades)) {
    die("Todos los campos son obligatorios.");
}

// Validar que el precio sea un número
if (!is_numeric($precio)) {
    die("El precio debe ser un número.");
}

if (!is_numeric($unidades)){
  die("El precio debe ser un número.");
}

// Validar que el producto no exista ya en la base de datos
if (productoExiste($conn, $nombre, $marca, $modelo)) {
    die("El producto con el mismo nombre, marca y modelo ya existe.");
}

// Insertar el nuevo producto en la base de datos
$sql = "INSERT INTO productos VALUES (null, '{$nombre}', '{$marca}', '{$modelo}', {$precio}, '{$detalles}', {$unidades}, '{$imagen}')";
if ( $conn->query($sql) ) 
{
    echo 'Producto insertado con ID: '.$link->insert_id;
}
else
{
	echo 'El Producto no pudo ser insertado =(';
}
$stmt->bind_param("sssds", $nombre, $marca, $modelo, $precio, $detalles, $imagen);

if ($stmt->execute()) {
    echo "Producto insertado correctamente.<br>";
    echo "Resumen del producto:<br>";
    echo "Nombre: $nombre<br>";
    echo "Marca: $marca<br>";
    echo "Modelo: $modelo<br>";
    echo "Precio: $precio<br>";
    echo "Detalles: $detalles<br>";
    echo "Detalles: $unidades<br>";
    echo "Detalles: $imagen<br>";
} else {
    echo "Error al insertar el producto: " . $stmt->error;
}

// Cerrar la conexión
$stmt->close();
$conn->close();
?>