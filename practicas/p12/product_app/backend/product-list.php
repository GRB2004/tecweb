<?php

    use myapi\Read\Read as Read;
    require_once __DIR__ . '/start.php';
    $prodObj = new Read('root', '23102005','marketzone');
    $prodObj->list();

    echo $prodObj->getData();
?>