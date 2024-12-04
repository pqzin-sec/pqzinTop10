<?php
require_once '../includes/connection.php';

function insert_vulnerability($name, $category, $amount, $severity, $pdo, $month_year)
{
    if (!isset($month_year)){
        $month_year = date('m');
    }
    
    try {
        $checkSQL = "SELECT * FROM vulns WHERE name = :name AND month_year = :month_year";
        $stmt = $pdo->prepare($checkSQL);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':month_year', $month_year);
        $stmt->execute();
        if ($stmt->fetch()) {
            $updateSQL = "UPDATE vulns SET amount = amount + :amount WHERE name = :name AND month_year = :month_year";
            $stmtUpdate = $pdo->prepare($updateSQL);
            $stmtUpdate->bindParam(':amount', $amount);
            $stmtUpdate->bindParam(':name', $name);
            $stmtUpdate->bindParam(':month_year', $month_year);
            $stmtUpdate->execute();
        } else {
            $insertSQL = "INSERT INTO vulns (name, category, amount, severity, month_year) 
                          VALUES (:name, :category, :amount, :severity, :month_year)";
            $stmtInsert = $pdo->prepare($insertSQL);

            $stmtInsert->bindParam(':name', $name);
            $stmtInsert->bindParam(':category', $category);
            $stmtInsert->bindParam(':amount', $amount);
            $stmtInsert->bindParam(':severity', $severity);
            $stmtInsert->bindParam(':month_year', $month_year);

            $stmtInsert->execute();
        }
    } catch (PDOException $e) {
        echo "Error inserting or updating vulnerability: " . $e->getMessage();
    }
}
