<?php

class About {
    public function fetch_all() {
        global $pdo;
        
        $query = $pdo->prepare("SELECT * FROM about");
        $query->execute();
        
        return $query->fetchAll();
    }
    public function fetch_data($about_id) {
        global $pdo;
        
        $query = $pdo->prepare("SELECT * FROM about WHERE about_id = ?");
        $query->bindValue(1, $about_id);
        
        $query->execute();
        
        return $query->fetch();
    }
}

?>