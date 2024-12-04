<?php
// query_vulnerabilities.php
require_once '../includes/connection.php';
// Initialize the array to store vulnerabilities grouped by month
$vulnerabilitiesByMonth = [];

try {
    // Query to get all vulnerabilities ordered by month/year
    $query = "SELECT * FROM vulns ORDER BY month_year ASC";
    $stmt = $pdo->query($query);

    // Process the vulnerabilities
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        $monthYear = $row['month_year'];

        // If the month doesn't exist in the array, create an empty array
        if (!isset($vulnerabilitiesByMonth[$monthYear])) {
            $vulnerabilitiesByMonth[$monthYear] = [];
        }

        // Add the vulnerability to the corresponding month
        $vulnerabilitiesByMonth[$monthYear][] = [
            'name' => $row['name'],
            'category' => $row['category'],
            'amount' => $row['amount'],
            'severity' => $row['severity']
        ];
    }
} catch (PDOException $e) {
    echo "Error fetching vulnerabilities: " . $e->getMessage();
    exit;
}
?>
