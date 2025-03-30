<?php

namespace TECWEB\MODEL;

// Clase Producto con referencia estática a la instancia de Products
class Producto {
    // Referencia a la instancia de Products para poder llamar a productAdd()
    private static $productsObj;
    
    private $nombre;
    private $marca;
    private $modelo;
    private $precio;
    private $unidades;
    private $detalles;
    private $imagen;

    // Método estático para asignar la instancia de Products
    public static function setProductsObject($productsObj) {
        self::$productsObj = $productsObj;
    }

    // Constructor completo: asigna propiedades y llama a productAdd()
    public function __construct($name, $marca, $modelo, $precio, $unidades, $detalles, $imagen) {
        $this->nombre   = $name;
        $this->marca    = $marca;
        $this->modelo   = $modelo;
        $this->precio   = $precio;
        $this->unidades = $unidades;
        $this->detalles = $detalles;
        $this->imagen   = $imagen;
        
        
        // Llamada a productAdd() si se ha asignado la instancia de Products
        if (self::$productsObj) {
            self::$productsObj->productAdd($this);
        }
    }

    // Métodos getter para acceder a los atributos
    public function getNombre() {
        return $this->nombre;
    }
    public function getMarca() {
        return $this->marca;
    }
    public function getModelo() {
        return $this->modelo;
    }
    public function getPrecio() {
        return $this->precio;
    }
    public function getUnidades() {
        return $this->unidades;
    }
    public function getDetalles() {
        return $this->detalles;
    }
    public function getImagen() {
        return $this->imagen;
    }
}
?>