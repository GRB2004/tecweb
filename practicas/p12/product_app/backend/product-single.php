<?php

    use myapi\Read\Read as Read;
    require_once __DIR__ . '/start.php';
    $prodObj = new Read('root', '23102005','marketzone');
    
    if(isset($_POST['id'])) {
        $id = $_POST['id'];
        $prodObj->single($id);
    } else {
        die("No se recibio el id");
    }
    echo $prodObj->getData();
?>



