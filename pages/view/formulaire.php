<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require_once __DIR__ . '/../../vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../..');
    $dotenv->load();

    $conn = new mysqli(
        $_ENV['DB_HOST'],
        $_ENV['DB_USER'],
        $_ENV['DB_PASS'],
        'game_collection' // Hardcode database name for now
    );

    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Sanitize inputs
        $name = htmlspecialchars($_POST['nom-du-jeu']);
        $publisher = htmlspecialchars($_POST['editeur-du-jeu']);
        $release_date = htmlspecialchars($_POST['sortie-du-jeu']);
        $platforms = isset($_POST['plateformes']) ? implode(',', $_POST['plateformes']) : '';
        $description = htmlspecialchars($_POST['description-du-jeu']);
        $cover_url = htmlspecialchars($_POST['url-de-la-cover']);
        $website_url = htmlspecialchars($_POST['url-du-site']);

        $sql = "INSERT INTO games (name, publisher, release_date, platforms, description, cover_url, website_url) 
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        
        if($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("sssssss", $name, $publisher, $release_date, $platforms, $description, $cover_url, $website_url);
            
            if ($stmt->execute()) {
                echo "<p class='success'>Jeu ajouté avec succès!</p>";
            } else {
                throw new Exception("Error: " . $stmt->error);
            }
            $stmt->close();
        } else {
            throw new Exception("Error in prepare statement: " . $conn->error);
        }
    }

} catch (Exception $e) {
    error_log($e->getMessage());
    echo "<p class='error'>Une erreur est survenue: " . $e->getMessage() . "</p>";
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter un jeu à sa bibliothèque</title>
    <link rel="stylesheet" href="../../assets/css/formulaire.css">
</head>
<body>
    <main class="main">
        <div class="container">
            <header class="header">
                <h1>Ajouter un jeu à sa bibliothèque</h1>
                <p class="intro">
                    Le jeu que vous souhaitez ajouter n'existe pas ! Vous pouvez le créer, celui-ci sera automatiquement ajouté à votre bibliothèque !
                </p>
            </header>
            <form class="form" action="#" method="post">
                <!-- Nom du jeu -->
                <div class="form-group">
                    <label for="nom-du-jeu">Nom du jeu</label>
                    <input type="text" id="nom-du-jeu" name="nom-du-jeu" placeholder="Nom du jeu" required>
                </div>

                <!-- Éditeur du jeu -->
                <div class="form-group">
                    <label for="editeur-du-jeu">Éditeur du jeu</label>
                    <input type="text" id="editeur-du-jeu" name="editeur-du-jeu" placeholder="Éditeur du jeu" required>
                </div>

                <!-- Sortie du jeu -->
                <div class="form-group">
                    <label for="sortie-du-jeu">Sortie du jeu</label>
                    <input type="date" id="sortie-du-jeu" name="sortie-du-jeu" required>
                </div>

                <!-- Plateformes -->
                <fieldset class="form-group">
                    <legend>Plateformes</legend>
                    <div class="checkbox-group">
                        <label>
                            <input type="checkbox" name="plateformes[]" value="Playstation">
                            Playstation
                        </label>
                        <label>
                            <input type="checkbox" name="plateformes[]" value="Xbox">
                            Xbox
                        </label>
                        <label>
                            <input type="checkbox" name="plateformes[]" value="Nintendo">
                            Nintendo
                        </label>
                        <label>
                            <input type="checkbox" name="plateformes[]" value="PC">
                            PC
                        </label>
                    </div>
                </fieldset>

                <!-- Description du jeu -->
                <div class="form-group">
                    <label for="description-du-jeu">Description du jeu</label>
                    <textarea id="description-du-jeu" name="description-du-jeu" placeholder="Description du jeu" rows="4" required></textarea>
                </div>

                <!-- URL de la cover -->
                <div class="form-group">
                    <label for="url-de-la-cover">URL de la cover</label>
                    <input type="url" id="url-de-la-cover" name="url-de-la-cover" placeholder="URL de la cover" required>
                </div>

                <!-- URL du site -->
                <div class="form-group">
                    <label for="url-du-site">URL du site</label>
                    <input type="url" id="url-du-site" name="url-du-site" placeholder="URL du site" required>
                </div>

                <!-- Bouton de soumission -->
                <div class="form-group">
                    <button type="submit" class="btn-submit">Ajouter le jeu</button>
                </div>
            </form>
        </div>
    </main>
</body>
</html>
