<?php

class News {
    public function fetch_all() {
        global $pdo;
        
        $query = $pdo->prepare("SELECT * FROM news");
        $query->execute();
        
        return $query->fetchAll();
    }
    public function fetch_data($news_id) {
        global $pdo;
        
        $query = $pdo->prepare("SELECT * FROM news WHERE news_id = ?");
        $query->bindValue(1, $news_id);
        
        $query->execute();
        
        return $query->fetch();
    }
}

?>