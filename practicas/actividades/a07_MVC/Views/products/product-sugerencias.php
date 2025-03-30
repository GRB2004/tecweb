<?php
use TECWEB\CONTROLLER\ProductsController;
require_once __DIR__ . '/../../Controller/ProductsController.php';

if(isset($_GET['search']) && isset($_GET['current_name'])) {
    $searchTerm = $_GET['search'];
    $currentName = $_GET['current_name'];
    $prodObj = new ProductsController('root', '23102005','marketzone');
    $prodObj->sugerenciasNombres($searchTerm, $currentName);
} else {
    echo '<div class="text-danger">Error en la solicitud</div>';
}

?>