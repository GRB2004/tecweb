<?php

    use myapi\Read\Read as Read;
    require_once __DIR__ . '/start.php';
    $prodObj = new Read('root', '23102005','marketzone');
    
    if(isset($_GET['search']) ) {
        $search = $_GET['search'];
        $prodObj->search($search);
    } else {
        die('Query Error: '.mysqli_error($this->conexion));
    }
    
    echo $prodObj->getData();
?>