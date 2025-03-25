<?php

use TECWEB\MYAPI\Products as Products;
    require_once __DIR__ . '/myapi/Products.php';

    $prodObj = new Products('root', '23102005','marketzone');
    if(isset($_POST['name'])) {
        $name = $_POST['name'];
        $prodObj->singleByName($name);
    } else {
        die("No");
    }
    echo $prodObj->getData();

?>