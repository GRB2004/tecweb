<?php
namespace TECWEB\MODEL;

use TECWEB\MODEL\DataBase;
use TECWEB\MODEL\Producto;
use Exception;

require_once 'Database.php';
require_once 'Producto.php';

class ProductModel extends DataBase {
    public function __construct($user = 'root', $pass = '23102005', $db = 'marketzone') {
        parent::__construct($user, $pass, $db);
        $this->conexion->set_charset("utf8");
    }

    /* Método para obtener todos los productos */
    public function obtenerTodos() {
        $sql = "SELECT * FROM productos WHERE eliminado = 0";
        $result = $this->conexion->query($sql);

        if (!$result) {
            throw new Exception("Error al obtener productos: " . $this->conexion->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /* Método para búsqueda avanzada */
    public function buscar($termino) {
        $stmt = $this->conexion->prepare("
            SELECT * FROM productos 
            WHERE (id = ? OR nombre LIKE ? OR marca LIKE ? OR detalles LIKE ?) 
            AND eliminado = 0
        ");
        
        $likeTerm = "%$termino%";
        $stmt->bind_param("isss", $termino, $likeTerm, $likeTerm, $likeTerm);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /* Método para sugerencias de nombres */
    public function obtenerSugerenciasNombres($search) {
        $stmt = $this->conexion->prepare("
            SELECT nombre 
            FROM productos 
            WHERE nombre LIKE ? 
            AND eliminado = 0 
            ORDER BY nombre ASC 
            LIMIT 5
        ");
        
        $likeSearch = "%$search%";
        $stmt->bind_param("s", $likeSearch);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /* Método para obtener un producto por ID */
    public function obtenerPorId($id) {
        $stmt = $this->conexion->prepare("SELECT * FROM productos WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        if ($result->num_rows === 0) {
            throw new Exception("Producto no encontrado");
        }
        
        return $result->fetch_assoc();
    }

    /* Método para obtener producto por nombre exacto */
    public function obtenerPorNombre($nombre) {
        $stmt = $this->conexion->prepare("SELECT * FROM productos WHERE nombre = ?");
        $stmt->bind_param("s", $nombre);
        $stmt->execute();
        
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /* Método para agregar nuevo producto */
    public function agregarProducto(Producto $producto) {
        // Verificar si el nombre ya existe
        $existente = $this->obtenerPorNombre($producto->getNombre());
        if ($existente) {
            throw new Exception("Ya existe un producto con ese nombre");
        }

        $stmt = $this->conexion->prepare("
            INSERT INTO productos 
            (nombre, marca, modelo, precio, detalles, unidades, imagen, eliminado) 
            VALUES (?, ?, ?, ?, ?, ?, ?, 0)
        ");

        // Crear variables primero
        $nombre = $producto->getNombre();
        $marca = $producto->getMarca();
        $modelo = $producto->getModelo();
        $precio = $producto->getPrecio();
        $detalles = $producto->getDetalles();
        $unidades = $producto->getUnidades();
        $imagen = $producto->getImagen();
        
        $stmt->bind_param("sssdssi", // <- Corrección aquí
            $nombre,    // s (string)
            $marca,     // s (string)
            $modelo,    // s (string)
            $precio,    // d (double)
            $detalles,  // s (string) <- Antes estaba como 'd'
            $unidades,  // i (integer)
            $imagen     // s (string)
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Error al agregar producto: " . $stmt->error);
        }
    }

    /* Método para eliminar producto (soft delete) */
    public function eliminarProducto($id) {
        $stmt = $this->conexion->prepare("
            UPDATE productos 
            SET eliminado = 1 
            WHERE id = ?
        ");
        
        $stmt->bind_param("i", $id);
        
        if (!$stmt->execute()) {
            throw new Exception("Error al eliminar producto: " . $stmt->error);
        }
    }

    /* Método para actualizar producto */
    // ProductModel.php
    public function actualizarProducto(Producto $producto) {
        $stmt = $this->conexion->prepare("
            UPDATE productos SET
            nombre = ?, 
            marca = ?, 
            modelo = ?, 
            precio = ?, 
            detalles = ?, 
            unidades = ?, 
            imagen = ? 
            WHERE id = ?
        ");
        
        // Almacenar los valores en variables primero
        $nombre = $producto->getNombre();
        $marca = $producto->getMarca();
        $modelo = $producto->getModelo();
        $precio = $producto->getPrecio();
        $detalles = $producto->getDetalles();
        $unidades = $producto->getUnidades();
        $imagen = $producto->getImagen();
        $id = $producto->getId();
        
        // Vincular las variables (no los métodos directamente)
        $stmt->bind_param("sssdsisi", 
            $nombre,
            $marca,
            $modelo,
            $precio,
            $detalles,
            $unidades,
            $imagen,
            $id
        );
        
        if (!$stmt->execute()) {
            throw new Exception("Error al actualizar producto: " . $stmt->error);
        }
        
        if ($stmt->affected_rows === 0) {
            throw new Exception("No se encontró el producto con ID " . $id);
        }
    }

    /* Método para cerrar conexión (opcional) */
    public function __destruct() {
        if ($this->conexion) {
            $this->conexion->close();
        }
    }
}