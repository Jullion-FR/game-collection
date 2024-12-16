<?php
class GameModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function addGame($name, $publisher, $release_date, $platforms, $description, $cover_url, $website_url) {
        $sql = "INSERT INTO games (name, publisher, release_date, platforms, description, cover_url, website_url) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param("sssssss", $name, $publisher, $release_date, $platforms, $description, $cover_url, $website_url);
        
        return $stmt->execute();
    }
}