<?php
try {
    // Conectar ao banco de dados SQLite
    $pdo = new PDO('sqlite:../db/db.sqlite');  // Ajuste o caminho conforme necessário
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Criar a tabela 'vulns' caso não exista
    $createVulnsTableSQL = "
    CREATE TABLE IF NOT EXISTS vulns (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        name TEXT NOT NULL,
        category TEXT NOT NULL,
        amount INTEGER NOT NULL,
        severity TEXT NOT NULL,
        month_year TEXT NOT NULL
    );
    ";
    $pdo->exec($createVulnsTableSQL);  // Executa o comando para criar a tabela
} catch (PDOException $e) {
    echo "Connection error: " . $e->getMessage();
    exit;
}
?>
