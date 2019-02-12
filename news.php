<?php

class News {
    public function fetch_all() {
        global $pdo;
        
        $query = $pdo->prepare("SELECT * FROM news"); // select all from "news" table
        $query->execute(); // execute the query above
        
        return $query->fetchAll(); // fetch all data
    }
    public function fetch_data($news_id) {
        global $pdo;
        
        $query = $pdo->prepare("SELECT * FROM news WHERE news_id = ?"); // select all from "news" table, where the ID is provided
        $query->bindValue(1, $news_id); // bind the "?" to the id
        
        $query->execute();
        
        return $query->fetch();
    }
}

?>