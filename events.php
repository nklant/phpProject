<?php

class Events {
    public function fetch_all() {
        global $pdo;
        
        $query = $pdo->prepare("SELECT * FROM events"); // Select everything from "events" table
        $query->execute();
        
        return $query->fetchAll();
    }
    public function fetch_data($event_id) {
        global $pdo;
        
        $query = $pdo->prepare("SELECT * FROM events WHERE event_id = ?"); // Select specific record from "events" table
        $query->bindValue(1, $event_id); // Bind the value to the query above
        
        $query->execute();
        
        return $query->fetch();
    }
}

?>