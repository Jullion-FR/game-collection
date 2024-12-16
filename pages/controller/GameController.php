<?php
require_once __DIR__ . '/../model/GameModel.php';

class GameController {
    private $model;

    public function __construct($conn) {
        $this->model = new GameModel($conn);
    }

    public function handleFormSubmission($post) {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $name = htmlspecialchars($post['nom-du-jeu']);
            $publisher = htmlspecialchars($post['editeur-du-jeu']);
            $release_date = htmlspecialchars($post['sortie-du-jeu']);
            $platforms = isset($post['plateformes']) ? implode(',', $post['plateformes']) : '';
            $description = htmlspecialchars($post['description-du-jeu']);
            $cover_url = htmlspecialchars($post['url-de-la-cover']);
            $website_url = htmlspecialchars($post['url-du-site']);

            try {
                $result = $this->model->addGame($name, $publisher, $release_date, $platforms, $description, $cover_url, $website_url);
                return $result ? "success" : "error";
            } catch (Exception $e) {
                return "error: " . $e->getMessage();
            }
        }
        return null;
    }
}