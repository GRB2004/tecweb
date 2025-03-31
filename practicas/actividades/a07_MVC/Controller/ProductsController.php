<?php
namespace TECWEB\Controller;

use TECWEB\MODEL\Producto;
use TECWEB\MODEL\ProductModel;
use TECWEB\VIEWS\ProductView;

require_once __DIR__ . '/../Model/Database.php';
require_once __DIR__ . '/../Model/ProductModel.php';
require_once __DIR__ . '/../Views/productView.php';
use Exception;

class ProductsController {
    private $model;
    private $view;
    private $data = [];

    public function __construct(ProductModel $model, ProductView $view) {
        $this->model = $model;
        $this->view = $view;
    }

    public function list($onlyTbody = false) {
        try {
            $productos = $this->model->obtenerTodos();
            $html = $this->view->mostrarListaCompleta($productos, $onlyTbody);
            
            if ($onlyTbody) {
                return $html; // Solo devuelve el contenido del tbody
            }
            
            echo $html;
    
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    public function search($search) {
        try {
            $productos = $this->model->buscar($search);
            echo $this->view->buscarProducto($productos);
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    public function sugerenciasNombres($search) {
        try {
            $sugerencias = $this->model->obtenerSugerenciasNombres($search);
            $nombreIngresado = $_GET['current_name'] ?? '';
            echo $this->view->mostrarSugerencias($sugerencias, $nombreIngresado);
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    public function single($id) {
        try {
            $producto = $this->model->obtenerPorId($id);
            echo $this->view->mostrarProducto($producto);
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    public function singleByName($name) {
        try {
            $producto = $this->model->obtenerPorId($name);
            echo $this->view->mostrarProducto($producto);
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    public function productAdd(Producto $producto) {
        try {
            $this->model->agregarProducto($producto);
            $this->data = [
                'status' => "success",
                'message' => "Producto agregado correctamente",
                'html' => $this->view->mostrarStatus([
                    'status' => 'success',
                    'message' => 'Producto agregado correctamente'
                ])
            ];
            echo json_encode($this->data);
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    public function delete($id) {
        try {
            $this->model->eliminarProducto($id);
            $this->data = [
                'status' => "success",
                'message' => "Producto eliminado",
                'html' => $this->view->mostrarStatus([
                    'status' => 'success',
                    'message' => 'Producto eliminado'
                ])
            ];
            echo json_encode($this->data);
        } catch (Exception $e) {
            $this->handleError($e);
        }
    }

    // ProductsController.php
    public function edit(Producto $producto) {
        try {
            $this->model->actualizarProducto($producto);
            $this->data = [
                'status' => "success",
                'message' => "Producto actualizado",
                'html' => $this->view->mostrarStatus([
                    'status' => 'success',
                    'message' => 'Producto actualizado correctamente'
                ])
            ];
        } catch (Exception $e) {
            $this->data = [
                'status' => "error",
                'message' => $e->getMessage(),
                'html' => $this->view->mostrarStatus([
                    'status' => 'error',
                    'message' => $e->getMessage()
                ])
            ];
        }
        // No hacer echo aquí
    }

    private function handleError(Exception $e) {
        $this->data = [
            'status' => "error",
            'message' => $e->getMessage(),
            'html' => $this->view->mostrarStatus([
                'status' => 'error',
                'message' => $e->getMessage()
            ])
        ];
        echo json_encode($this->data);
    }

    
    public function getData() {
        return $this->data;
    }
}