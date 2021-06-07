<?php
    $servername = "localhost";
    $username = "root";
    $password = "";
    $db = new PDO("mysql:host=$servername;dbname=php_shop", $username, $password);
    $db->query('PRAGMA foreign_keys = ON;');
    $db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

    $num = (int)$_GET["pid"];
    $q = $db->prepare("SELECT name, price FROM products WHERE pid = $num");
    $q->execute();
    echo json_encode($q->fetchAll());
?>