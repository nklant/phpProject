<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=cms', 'root', 'root');
} catch (PDOException $e) {
    exit('There is a problem with the Database!!! Check credentials!');
}

?>