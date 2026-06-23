<?php
require_once '../app/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $stmt = $pdo->prepare("INSERT INTO taches (titre, description, priorite) VALUES (?, ?, ?)");
    $stmt->execute([$_POST['titre'], $_POST['description'], $_POST['priorite']]);
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Ajouter une tâche</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Ajouter une tâche</h1>
    <form method="POST">
        <label>Titre</label>
        <input type="text" name="titre" required>
        <label>Description</label>
        <textarea name="description"></textarea>
        <label>Priorité</label>
        <select name="priorite">
            <option value="basse">Basse</option>
            <option value="moyenne">Moyenne</option>
            <option value="haute">Haute</option>
        </select>
        <button type="submit">Ajouter</button>
    </form>
    <a href="index.php">Retour</a>
</body>
</html>