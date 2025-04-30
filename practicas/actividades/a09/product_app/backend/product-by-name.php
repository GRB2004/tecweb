<?php

    use myapi\Read\Read as Read;
    require_once __DIR__ . '/start.php';
    $prodObj = new Read('root', '23102005','marketzone');
    
    if(isset($_POST['name'])) {
        $name = $_POST['name'];
        $prodObj->singleByName($name);
    } else {
        die("No");
    }
    echo $prodObj->getData();

?>