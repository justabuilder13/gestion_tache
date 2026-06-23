<?php
require_once '../app/db.php';

$stmt = $pdo->query("SELECT * FROM taches ORDER BY created_at DESC");
$taches = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gestion de tâches</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <h1>Mes tâches</h1>
    <a href="ajouter.php">+ Ajouter une tâche</a>
    <table>
        <tr>
            <th>Titre</th>
            <th>Priorité</th>
            <th>Statut</th>
            <th>Action</th>
        </tr>
        <?php foreach ($taches as $tache): ?>
        <tr>
            <td><?= htmlspecialchars($tache['titre']) ?></td>
            <td><?= htmlspecialchars($tache['priorite']) ?></td>
            <td><?= $tache['termine'] ? 'Terminé' : 'En cours' ?></td>
            <td>
                <a href="?supprimer=<?= $tache['id'] ?>">Supprimer</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </table>
</body>
</html>
<?php
if (isset($_GET['supprimer'])) {
    $stmt = $pdo->prepare("DELETE FROM taches WHERE id = ?");
    $stmt->execute([$_GET['supprimer']]);
    header('Location: index.php');
    exit;
}