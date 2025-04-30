<?php

    use myapi\Delete\Delete as Delete;
    require_once __DIR__ . '/start.php';

    $prodObj = new Delete('root', '23102005','marketzone');

    // SE VERIFICA HABER RECIBIDO EL ID
    if( isset($_GET['id']) ) {
        $id = $_GET['id'];
        $prodObj->delete($id);
    } 

    echo $prodObj->getData();
?>