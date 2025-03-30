<?php
    use TECWEB\CONTROLLER\ProductsController;
    require_once 'ProductsController.php';

    if(isset($_GET['search'])) {
        $searchTerm = $_GET['search'];
        $currentName = $_GET['current_name'] ?? '';
        $prodObj = new ProductsController('root', '23102005','marketzone');
        $prodObj->sugerenciasNombres($searchTerm);
    } else {
        echo '<div class="alert alert-warning">No se recibió término de búsqueda</div>';
    }
?>