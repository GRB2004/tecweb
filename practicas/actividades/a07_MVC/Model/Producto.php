<?php

namespace TECWEB\MODEL;

// Clase Producto con referencia estática a la instancia de Products
class Producto {
    // Referencia a la instancia de Products para poder llamar a productAdd()
    private static $productsObj;
    private $id;
    private $nombre;
    private $marca;
    private $modelo;
    private $precio;
    private $unidades;
    private $detalles;
    private $imagen;

    public function __construct(array $data) {
        $this->id = $data['id'] ?? null;
        $this->nombre = $data['nombre'];
        $this->marca = $data['marca'];
        $this->modelo = $data['modelo'];
        $this->precio = (float)$data['precio'];
        $this->unidades = (int)$data['unidades'];
        $this->detalles = $data['detalles'];
        $this->imagen = $data['imagen'];
    }
    
    // Métodos getter para acceder a los atributos
    public function getId() {
        return $this->id;
    }
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