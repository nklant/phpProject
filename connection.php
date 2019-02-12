<?php

try {
    $pdo = new PDO('mysql:host=localhost;dbname=cms', 'root', 'root'); // try connect
} catch (PDOException $e) {
    exit('There is a problem with the Database!!! Check credentials!'); // throw exception
}

?>