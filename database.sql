--ce quil faut implementer dans la bdd

CREATE DATABASE IF NOT EXISTS game_collection;
USE game_collection;

CREATE TABLE IF NOT EXISTS games (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(255) NOT NULL,
    publisher VARCHAR(255) NOT NULL,
    release_date DATE,
    platforms VARCHAR(255),
    description TEXT,
    cover_url VARCHAR(255),
    website_url VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);