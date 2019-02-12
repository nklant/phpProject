<?php

class About {
    public function fetch_all() {
        global $pdo;
        
        $query = $pdo->prepare("SELECT * FROM about"); // Select everything from "about" table
        $query->execute();
        
        return $query->fetchAll();
    }
    public function fetch_data($about_id) {
        global $pdo;
        
        $query = $pdo->prepare("SELECT * FROM about WHERE about_id = ?"); // Select specific record from "about" table
        $query->bindValue(1, $about_id); // Bind the value to the query above
        
        $query->execute();
        
        return $query->fetch();
    }
}

?>