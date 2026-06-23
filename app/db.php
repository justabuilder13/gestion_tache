<?php
// On cherche le fichier .env un dossier plus haut
$envPath = __DIR__ . '/../.env';
$env = [];

if (file_exists($envPath)) {
    $lines = file($envPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Ignore les commentaires
        if (strpos(trim($line), '#') === 0) continue;
        
        // Sépare la clé et la valeur autour du signe =
        if (strpos($line, '=') !== false) {
            list($name, $value) = explode('=', $line, 2);
            $env[trim($name)] = trim($value);
        }
    }
}

// Configuration dynamique (prend le .env, ou des valeurs par défaut si vide)
$host     = $env['DB_HOST'] ?? '127.0.0.1'; 
$dbname   = $env['DB_NAME'] ?? 'chbeuxmmng_justinlachapelle';
$user     = $env['DB_USER'] ?? 'chbeuxmmng_justlach13';
$password = $env['DB_PASS'] ?? 'Futureshop0103$';
$charset  = $env['DB_CHARSET'] ?? 'utf8mb4';

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=$charset",
        $user,
        $password
    );
    // Activer les exceptions pour le débogage
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}